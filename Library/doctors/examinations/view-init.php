<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
$pageTitle = "Patient Examination";

$doctorId = $_SESSION['moore']['doctor']['userid'];

if(isset($_POST['next-step']) && $_POST['next-step'] == "Submit"){
	redirect(DOCTOR_SITE_URL.'add-patient-prescription.php?eid='.$_POST['exam_id']);
	exit;
}

if(isset($_GET['eid']) && trim($_GET['eid']) !== ""){
	//find out the examination details
	$getExamination = $globalManager->runSelectQuery("patient_examinations", "*", "id='".$_GET['eid']."'");
	if(is_array($getExamination) && count($getExamination)>0){
		$arrExamination = $getExamination[0];
		extract($getExamination[0]);
		if($exam_left_image !== "" && file_exists(STORAGE_PATH.'examinations/'.$exam_left_image)){
			$exam_left_image = STORAGE_HTTP_PATH.'examinations/'.$exam_left_image;
		}else{
			$exam_left_image = IMG_PATH.'left-eye.png';
		}
		if($exam_right_image !== "" && file_exists(STORAGE_PATH.'examinations/'.$exam_right_image)){
			$exam_right_image = STORAGE_HTTP_PATH.'examinations/'.$exam_right_image;
		}else{
			$exam_right_image = IMG_PATH.'right-eye.png';
		}
	}else{
		$_SESSION['errmsg'] = "Patient examination does not exists";
		redirect(DOCTOR_SITE_URL.'examinations.php');
	}
}else{
	$_SESSION['errmsg'] = "Patient examination does not exists";
	redirect(DOCTOR_SITE_URL.'patients.php');
}