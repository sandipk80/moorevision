<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//find out logged in user id
$doctorId = $_SESSION['moore']['doctor']['userid'];
//set page title
$pageTitle = "Tickets";


##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	## DELETE users ##
	$where="id='".$_REQUEST['id']."' AND doctor_id='".$doctorId."'";
	$getStatus = $globalManager->runDeleteQuery("tickets",$where);
	if($getStatus) {
		//delete attachments
		$delAttachments = $globalManager->runDeleteQuery("ticket_attachments", "ticket_id='".$_REQUEST['id']."'");
		$_SESSION['message'] ="Record closed successfully.";
		redirect(DOCTOR_SITE_URL."tickets.php");
	}
}
##----------------ACT DELETE END--------------##

##----------------ACT CLOSE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='close' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
	$where="id='".$_REQUEST['id']."' AND doctor_id='".$doctorId."'";
	$tktArray = array('status' => 'closed','modified' => date("Y-m-d H:i:s"));
	$updateTicket = $globalManager->runUpdateQuery("tickets",$tktArray,$where);
	if($updateTicket) {
		$_SESSION['message'] ="Record deleted successfully.";
		redirect(DOCTOR_SITE_URL."tickets.php");
	}
}
##----------------ACT CLOSE END--------------##

$pWhere = "tkt.doctor_id='".$doctorId."'";
$relTable = "tickets as tkt LEFT JOIN doctors as doc ON tkt.doctor_id=doc.id LEFT JOIN ticket_categories as cat ON tkt.ticket_category_id=cat.id";
$relFields = "tkt.*,CONCAT(doc.first_name,' ',doc.last_name) as docname,cat.name as catname";
$result = $globalManager->runSelectQuery($relTable,$relFields,$pWhere);