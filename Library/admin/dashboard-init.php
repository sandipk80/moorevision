<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();		

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='logout') {
	session_destroy();
	redirect(SITE_URL."admin/index.php");
	exit;
}

//find out the count of total dealers
$where = "";
$dealerQuery = $globalManager->runSelectQuery('dealers','count(id) as total',$where);
$totalDealers = $dealerQuery[0]['total'];

//find out the count of total owners
$where = "status='1'";
$ownersQuery = $globalManager->runSelectQuery('owners','count(id) as total',$where);
$totalOwners = $ownersQuery[0]['total'];

//find out the count of total messages
$where = "";
$messagesQuery = $globalManager->runSelectQuery('messages','count(id) as total',$where);
$totalMessages = $messagesQuery[0]['total'];

?>