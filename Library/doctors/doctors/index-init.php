<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = "Doctors";

$recordPerPage = RECORDS_PER_PAGE;
$errors = array();
$sortBy = "d.id";
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

$inOrders['first_name'] = "asc";
$inOrders['email'] = "asc";
$inOrders['fee'] = "asc";
$inOrders['catname'] = "asc";
$inOrders['service'] = "asc";
$inOrders['created'] = "asc";
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
$linkParameters['inOrder'] = $inOrders['first_name'];
$nameUrl = utilityManager::getOrderByUrl("first_name", $linkParameters);

$linkParameters['inOrder'] = $inOrders['fee'];
$feeUrl = utilityManager::getOrderByUrl("fee", $linkParameters);

$linkParameters['inOrder'] = $inOrders['email'];
$emailUrl = utilityManager::getOrderByUrl("email", $linkParameters);

$linkParameters['inOrder'] = $inOrders['catname'];
$catUrl = utilityManager::getOrderByUrl("catname", $linkParameters);

$linkParameters['inOrder'] = $inOrders['service'];
$serviceUrl = utilityManager::getOrderByUrl("service", $linkParameters);

$linkParameters['inOrder'] = $inOrders['created'];
$dateUrl = utilityManager::getOrderByUrl("created", $linkParameters);

$linkParameters['inOrder'] = $inOrders['status'];
$statusUrl = utilityManager::getOrderByUrl("status", $linkParameters);

##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	## DELETE users ##	
	$where="id='".$_REQUEST['id']."'";	
	$getStatus = $globalManager->runDeleteQuery("doctors",$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deleted successfully.";
		redirect($_SERVER['PHP_SELF']);
	}
}
##----------------ACT DELETE END--------------##

##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='active' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'1');
	$getStatus = $globalManager->runUpdateQuery("doctors",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record activated successfully.";
		redirect($_SERVER['PHP_SELF']);
	}
}

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='inactive' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."'";
	$value=array('status'=>'0');
	$getStatus = $globalManager->runUpdateQuery("doctors",$value,$where);
	if($getStatus) {
		$_SESSION['message'] ="Record deactivated successfully.";
		redirect($_SERVER['PHP_SELF']);
	}
}

##----------------ACT DELETE END--------------##

#---------- Paging Start--------------###
$field="d.id";
$table ="doctors as d LEFT JOIN categories as ct ON d.category_id LEFT JOIN services as sv ON d.service_id=sv.id";
$where = "1=1";
if(isset($_REQUEST['search']) && trim($_REQUEST['search'])=='Search' && isset($_REQUEST['searchopt']) && trim($_REQUEST['searchopt'])!=='') {
	$htWhere .= " AND (d.first_name LIKE('%".$_REQUEST['searchopt']."%') || d.last_name LIKE('%".$_REQUEST['searchopt']."%') || d.email LIKE('%".$_REQUEST['searchopt']."%') || d.phone LIKE('%".$_REQUEST['searchopt']."%') || ct.name LIKE('%".$_REQUEST['searchopt']."%') || sv.name LIKE('%".$_REQUEST['searchopt']."%'))";
}

$result = $globalManager->getPagingRecord($table,$field, true, $where);		
$getTotalRecord = $result[0]['total']; 
$pagenumber ="";
if(isset($_REQUEST['page']) && trim($_REQUEST['page'])!=='') {
	$pagenumber = $_REQUEST['page'];
}

if($queryString != ''){
	$linkParam = $queryString.'&amp;';
}else{
	$linkParam = $_SERVER['QUERY_STRING'].'&amp;';
}

if(isset($getTotalRecord) && $getTotalRecord!==0) {	
	$recordPerPage=$recordPerPage;
	require_once(LIB_PATH . '/pagination.php');
	$paging = new pagination;  
	$paging->Items($getTotalRecord);
	$paging->limit($recordPerPage);
	$paging->target(ADMIN_SITE_URL."doctors.php?".$linkParam);
	$pageNumber=utilityManager::checkValidUrlPageNumber($getTotalRecord,$recordPerPage,$pagenumber);
	$paging->currentPage(($pagenumber=='')?'1':$pagenumber);
	$paging->adjacents(2);
	if(!isset($_REQUEST['page'])) { 
		$limit = $recordPerPage;
		$offset ='0';   
	}
	else{   
		$limit = $_REQUEST['page']*$recordPerPage;
		$offset = $limit-$recordPerPage;
	}
}

$pagelimit = $offset.",".$recordPerPage;	
$strSortBy=$sortBy;
$strSortByOrder=$inOrder;
$relTable = "doctors as d LEFT JOIN categories as ct ON d.category_id LEFT JOIN services as sv ON d.service_id=sv.id";
$relFields = "d.*,ct.name as catname,sv.name as service";
$result = $globalManager->getPagingRecord($relTable,$relFields,false, $where, $pagelimit, $strSortBy, $strSortByOrder);
#---------- Paging End--------------###
