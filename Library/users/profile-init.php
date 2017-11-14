<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "User Profile";

//find out logged in user id
$userId = $_SESSION['moore']['user']['userid'];

//find out the patient profile info
$getUser = $globalManager->runSelectQuery("users as u LEFT JOIN states as st ON u.state_id=st.id LEFT JOIN cities as ct ON u.city_id=ct.id", "u.*,st.name as state,ct.name as city", "u.id='".$userId."'");
if(is_array($getUser) && !empty($getUser)){
    $patient = $getUser[0];
    //find out the other medical information
    $getUserInfo = $globalManager->runSelectQuery("user_informations", "*", "user_id='".$userId."'");
    if(is_array($getUserInfo) && !empty($getUserInfo)){
        $patient['history'] = $getUserInfo[0];
    }else{
        $patient['history'] = array();
    }

    //find out the user's appointments
    ##----------------ACT DELETE START--------------##
	if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
		## DELETE users ##
		$where="id='".$_REQUEST['id']."' AND user_id='".$userId."'";
		$getStatus = $globalManager->runDeleteQuery("appointments",$where);
		if($getStatus) {
			$_SESSION['message'] ="Record deleted successfully.";
			redirect(ADMIN_SITE_URL."appointments.php");
		}
	}
	##----------------ACT DELETE END--------------##

	$pWhere = "apt.user_id='".$userId."'";
	$relTable = "appointments as apt LEFT JOIN doctors as doc ON apt.doctor_id=doc.id LEFT JOIN categories as cat ON apt.category_id=cat.id LEFT JOIN services as sv ON apt.service_id=sv.id";
	$relFields = "apt.*,CONCAT(doc.first_name,' ',doc.last_name) as docname,cat.name as catname,sv.name as service";
	$result = $globalManager->runSelectQuery($relTable,$relFields,$pWhere);
	if(is_array($result) && count($result)>0){
		$patient['appointments'] = $result;
	}else{
		$patient['appointments'] = array();
	}

	//find out the list of doctors whom contacted
	$dWhere = "d.status='1'";
	$arrDoctors = $globalManager->runSelectQuery("doctors as d LEFT JOIN conversations as c ON d.id=c.doctor_id AND c.user_id='".$userId."'", "d.id as docId,CONCAT(d.first_name,' ',d.last_name) as docname,d.picture,IFNULL(c.id,0) as conversationId", $dWhere);
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
				$arrDoctors[$k]['conversation_id'] = $uRow['conversationId'];
			}else{
				$arrDoctors[$k]['last_msg'] = "";
				$arrDoctors[$k]['msg_date'] = "";
				$arrDoctors[$k]['msg_count'] = 0;
				//create conversation id
				$roomKey = UtilityManager::generateUniqueSecurityCode(32);
				$conArray = array(
					'user_id' => $userId,
					'doctor_id' => $uRow['docId'],
					'room_code' => $roomKey
				);
				$saveConversation = $globalManager->runInsertQuery("conversations", $conArray);
				$arrDoctors[$k]['conversation_id'] = $saveConversation;
			}
		}
	}


}else{
    redirect(USER_SITE_URL);
}
//prx($patient);