<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
$pageTitle = "Add Patient";
//signup submit
$error = array();

if(isset($_POST['add-patient']) && trim($_POST['add-patient'])=='submit') {
    //first check out for duplicate email
    $condition = "email='".$_POST['email']."'";
    $result = $globalManager->runSelectQuery("users", "COUNT(id) as total", $condition);
    if($result[0]['total'] > 0){
        $error[] = "Email address already exists";
    }else {
        if (isset($_POST['firstname']) && trim($_POST['firstname']) == '') {
            $error[] = "Please enter your first name";
        }else{
            $firstname = trim($_POST['firstname']);
        }
        if (isset($_POST['lastname']) && trim($_POST['lastname']) == '') {
            $error[] = "Please enter your last name";
        }else{
            $lastname = trim($_POST['lastname']);
        }
        if (isset($_POST['social_security_number']) && trim($_POST['social_security_number']) == '') {
            $error[] = "Please enter your social security number";
        }else{
            $social_security_number = trim($_POST['social_security_number']);
        }
        if (isset($_POST['email']) && trim($_POST['email']) == '') {
            $error[] = "Please enter your email";
            $email = '';
        }else{
            $email = trim($_POST['email']);
        }

        if (isset($_POST['phone']) && trim($_POST['phone']) == '') {
            $error[] = "Please enter your phone number";
        }else{
            $phone = trim($_POST['phone']);
        }
        if(is_array($_POST['date_of_birth_birth']) && count($_POST['date_of_birth_birth'])>0){
            $date_of_birth = $_POST['date_of_birth_birth']['year']."-".$_POST['date_of_birth_birth']['month']."-".$_POST['date_of_birth_birth']['day'];
            $date_of_birth = date("Y-m-d", strtotime($date_of_birth));
        }else{
            $error[] ="Please select your date of birth";
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

        if (empty($error)) {
            $current_date = date("Y-m-d H:i:s");
            $code = UtilityManager::generateUniqueSecurityCode(12);
            $txtpassword = UtilityManager::generateUniqueSecurityCode(6);
            $userArray = array(
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'social_security_number' => $_POST['social_security_number'],
                'email' => $_POST['email'],
                'password' => UtilityManager::encrypt_password($txtpassword),
                'phone' => $_POST['phone'],
                'date_of_birth' => $date_of_birth,
                'address' => $_POST['address'],
                'state_id' => $_POST['state_id'],
                'city_id' => $_POST['city_id'],
                'zipcode' => $_POST['zipcode'],
                'hear_from' => 'Added by doctor',
                'vision_insurance' => $_POST['vision_insurance'],
                'medical_insurance' => $_POST['medical_insurance'],
                'last_examination_date' => date("Y-m-d", strtotime($_POST['last_examination_date'])),
                'last_examination_place' => $_POST['last_examination_place'],
                'last_examination_recommend' => $_POST['last_examination_recommend'],
                'mobile_number' => $_POST['mobile_number'],
                'mobile_carrier' => $_POST['mobile_carrier'],
                'code' => $code,
                'active' => '1',
                'modified' => $current_date,
                'created' => $current_date,
                'status' => '1'
            );

            $addUser = $globalManager->runInsertQuery('users', $userArray);
            
            if($addUser) {
                $userId = $addUser;

                ################### SEND ACCOUNT ACTIVATION EMAIL ##########################
                $owner_email = $_POST['email'];
                $owner_name = $_POST['firstname'];

                $message = 'Dear '.$owner_name;
                $message .= '<p>Welcome to Moore Vision!</p>';
                $message .= '<p>Your account has been created, you can login with the credentials below.</p>';
                $message .= '<p>------------------------------------------------------------------------</p>';
                $message .= '<p>Email: '.$owner_email.'</p>';
                $message .= '<p>Password: '.$txtpassword.'</p>';
                $message .= '<p>------------------------------------------------------------------------</p>';
                $message .= '<p>Click <a href="'.SITE_URL.'">here</a> to access your account</p>';
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
                $phpmailer->AddAddress($owner_email, $owner_name);
                $phpmailer->Body = $message;
                $phpmailer->MsgHTML = $message;
                $phpmailer->Subject = "Account Confirmation | ".SITE_NAME;
                $sendmail = $phpmailer->send();

                ################### END SEND ACCOUNT ACTIVATION EMAIL ######################
                
                $_SESSION['message'] = "Patient has been added and a confirmation email has been send to the patient email.";
                redirect(DOCTOR_SITE_URL.'appointments.php');
            } else {
                $_SESSION['errmsg'] = "Submission failed! Please try again";
            }

        }
    }
}

//find out the us states
$arrStates = $globalManager->runSelectQuery("states", "id,name", "country_id='237' AND status='1'");

//define mobile carriers
$arrMobCarrier = array(
    'AT&T' => 'AT&T',
    'Sprint' => 'Sprint',
    'T-Mobile' => 'T-Mobile',
    'Verizon' => 'Verizon'
);