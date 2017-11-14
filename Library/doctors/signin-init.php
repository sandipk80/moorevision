<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$errors = array();
if(isset($_POST['loginsubmit']) && trim($_POST['loginsubmit'])=='login') {
	if(isset($_POST['username']) && trim($_POST['username'])=='') {	
		$errors[] = "E-mail cannot be left blank";
	}
	
	if(isset($_POST['password']) && trim($_POST['password'])=='') {
		$errors[] = "Password cannot be left blank";
	}
	
	if(count($errors)==0) {
		$password = UtilityManager::encrypt_password($_POST['password']);
		##-------GET DOCTOR USER INFO---------##
		$where="email='".$_POST['username']."' AND password='".$password."' AND status='1'";
		$getUser = $globalManager->runSelectQuery('doctors',"*",$where);
		if(is_array($getUser) && count($getUser)>0) {
			$_SESSION['moore']['doctor']['name'] = $getUser[0]['first_name'].' '.$getUser[0]['last_name'];
			$_SESSION['moore']['doctor']['userid'] = $getUser[0]['id'];
            $_SESSION['moore']['doctor']['email'] = $getUser[0]['email'];
            //update last login date
            $condition = "id='".$getUser[0]['id']."'";
            $logindate = array('last_login'=>date("Y-m-d H:i:s"));
            $updateLoginDate = $globalManager->runUpdateQuery("doctors", $logindate, $condition);
			redirect(DOCTOR_SITE_URL."dashboard.php");
		}else {
			$errors[] = "Please enter valid E-mail and password";
		}
	}

}

?>