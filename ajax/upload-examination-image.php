<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

if(isset($_POST['image']) && trim($_POST['image']) !== ""){
	$filename = UtilityManager::generateImageName(12).rand();
	$image = imagecreatefrompng($_POST['image']);
	imagealphablending($image, false);
	imagesavealpha($image, true);
	imagepng($image, STORAGE_PATH.'examinations/' . $filename . '.png');

	// return image path
	echo '{"img": "' . $filename . '.png"}';
}