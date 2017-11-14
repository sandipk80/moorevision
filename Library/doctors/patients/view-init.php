<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$pageTitle = "Patient Profile";

if(isset($_GET['id']) && trim($_GET['id'])!==""){
	//find out the patient profile info
	$getUser = $globalManager->runSelectQuery("users as u LEFT JOIN states as st ON u.state_id=st.id LEFT JOIN cities as ct ON u.city_id=ct.id", "u.*,st.name as state,ct.name as city", "u.id='".trim($_GET['id'])."'");
	if(is_array($getUser) && !empty($getUser)){
	    $patient = $getUser[0];
	    //find out the other medical information
	    $getUserInfo = $globalManager->runSelectQuery("user_informations", "*", "user_id='".trim($_GET['id'])."'");
	    if(is_array($getUserInfo) && !empty($getUserInfo)){
	        $patient['history'] = $getUserInfo[0];
	    }else{
	        $patient['history'] = array();
	    }
	}else{
	    $_SESSION['errmsg'] = "Invalid patient selected.";
		redirect(DOCTOR_SITE_URL.'patients.php');
	}
}else{
	$_SESSION['errmsg'] = "No patient selected.";
	redirect(DOCTOR_SITE_URL.'patients.php');
}