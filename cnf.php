<?php
ob_start();
session_start();
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

define('SITE_URL', "http://" . $_SERVER['HTTP_HOST'] . "/doctorsapp/");
define('HOSTNAME', $_SERVER['HTTP_HOST']);

define('SITE_NAME', 'Moore Vision Optometry');
define('ADMIN_SITE_URL', SITE_URL . 'admin/');
define('DOCTOR_SITE_URL', SITE_URL . 'doctors/');
define('USER_SITE_URL', SITE_URL);

define('PATH', dirname (__FILE__) . '/');
define('LIB_PATH', PATH . 'Library/');
define('VENDOR_PATH', PATH . 'Vendors/');
define('LIB_HTML', PATH . 'html/');
define('AJAX_PATH', SITE_URL . 'ajax/');
define("IMG_PATH", SITE_URL."images/");
define('SCRIPT_SITE_URL', SITE_URL . 'script/');
define('CSS_SITE_URL', SITE_URL . 'css/');
define('ASSET_SITE_URL', SITE_URL . 'assets/');
define('STORAGE_PATH', PATH . 'Storage/');
define("STORAGE_HTTP_PATH", SITE_URL.'Storage/');

define('SUPPORT_EMAIL', 'web.codebyte@gmail.com');
define('SUPPORT_EMAIL_USERNAME', 'Doctors App Support');
define('SUPPORT_EMAIL_PASSWORD', 'saN2010d!P');
define('MOORE_SUPPORT_EMAIL', 'info@moorevisonoptometry.com');

define('MOORE_SUPPORT_PHONE', '(323) 662-9629');

define('ADMIN_EMAIL', 'web.codebyte@gmail.com');
define('ADMIN_EMAIL_USERNAME', 'Moore Vision Admin');

define('PER_PAGE', 2);
define('RECORDS_PER_PAGE', 20);
define('DATE_FORMAT', "Y-m-d");

if(isset($_SESSION['userid']) && $_SESSION['userid']!=='') {
	$user_id= $_SESSION['userid'];
}
else {
	$user_id="";
}

require_once(LIB_PATH . 'model.php');
require_once(LIB_PATH . 'UtilityManager.php');


function quickLog($message, $severity = 'DEBUG') {
  //print $message;  
}
function redirect($url) {
  header("Location:" . $url);
  exit; 
}
function pr($data) {
  print '<pre>';
  print_r($data);
  print '</pre>';
}
function prx($data) {
  print '<pre>';
  print_r($data);
  die;
}

function img_url($image) 
{
    return IMAGE_URL . $image;
}
function filterHtml($string) {
	return htmlentities($string, ENT_NOQUOTES, "utf-8");
}


function displaySortArrow($strPSortByField,$strCurrentSortBy='',$strPOrder){	
	$strSortArrow="";	
	if($strPSortByField == $strCurrentSortBy){
		if(strcasecmp($strPOrder,'ASC')==0){
			$strSortArrow = '<img hspace="5" src="'.IMG_PATH.'/down.gif" border="0" alt="Down"/>';
		}else{
			$strSortArrow = '<img hspace="5" src="'.IMG_PATH.'/up.gif" border="0" alt="Up"/>';
		}
	}
	
	echo $strSortArrow;
}

function displayUserSortArrow($strPSortByField,$strCurrentSortBy='',$strPOrder){
	$strSortArrow="";	
	if($strPSortByField == $strCurrentSortBy){
		if(strcasecmp($strPOrder,'ASC')==0){
			$strSortArrow = '<img align="absmiddle"  hspace=5 src="'.IMG_PATH.'/down.gif" border="0" alt="Down">';
		}else{
			$strSortArrow = '<img align="absmiddle" hspace=5 src="'.IMG_PATH.'/up.gif" border="0" alt="Up">';
		}
	}
	
	echo $strSortArrow;
}

function getPageName() {
	$currentFile = $_SERVER["PHP_SELF"];
	$parts = Explode('/', $currentFile);
	return $parts[count($parts) - 1];
}
/*
	Return the contents of remote $url, using file_get_contents() if possible, otherwise curl functions
*/
function retrieve_url($url)	{
		$contents=@file_get_contents($url);		
		if ((!strlen($contents)) && function_exists('curl_exec')) {
			$curl=curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$contents=@curl_exec($curl);
			curl_close($curl);
		}		
		return $contents;
}
function validateLogin() {
	if(isset($_SESSION['user_id']) && trim($_SESSION['user_id'])=='') {
		redirect(SITE_URL);
		exit;
	}
	if(!isset($_SESSION['user_id'])) {
		redirect(SITE_URL);
		exit;
	}
}
function validateAdminLogin() {
	if(isset($_SESSION['admin_userid']) && trim($_SESSION['admin_userid'])=='') {
		redirect(ADMIN_SITE_URL);
		exit;
	}
	if(!isset($_SESSION['admin_userid'])) {
		redirect(ADMIN_SITE_URL);
		exit;
	}
}

function validateDoctorLogin() {
    if(isset($_SESSION['moore']['doctor']['userid']) && trim($_SESSION['moore']['doctor']['userid'])=='') {
        redirect(DOCTOR_SITE_URL);
        exit;
    }
    if(!isset($_SESSION['moore']['doctor']['userid'])) {
        redirect(DOCTOR_SITE_URL);
        exit;
    }
}

function validateUserLogin() {
	if(isset($_SESSION['moore']['user']['userid']) && trim($_SESSION['moore']['user']['userid'])=='') {
		redirect(USER_SITE_URL);
		exit;
	}
	if(!isset($_SESSION['moore']['user']['userid'])) {
		redirect(USER_SITE_URL);
		exit;
	}
}
?>
