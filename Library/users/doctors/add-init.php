<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

if(isset($_REQUEST['id']) && $_REQUEST['id'] !== ""){
    $pageTitle = "Edit Doctor";
}else{
    $pageTitle = "Add Doctor";
}
$error = array();

if(isset($_POST) && isset($_POST['add-doctor']) && trim($_POST['add-doctor'])=='submit') {
    if(isset($_POST['first_name']) && trim($_POST['first_name'])=='') {
        $error = 'Doctor first name is required';
    }else{
        $first_name = trim($_POST['first_name']);
    }
    if(isset($_POST['last_name']) && trim($_POST['last_name'])=='') {
        $error = 'Doctor last name is required';
    }else{
        $last_name = trim($_POST['last_name']);
    }
    if(isset($_POST['email']) && trim($_POST['email'])=='') {
        $error = 'Doctor email is required';
    }else{
        $email = trim($_POST['email']);
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

    if(empty($error)){
        if(isset($_POST['did']) && trim($_POST['did'])!=='') {
            $doctorId = $_POST['did'];
            $where = "id='".$doctorId."'";
            $doctorArray = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'fee' => $_POST['fee'],
                'category_id' => $_POST['category_id'],
                'service_id' => $_POST['service_id'],
                'phone' => $_POST['phone'],
                'modified' => date("Y-m-d H:i:s")
            );
            $saveDoctor = $globalManager->runUpdateQuery('doctors',$doctorArray,$where);
            $_SESSION['message'] ="Doctor has been updated successfully.";
            redirect(ADMIN_SITE_URL."doctors.php");
        }else{
            $password = UtilityManager::generateUniqueKey(6);
            $encPassword = UtilityManager::encrypt_password($password);
            //add new dealer
            $doctorArray = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => $encPassword,
                'fee' => $_POST['fee'],
                'category_id' => $_POST['category_id'],
                'service_id' => $_POST['service_id'],
                'phone' => $_POST['phone'],
                'status' => '1',
                'modified' => date("Y-m-d H:i:s"),
                'created' => date("Y-m-d H:i:s")
            );
            $addDoctor = $globalManager->runInsertQuery('doctors',$doctorArray);
            if($addDoctor){
                //find out the menu id
                $doctorId = $addDoctor;
                //find out the name of category and service
                $getCategory = $globalManager->runSelectQuery("services as sv LEFT JOIN categories as ct ON sv.category_id=ct.id", "ct.name as catname,sv.name as service", "sv.id='".$_POST['service_id']."'");
                ############ SEND EMAIL FOR VERIFICATION #############
                $userName = $_POST['first_name'];
                $userEmail = $_POST['email'];
                $message = 'Dear '.$userName;
                $message .= '<p>Our '.SITE_NAME.' team has created an account for you. Below are your account details:</p>';
                $message .= '<p><strong>Name:</strong> '.$_POST['first_name'].' '.$_POST['last_name'].'</p>';
                $message .= '<p><strong>Email:</strong> '.$_POST['email'].'</p>';
                $message .= '<p><strong>Password:</strong> '.$password.'</p>';
                $message .= '<p><strong>Fee:</strong> $'.$_POST['fee'].'</p>';
                $message .= '<p><strong>Category:</strong> '.$getCategory[0]['catname'].'</p>';
                $message .= '<p><strong>Service:</strong> '.$getCategory[0]['service'].'</p>';
                $message .= '<p>Please use the above email and password to login into your doctor account.</p>';
                $message .= '<p>'.DOCTOR_SITE_URL.'</p>';
                //include email template
                $template = file_get_contents(LIB_HTML.'user_email_template.php');
                //replace content
                $message = str_replace('{CONTENT_FOR_LAYOUT}', $message, $template);

                $phpmailer = new phpmailer();
                $phpmailer->SetLanguage("en", LIB_PATH. "PHPMailer/language/");
                $phpmailer->CharSet = "UTF-8";
                $phpmailer->Priority = 1;
                $phpmailer->AddCustomHeader("X-MSMail-Priority: High");
                $phpmailer->AddCustomHeader("Importance: High");
                $phpmailer->IsSMTP();
                $phpmailer->SMTPAuth = true;
                $phpmailer->SMTPSecure = 'ssl';
                $phpmailer->Host = "smtp.gmail.com";
                $phpmailer->SMTPDebug  = 0;
                $phpmailer->Mailer = "smtp";
                $phpmailer->Port = 465;
                $phpmailer->Username = SUPPORT_EMAIL;
                $phpmailer->Password = SUPPORT_EMAIL_PASSWORD;
                $phpmailer->From = SUPPORT_EMAIL;
                $phpmailer->FromName = SUPPORT_EMAIL_USERNAME;

                $phpmailer->IsHTML(TRUE);
                $phpmailer->AddAddress($userEmail, $userName);
                $phpmailer->Body = $message;
                $phpmailer->MsgHTML = $message;
                $phpmailer->Subject = SITE_NAME." account confirmation";
                $sendmail = @$phpmailer->send();
                ########### END EMAIL NOTIFICATION TO DJ ###########
                $_SESSION['message'] = "Doctor has been added.";
                redirect(ADMIN_SITE_URL."doctors.php");
            }

        }
        
    }
}

if(isset($_REQUEST['id']) && trim($_REQUEST['id'])!=='') {
    $table = "doctors";
    $field = "*";
    $where = "id = '".$_GET['id']."'";
    $result = $globalManager->runSelectQuery($table,$field,$where);
    if(is_array($result) && count($result)>0) {
        $result[0] = array_map("utf8_encode", $result[0]);
        $first_name = $result[0]['first_name'];
        $last_name = $result[0]['last_name'];
        $email = $result[0]['email'];
        $fee = $result[0]['fee'];
        $category_id = $result[0]['category_id'];
        $service_id = $result[0]['service_id'];
        $phone = $result[0]['phone'];
    }else{
        $_SESSION['errmsg'] = "Invalid doctor selected! Please select valid doctor to update";
        redirect(ADMIN_SITE_URL."doctors.php");
    }
}

//find out the list of all the owners
$arrCategories = $globalManager->runSelectQuery("categories", "id,name", "status='1'");