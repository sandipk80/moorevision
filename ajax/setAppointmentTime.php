<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$arrTimes = array();
if(isset($_REQUEST['dt'],$_REQUEST['did']) && trim($_REQUEST['dt']) !== "" && trim($_REQUEST['did']) !== ""){
	$book_date = date("Y-m-d", strtotime($_REQUEST['dt']));
	$where = "doctor_id='".trim($_REQUEST['did'])."' AND DATE(appointment_date)='".$book_date."' AND status='1' ORDER BY appointment_date ASC";
	//echo $where;die;
	$result = $globalManager->runSelectQuery("appointments","appointment_date",$where);
	if(is_array($result) && count($result)>0){
		foreach($result as $t=>$row){
			$arrTimes[$t] = date("g:i A", strtotime($row['appointment_date']));
		}
	}
}
echo json_encode($arrTimes);
exit;