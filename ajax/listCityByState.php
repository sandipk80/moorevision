<?php
include('../cnf.php');
header("Content-type: application/json; charset=utf-8");
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$arrCities = array();
$strOptions = '<option value="">-- Select City --</option>';
if(isset($_REQUEST['state_id']) && trim($_REQUEST['state_id']) !== ""){
    $where = "status='1' AND state_id='".trim($_REQUEST['state_id'])."' ORDER BY name ASC";
    $result = $globalManager->runSelectQuery('cities','id,name',$where);
    if(is_array($result) && count($result)>0){
        foreach($result as $row){
            $strOptions .= '<option value="'.$row['id'].'">'.utf8_encode($row['name']).'</option>';
            //$arrCities[$row['id']] = utf8_encode($row['name']) ;//preg_replace("/[^a-zA-Z0-9'\s_&-]+/i","",$row['name']);
        }
    }
}
echo $strOptions;
exit;