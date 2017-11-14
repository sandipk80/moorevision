<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//find out logged in user id
$doctorId = $_SESSION['moore']['doctor']['userid'];
//set page title
$pageTitle = "Patient Examinations";

##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	## DELETE users ##
	$where="id='".$_REQUEST['id']."' AND doctor_id='".$doctorId."'";
	$getStatus = $globalManager->runDeleteQuery("patient_examinations",$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deleted successfully.";
		redirect(ADMIN_SITE_URL."examinations.php");
	}
}
##----------------ACT DELETE END--------------##

//Find out the list of examinations
$pWhere = "doctor_id='".$doctorId."'";
if(isset($_GET['pid']) && trim($_GET['pid']) !== ""){
	$pWhere .= " AND user_id='".$_GET['pid']."'";
}


$result = $globalManager->runSelectQuery("patient_examinations", "id,user_id,patient_name,age,exam_date,chief_complaint,symptoms,examining_doctor,created", $pWhere);
