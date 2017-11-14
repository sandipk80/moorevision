<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//set page title
$pageTitle = 'Categories';

##----------------ACT ACTIVE AND INACTIVE START--------------##
#########################  ACTIVATE/DEACTIVATE/DELETE MULTIPLE #########################################
if(isset($_REQUEST['hidAct']) && trim($_REQUEST['hidAct'])!=='') {
    //prx($_REQUEST);
    $Ids = explode(",",$_REQUEST['hidAllId']);
    if(isset($_REQUEST['hidAct']) && (trim($_REQUEST['hidAct'])=='Activate' || trim($_REQUEST['hidAct'])=='activate')) {
        $status="1";
    }
    else {
        $status="0";
    }

    if(is_array($Ids) && count($Ids)>0) {
        foreach($Ids as $stausKey=>$statusVal) {
            if($_REQUEST['hidAct']=='Delete') {
                $where="id='".$statusVal."'";
                $result = $globalManager->runDeleteQuery("categories",$where);
                $delInfo = $globalManager->runDeleteQuery("services","category_id='".$statusVal."'");
            }
            else {
                if($statusVal!=='') {
                    $where="id='".$statusVal."'";
                    $value=array('status'=>$status);
                    $result = $globalManager->runUpdateQuery("categories",$value,$where);
                }
            }
        }
        if($result) {
            $_SESSION['message'] =	"Record(s) ".$_REQUEST['hidAct']."d successfully.";
            redirect($_SERVER['PHP_SELF']);
        }
        else {
            $_SESSION['message'] =	"Record(s) not ".$_REQUEST['hidAct']."d. Please try again";
            redirect($_SERVER['PHP_SELF']);
        }
    }
}
######################### END ACTIVATE/DEACTIVATE/DELETE MULTIPLE #########################################

##----------------ACT DELETE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='delete' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    ## DELETE users ##
    $where="id='".$_REQUEST['id']."'";
    $getStatus = $globalManager->runDeleteQuery("categories",$where);
    if($getStatus) {
        $delInfo = $globalManager->runDeleteQuery("services","category_id='".$_REQUEST['id']."'");
        $_SESSION['message'] ="Record deleted successfully.";
        redirect(ADMIN_SITE_URL."categories.php");
    }
}
##----------------ACT DELETE END--------------##
//prx($_REQUEST);
##----------------ACT ACTIVE AND INACTIVE START--------------##
if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='active' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    $where="id='".$_REQUEST['id']."'";
    $value=array('status'=>'1');
    $getStatus = $globalManager->runUpdateQuery("categories",$value,$where);
    if($getStatus) {
        $_SESSION['message'] ="Record activated successfully.";
        redirect(ADMIN_SITE_URL."categories.php");
    }
}

if(isset($_REQUEST['act']) && trim($_REQUEST['act'])=='inactive' && isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    $where="id='".$_REQUEST['id']."'";
    $value=array('status'=>'0');
    $getStatus = $globalManager->runUpdateQuery("categories",$value,$where);
    if($getStatus) {
        $_SESSION['message'] ="Record deactivated successfully.";
        redirect(ADMIN_SITE_URL."categories.php");
    }
}

##----------------ACT DELETE END--------------##

$htWhere = "1=1";
$relTable = "categories";
$relFields = "*";
$result = $globalManager->runSelectQuery($relTable,$relFields,$htWhere);
#---------- Paging End--------------###
