<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$result = array();

if(isset($_REQUEST['tid']) && trim($_REQUEST['tid']) !== ""){
	$where = "id='".trim($_REQUEST['tid'])."'";
	
	$getTicket = $globalManager->runSelectQuery('tickets','id,priority,status',$where);
	if(is_array($getTicket) && count($getTicket)>0){
		$result['priority'] = $getTicket[0]['priority'];
        $result['status'] = $getTicket[0]['status'];
	}
}

echo json_encode($result);
exit;