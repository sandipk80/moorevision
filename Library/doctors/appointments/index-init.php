<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//find out logged in user id
$doctorId = $_SESSION['moore']['doctor']['userid'];
//set page title
$pageTitle = "Appointments";
##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['hidAct']) && trim($_REQUEST['hidAct'])!=='') {
	//prx($_REQUEST);
	$Ids = explode(",",$_REQUEST['hidAllId']);
	if(isset($_REQUEST['hidAct']) && (trim($_REQUEST['hidAct'])=='Activate' || trim($_REQUEST['hidAct'])=='activate')) {
		$status="1";
	}
	else {
		$status="0";
	}

	if(is_array($Ids) && count($Ids)>0) {
		foreach($Ids as $stausKey=>$statusVal) {
			if($_REQUEST['hidAct']=='Delete') {
				$where="id='".$statusVal."' AND doctor_id='".$doctorId."'";
				$result = $globalManager->runDeleteQuery("appointments",$where);
				//$delInfo = $globalManager->runDeleteQuery("user_informations","user_id='".$statusVal."'");
			}
			else {
				if($statusVal!=='') {
					$where="id='".$statusVal."' AND doctor_id='".$doctorId."'";
					$value=array('status'=>$status);
					$result = $globalManager->runUpdateQuery("appointments",$value,$where);
				}
			}
		}
		if($result) {
			$_SESSION['message'] =	"Record(s) ".$_REQUEST['hidAct']."d successfully.";
			redirect($_SERVER['PHP_SELF']);
		}
		else {
			$_SESSION['message'] =	"Record(s) not ".$_REQUEST['hidAct']."d. Please try again";
			redirect($_SERVER['PHP_SELF']);
		}
	}
}

##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	## DELETE users ##
	$where="id='".$_REQUEST['id']."' AND doctor_id='".$doctorId."'";
	$getStatus = $globalManager->runDeleteQuery("appointments",$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deleted successfully.";
		redirect(ADMIN_SITE_URL."appointments.php");
	}
}
##----------------ACT DELETE END--------------##
//prx($_REQUEST);
##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='active' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."' AND doctor_id='".$doctorId."'";
	$value=array('status'=>'1');
	$getStatus = $globalManager->runUpdateQuery("appointments",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record activated successfully.";
		redirect(ADMIN_SITE_URL."appointments.php");
	}
}

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='inactive' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."' AND doctor_id='".$doctorId."'";
	$value=array('status'=>'0');
	$getStatus = $globalManager->runUpdateQuery("appointments",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deactivated successfully.";
		redirect(ADMIN_SITE_URL."appointments.php");
	}
}

##----------------ACT DELETE END--------------##

$pWhere = "apt.doctor_id='".$doctorId."'";
$relTable = "appointments as apt LEFT JOIN doctors as doc ON apt.doctor_id=doc.id LEFT JOIN categories as cat ON apt.category_id=cat.id LEFT JOIN services as sv ON apt.service_id=sv.id";
$relFields = "apt.*,CONCAT(doc.first_name,' ',doc.last_name) as docname,cat.name as catname,sv.name as service";
$result = $globalManager->runSelectQuery($relTable,$relFields,$pWhere);
