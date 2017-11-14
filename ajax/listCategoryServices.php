<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$arrStates = array();
$strOptions = '<option value="">-- Select Service --</option>';
if(isset($_REQUEST['cid']) && trim($_REQUEST['cid']) !== ""){
	$where = "status='1' AND category_id='".trim($_REQUEST['cid'])."' ORDER BY name ASC";
	
	$result = $globalManager->runSelectQuery('services','id,name',$where);
	if(is_array($result) && count($result)>0){
		foreach($result as $row){
            $strOptions .= '<option value="'.$row['id'].'">'.utf8_encode($row['name']).'</option>';
		}
	}
}
echo $strOptions;
exit;