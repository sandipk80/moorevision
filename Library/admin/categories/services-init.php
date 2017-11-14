<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = 'Services';

$recordPerPage = RECORDS_PER_PAGE;
$errors = array();
$sortBy = "id";
$inOrder = "desc";
$pageNumber = 1;

if(isset($_REQUEST['sortBy']) && trim($_REQUEST['sortBy'])!==''){
	$sortBy = $_REQUEST['sortBy'];
}

if(isset($_REQUEST['inOrder']) && trim($_REQUEST['inOrder'])!==''){
	$inOrder = $_REQUEST['inOrder'];
}

if(isset($_REQUEST['page']) && trim($_REQUEST['page'])!==''){
	$pageNumber = $_REQUEST['page'];
}

$urlParameters = array(	
	'sortBy' => $sortBy,
	'inOrder' => $inOrder,
	'page'=>$pageNumber
);

$inOrders['name'] = "asc";
$inOrders['status'] = "asc";

if(utilityManager::notEmpty($sortBy) && utilityManager::notEmpty($inOrder)){
	if($inOrder == "asc"){
		$inOrders[$sortBy] = "desc";
	}else{
		$inOrders[$sortBy] = "asc";
	}
}	

$linkParameters = $urlParameters;
$queryString = utilityManager::makeQueryString($linkParameters);
$linkParameters['inOrder'] = $inOrders['name'];
$nameUrl = utilityManager::getOrderByUrl("name", $linkParameters);

##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	## DELETE users ##	
	$where="id='".$_REQUEST['id']."'";
	$getStatus = $globalManager->runDeleteQuery("services",$where);
	if($getStatus) {
		$_SESSION['message'] = "Record deleted successfully.";
		redirect($_SERVER['PHP_SELF']);
	}
}
##----------------ACT DELETE END--------------##

//get services
if(isset($_GET['cid']) && trim($_GET['cid'])!==""){
	$sWhere = "s.category_id='".trim($_GET['cid'])."'";
}else{
	$sWhere = "1=1";
}
$result = $globalManager->runSelectQuery("services as s LEFT JOIN categories as ct ON s.category_id=ct.id", "s.*,ct.name  as catname", $sWhere);