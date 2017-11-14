<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$arrStates = array();
$strOptions = '<option value="">-- Select Doctor --</option>';
if(isset($_REQUEST['cid']) && trim($_REQUEST['cid']) !== "" && isset($_REQUEST['sid']) && trim($_REQUEST['sid']) !== ""){
	$where = "category_id='".trim($_REQUEST['cid'])."' AND service_id='".trim($_REQUEST['sid'])."' AND status='1' ORDER BY name ASC";
	
	$result = $globalManager->runSelectQuery("doctors","id,CONCAT(first_name,' ',last_name) as name,fee",$where);
	if(is_array($result) && count($result)>0){
		foreach($result as $row){
			if($row['fee'] !== ""){
				$fee = "$".$row['fee'];
			}else{
				$fee = "Fee not mentioned";
			}
            $strOptions .= '<option value="'.$row['id'].'">'.utf8_encode($row['name']).' ('.$fee.')</option>';
		}
	}
}
echo $strOptions;
exit;