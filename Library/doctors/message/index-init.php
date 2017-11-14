<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

$doctorId = $_SESSION['moore']['doctor']['userid'];

//set page title
$pageTitle = "Messages";

if(isset($_GET['room']) && trim($_GET['room']) !== ""){
	$userId = trim($_GET['room']);
	//check for valid user
	$getUser = $globalManager->runSelectQuery("users", "COUNT(id) as total", "id='".$userId."'");
	if($getUser[0]['total'] < 1){
		$_SESSION['errmsg'] = "Invalid room selected";
		redirect(DOCTOR_SITE_URL.'message.php');
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
			'room_code' => $roomKey,
			'modified' => date("Y-m-d H:i:s")
		);
		$saveConversation = $globalManager->runInsertQuery("conversations", $conArray);
		$conversation_id = $saveConversation;
	}
}else{
	$conversation_id = "";
	$userId = "";
}

//find out the list of doctors whom contacted
$uWhere = "u.status='1' AND u.active='1'";
$arrPatients = $globalManager->runSelectQuery("users as u LEFT JOIN conversations as c ON u.id=c.user_id", "u.id as userId,CONCAT(u.firstname,' ',u.lastname) as username,IFNULL(c.id,0) as conversationId", $uWhere);
if(is_array($arrPatients) && count($arrPatients)>0){
	foreach($arrPatients as $k=>$uRow){
		if($uRow['conversationId']){
			//find out the last message
			$getMessage = $globalManager->runSelectQuery("messages", "message,msg_date", "conversation_id='".$uRow['conversationId']."' ORDER BY msg_date DESC LIMIT 1");
			if(is_array($getMessage) && count($getMessage)>0){
				$arrPatients[$k]['last_msg'] = $getMessage[0]['message'];
				$arrPatients[$k]['msg_date'] = $getMessage[0]['msg_date'];
				//find out the count of total unread messages
				$getMessageCount = $globalManager->runSelectQuery("messages", "IFNULL(COUNT(id),0) as total", "conversation_id='".$uRow['conversationId']."' AND doctor_flag='0'");
				$arrPatients[$k]['msg_count'] = $getMessageCount[0]['total'];
			}else{
				$arrPatients[$k]['last_msg'] = "";
				$arrPatients[$k]['msg_date'] = "";
				$arrPatients[$k]['msg_count'] = 0;
			}
		}else{
			$arrPatients[$k]['last_msg'] = "";
			$arrPatients[$k]['msg_date'] = "";
			$arrPatients[$k]['msg_count'] = 0;
		}
	}
}
//update flag
if(isset($_GET['room']) && trim($_GET['room']) !== ""){
	$msgArray = array('doctor_flag'=>'1');
	$saveFlag = $globalManager->runUpdateQuery("messages", $msgArray, "user_id='".trim($_GET['room'])."' AND doctor_id='".$doctorId."'");
}