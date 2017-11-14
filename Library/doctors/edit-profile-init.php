<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
//find out logged in user id
$doctorId = $_SESSION['moore']['doctor']['userid'];
$pageTitle = "Doctor Profile";
$error = array();
$output_dir = STORAGE_PATH."doctors/";
if(isset($_POST) && isset($_POST['edit-profile']) && trim($_POST['edit-profile'])=='submit') {
    if(isset($_POST['first_name']) && trim($_POST['first_name'])=='') {
        $error[] = 'Doctor first name is required';
    }else{
        $first_name = trim($_POST['first_name']);
    }
    if(isset($_POST['last_name']) && trim($_POST['last_name'])=='') {
        $error[] = 'Doctor last name is required';
    }else{
        $last_name = trim($_POST['last_name']);
    }
    
    if(isset($_POST['fee']) && trim($_POST['fee'])=='') {
        $error[] = 'Doctor fee is required';
    }else{
        $fee = trim($_POST['fee']);
    }
    
    if(isset($_POST['category_id']) && trim($_POST['category_id'])=='') {
        $error[] = 'Doctor category is required';
    }else{
        $category_id = trim($_POST['category_id']);
    }

    if(isset($_POST['service_id']) && trim($_POST['service_id'])=='') {
        $error[] = 'Doctor service is required';
    }else{
        $service_id = trim($_POST['service_id']);
    }
    if(isset($_POST['phone']) && trim($_POST['phone'])=='') {
        //$error[] = 'Doctor service is required';
    }else{
        $phone = trim($_POST['phone']);
    }

    if(isset($_POST['address']) && trim($_POST['address'])=='') {
        $error[] ="Please enter address";
    }else{
        $address = trim($_POST['address']);
    }

    if(isset($_POST['city_id']) && trim($_POST['city_id'])=='') {
        $error[] ="Please select city";
        $city_id = '';
    }else{
        $city_id = trim($_POST['city_id']);
    }

    if(isset($_POST['state_id']) && trim($_POST['state_id'])=='') {
        $error[] ="Please select state";
        $state_id = '';
    }else{
        $state_id = trim($_POST['state_id']);
    }
    if(isset($_POST['zipcode']) && trim($_POST['zipcode'])=='') {
        $error[] ="Please enter zipcode";
    }else{
        $zipcode = trim($_POST['zipcode']);
    }
    if(isset($_POST['intro_text']) && trim($_POST['intro_text'])=='') {
        $error[] ="Please enter intro text of doctor";
    }else{
        $intro_text = trim($_POST['intro_text']);
    }

    if(empty($error)){
        //upload image
        $filename = $_POST['pre_doc_photo'];
        if(empty($error)) {
            if (isset($_FILES['primary_image']) && $_FILES['primary_image']['tmp_name'] != '') {
                $file_name = $_FILES['primary_image']['name'];
                $file_size = $_FILES['primary_image']['size'];
                $file_tmp = $_FILES['primary_image']['tmp_name'];
                $file_type = $_FILES['primary_image']['type'];

                //check the file extension
                $extensions = array("jpeg", "jpg", "png", "bmp", "gif");
                // $file_ext = explode('.', $_FILES['primary_image']['name']);
                //$cnt = count($file_ext);
                $file_ext = pathinfo($_FILES['primary_image']['name'], PATHINFO_EXTENSION);
                $file_ext = strtolower($file_ext);
                if (in_array($file_ext, $extensions) === false) {
                    $error[] = $file_name . " is not uploaded as extension not allowed for doctor image " . $file_name . '<br>';
                }

                //check the file size
                if ($file_size > 2097152) {
                    $error[] = $file_name . ' is not uploaded as file size must be less than 2 MB for image ' . $file_name . '<br>';
                }

                if (empty($error)) {
                    $filename = UtilityManager::generateImageName(12).'.' . $file_ext;
                    $normalDestination = STORAGE_PATH . "doctors/" . $filename;
                    $httpRootSmall = STORAGE_PATH . "doctors/small/" . $filename;
                    $httpRootThumb = STORAGE_PATH . "doctors/thumbs/" . $filename;
                    move_uploaded_file($file_tmp, $output_dir . $filename);
                    UtilityManager::createThumb($normalDestination,$httpRootSmall,500,375);
                    #For 120x80 Thumb
                    UtilityManager::createThumb($normalDestination,$httpRootThumb,300,225);
                }
            }
        }

        $where = "id='".$doctorId."'";
        $doctorArray = array(
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'fee' => $_POST['fee'],
            'category_id' => $_POST['category_id'],
            'service_id' => $_POST['service_id'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'state_id' => $_POST['state_id'],
            'city_id' => $_POST['city_id'],
            'zipcode' => $_POST['zipcode'],
            'intro_text' => $_POST['intro_text'],
            'modified' => date("Y-m-d H:i:s")
        );
        if($filename !== ""){
            $doctorArray['picture'] = $filename;
        }

        $saveDoctor = $globalManager->runUpdateQuery('doctors',$doctorArray,$where);
        $_SESSION['message'] ="Doctor profile has been updated successfully.";
        redirect(DOCTOR_SITE_URL."profile.php");
    }
}

//find out the doctor profile
$where = "id = '".$doctorId."'";
$result = $globalManager->runSelectQuery("doctors","*",$where);
if(is_array($result) && count($result)>0) {
    $result[0] = array_map("utf8_encode", $result[0]);
    $first_name = $result[0]['first_name'];
    $last_name = $result[0]['last_name'];
    $email = $result[0]['email'];
    $fee = $result[0]['fee'];
    $category_id = $result[0]['category_id'];
    $service_id = $result[0]['service_id'];
    $phone = $result[0]['phone'];
    $address = $result[0]['address'];
    $state_id = $result[0]['state_id'];
    $city_id = $result[0]['city_id'];
    $zipcode = $result[0]['zipcode'];
    $intro_text = $result[0]['intro_text'];
    $docImage =  $result[0]['picture'];
}else{
    redirect(DOCTOR_SITE_URL);
}

//find out the list of all the owners
$arrCategories = $globalManager->runSelectQuery("categories", "id,name", "status='1'");

//find out the us states
$arrStates = $globalManager->runSelectQuery("states", "id,name", "country_id='237' AND status='1'");