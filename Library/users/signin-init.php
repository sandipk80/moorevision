<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$errors = array();
if(isset($_POST['user-login']) && trim($_POST['user-login'])=='login') {
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
		$getUser = $globalManager->runSelectQuery('users',"*",$where);
		if(is_array($getUser) && count($getUser)>0) {
			if($getUser[0]['active'] == "0"){
                $_SESSION['errmsg'] = "Your registration is not completed yet. Please complete your registration first.";
                redirect(USER_SITE_URL.'signup-step.php?t='.$getUser[0]['code']);
            }else {
                $_SESSION['moore']['user']['name'] = $getUser[0]['firstname'] . ' ' . $getUser[0]['lastname'];
                $_SESSION['moore']['user']['userid'] = $getUser[0]['id'];
                $_SESSION['moore']['user']['email'] = $getUser[0]['email'];
                //update last login date
                $condition = "id='" . $getUser[0]['id'] . "'";
                $logindate = array('last_login' => date("Y-m-d H:i:s"));
                $updateLoginDate = $globalManager->runUpdateQuery("users", $logindate, $condition);
                redirect(USER_SITE_URL);
            }
		}else {
			$errors[] = "Please enter valid E-mail and password";
		}
	}

}

?>