<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

$userId = $_SESSION['moore']['user']['userid'];

//set page title
$pageTitle = "Messages";

if(isset($_GET['room']) && trim($_GET['room']) !== ""){
	$doctorId = trim($_GET['room']);
	//check for valid user
	$getDoctor = $globalManager->runSelectQuery("doctors", "COUNT(id) as total", "id='".$doctorId."'");
	if($getDoctor[0]['total'] < 1){
		$_SESSION['errmsg'] = "Invalid room selected";
		redirect(USER_SITE_URL.'message.php');
	}

	//find out the conversation id
	$getConversation = $globalManager->runSelectQuery("conversations", "id", "user_id='".$userId."' AND doctor_id='".$doctorId."'");
	if(is_array($getConversation) && count($getConversation)>0){
		$conversation_id = $getConversation[0]['id'];
	}else{
		//create conversation
		$roomKey = UtilityManager::generateUniqueSecurityCode(32);
		$conArray = array(
			'user_id' => $userId,
			'doctor_id' => $doctorId,
			'room_code' => $roomKey
		);
		$saveConversation = $globalManager->runInsertQuery("conversations", $conArray);
		$conversation_id = $saveConversation;
	}
}else{
	$conversation_id = "";
}

//find out the list of doctors whom contacted
$dWhere = "d.status='1'";
$arrDoctors = $globalManager->runSelectQuery("doctors as d LEFT JOIN conversations as c ON d.id=c.doctor_id", "d.id as docId,CONCAT(d.first_name,' ',d.last_name) as docname,d.picture,IFNULL(c.id,0) as conversationId", $dWhere);
if(is_array($arrDoctors) && count($arrDoctors)>0){
	foreach($arrDoctors as $k=>$uRow){
		if($uRow['conversationId']){
			//find out the last message
			$getMessage = $globalManager->runSelectQuery("messages", "message,msg_date", "conversation_id='".$uRow['conversationId']."' ORDER BY msg_date DESC LIMIT 1");
			if(is_array($getMessage) && count($getMessage)>0){
				$arrDoctors[$k]['last_msg'] = $getMessage[0]['message'];
				$arrDoctors[$k]['msg_date'] = $getMessage[0]['msg_date'];
				//find out the count of total unread messages
				$getMessageCount = $globalManager->runSelectQuery("messages", "IFNULL(COUNT(id),0) as total", "conversation_id='".$uRow['conversationId']."' AND patient_flag='0'");
				$arrDoctors[$k]['msg_count'] = $getMessageCount[0]['total'];
			}else{
				$arrDoctors[$k]['last_msg'] = "";
				$arrDoctors[$k]['msg_date'] = "";
				$arrDoctors[$k]['msg_count'] = 0;
			}
		}else{
			$arrDoctors[$k]['last_msg'] = "";
			$arrDoctors[$k]['msg_date'] = "";
			$arrDoctors[$k]['msg_count'] = 0;
		}
	}
}

//update flag
if(isset($_GET['room']) && trim($_GET['room']) !== ""){
	$msgArray = array('patient_flag'=>'1');
	$saveFlag = $globalManager->runUpdateQuery("messages", $msgArray, "user_id='".$userId."' AND doctor_id='".trim($_GET['room'])."'");
}