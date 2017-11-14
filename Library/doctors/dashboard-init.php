<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();		
//find out logged in user id
$doctorId = $_SESSION['moore']['doctor']['userid'];
$pageTitle = "Doctor dashboard";

//find out the total open tickets
$arrActiveTickets = $globalManager->runSelectQuery("tickets", "IFNULL(COUNT(id),0) as total", "doctor_id='".$doctorId."' AND status='open'");
$openTickets = $arrActiveTickets[0]['total'];

//find out the total pending tickets
$pendingTickets = $globalManager->runSelectQuery("tickets", "IFNULL(COUNT(id),0) as total", "doctor_id='".$doctorId."' AND status='pending'");
$pendingTickets = $pendingTickets[0]['total'];

//find out the total closed tickets
$getCloseTickets = $globalManager->runSelectQuery("tickets", "IFNULL(COUNT(id),0) as total", "doctor_id='".$doctorId."' AND status='closed'");
$closedTickets = $getCloseTickets[0]['total'];

//find out the Patients
$arrPatients = $globalManager->runSelectQuery("users as u LEFT JOIN states as st ON u.state_id=st.id LEFT JOIN cities as ct ON u.city_id=ct.id", "u.*,st.name as state,ct.name as city", "u.status='1' AND u.active='1'");

//find out the total upcoming appointments
$getComingAppointments = $globalManager->runSelectQuery("appointments", "IFNULL(COUNT(id),0) as total", "doctor_id='".$doctorId."' AND DATE(appointment_date)>=CURDATE() AND status='1'");
$comingAppointments = $getComingAppointments[0]['total'];

//find out the total past appointments
$getPastAppointments = $globalManager->runSelectQuery("appointments", "IFNULL(COUNT(id),0) as total", "doctor_id='".$doctorId."' AND DATE(appointment_date)<CURDATE() AND status='1'");
$pastAppointments = $getPastAppointments[0]['total'];


//find out the latest conversation id
$getConversation = $globalManager->runSelectQuery("conversations", "id", "doctor_id='".$doctorId."' ORDER BY modified DESC");
if(is_array($getConversation) && count($getConversation)>0){
	$conversation_id = $getConversation[0]['id'];
	//update flag
	$msgArray = array('doctor_flag'=>'1');
	$saveFlag = $globalManager->runUpdateQuery("messages", $msgArray, "conversation_id='".$conversation_id."' AND doctor_id='".$doctorId."'");

	//find out the doctor details
    $dWhere = "c.id='".$conversation_id."'";
	$arrPatient = $globalManager->runSelectQuery("conversations as c LEFT JOIN doctors as d ON c.doctor_id=d.id LEFT JOIN users as u ON c.user_id=u.id", "u.id as userId,CONCAT(u.firstname,' ',u.lastname) as username,d.picture as docPic", $dWhere);
	if(is_array($arrPatient) && count($arrPatient)>0){
		if($arrPatient[0]['docPic'] !== "" && file_exists(STORAGE_PATH.'doctors/'.$arrPatient[0]['docPic'])){
			$docImage = STORAGE_HTTP_PATH.'doctors/'.$arrPatient[0]['docPic'];
		}else{
			$docImage = IMG_PATH.'doctor.jpg';
		}
		$username = $arrPatient[0]['username'];
	}
	
    //find out the earlier messages of this room of last 1 month
	$mWhere = "conversation_id='".$conversation_id."'";// AND msg_date BETWEEN CURDATE() - INTERVAL 60 DAY AND NOW()";
	$arrMessages = $globalManager->runSelectQuery("messages", "*", $mWhere);
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

?>