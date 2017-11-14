<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$result = array();

if(isset($_REQUEST['pid']) && trim($_REQUEST['pid']) !== ""){
	$where = "status='1' AND active='1' AND id='".trim($_REQUEST['pid'])."'";
	
	$getUser = $globalManager->runSelectQuery('users','id,firstname,lastname,email',$where);
	if(is_array($getUser) && count($getUser)>0){
		$result['name'] = ucwords($getUser[0]['firstname']. ' '.$getUser[0]['lastname']);
        $result['email'] = $getUser[0]['email'];
	}
}

echo json_encode($result);
exit;