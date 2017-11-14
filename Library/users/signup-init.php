<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
//signup submit
$error = array();
if(isset($_POST['user-signup']) && trim($_POST['user-signup'])=='signup') {
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

        if (trim($_POST['password']) == '') {
            $error[] = "Please enter the password";
        }
        if (trim($_POST['confirm_password']) == '') {
            $error[] = "Please confirm the password";
        }
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $error[] = "Please enter the same password to confirm";
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
        if(isset($_POST['employer']) && trim($_POST['employer'])=='') {
            $error[] ="Please enter your employer";
        }else{
            $employer = trim($_POST['employer']);
        }
        if(isset($_POST['reason']) && trim($_POST['reason'])=='') {
            $error[] ="Please enter the reason for your visit";
        }else{
            $reason = trim($_POST['reason']);
        }
        if (empty($error)) {
            $current_date = date("Y-m-d H:i:s");
            $code = UtilityManager::generateUniqueSecurityCode(12);
            $userArray = array(
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'social_security_number' => $_POST['social_security_number'],
                'email' => $_POST['email'],
                'password' => UtilityManager::encrypt_password($_POST['password']),
                'phone' => $_POST['phone'],
                'date_of_birth' => $date_of_birth,
                'address' => $_POST['address'],
                'state_id' => $_POST['state_id'],
                'city_id' => $_POST['city_id'],
                'zipcode' => $_POST['zipcode'],
                'employer' => $_POST['employer'],
                'hear_from' => $_POST['hear_from'],
                'vision_insurance' => $_POST['vision_insurance'],
                'medical_insurance' => $_POST['medical_insurance'],
                'reason' => $_POST['reason'],
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
                ############## SAVE USER MEDICAL DETAILS ######################
                $infoArray = array(
                    "user_id" => $userId,
                    "is_dilated" => $_POST['is_dilated'],
                    "dilated_date" => $_POST['dilated_date']!=="" ? date("Y-m-d", strtotime($_POST['dilated_date'])) : "0000-00-00",
                    "is_medication_allergy" => $_POST['is_medication_allergy'],
                    "medication_allergies" => $_POST['medication_allergies'],
                    "taking_medication" => $_POST['taking_medication'],
                    "medication_list" => $_POST['medication_list'],
                    "is_pregnant_nursing" => $_POST['is_pregnant_nursing'],
                    "pregnant_nursing_time" => $_POST['pregnant_nursing_time'],
                    "have_eye_injury_surgery" => $_POST['have_eye_injury_surgery'],
                    "wear_glass" => $_POST['wear_glass'],
                    "wear_glass_per_week" => $_POST['wear_glass_per_week'],
                    "wear_glass_start_date" => $_POST['wear_glass_start_date']!=="" ? date("Y-m-d", strtotime($_POST['wear_glass_start_date'])) : "0000-00-00",
                    "wear_lense" => $_POST['wear_lense'],
                    "wear_lense_per_week" => $_POST['wear_lense_per_week'],
                    "lense_complication" => $_POST['lense_complication'],
                    "sleep_with_lense" => $_POST['sleep_with_lense'],
                    "continue_wear_lense_days" => $_POST['continue_wear_lense_days'],
                    "work_type" => $_POST['work_type'],
                    "is_drop_lense_reaction" => $_POST['is_drop_lense_reaction'],
                    "drop_lense_reaction" => $_POST['drop_lense_reaction'],
                    "use_computer" => $_POST['use_computer'],
                    "computer_hours_per_day" => $_POST['computer_hours_per_day'],
                    "do_extended_reading_work" => $_POST['do_extended_reading_work'],
                    "close_work_type" => $_POST['close_work_type'],
                    "is_eye_dry_gritty" => $_POST['is_eye_dry_gritty'],
                    "eye_dry_gritty_scale" => $_POST['eye_dry_gritty_scale'],
                    "experience_eye_problem" => $_POST['experience_eye_problem'],
                    "eye_problem_type" => $_POST['eye_problem_type'],
                    "driving_visual_difficulty" => $_POST['driving_visual_difficulty'],
                    "bright_light_glare_problem" => $_POST['bright_light_glare_problem'],
                    "experience_strained_tired_eyes" => $_POST['experience_strained_tired_eyes'],
                    "hobbies_sports" => $_POST['hobbies_sports'],
                    "is_blindness" => $_POST['is_blindness'],
                    "blindness_from" => $_POST['blindness_from'],
                    "is_cataract" => $_POST['is_cataract'],
                    "cataract_from" => $_POST['cataract_from'],
                    "is_crossed_eyes" => $_POST['is_crossed_eyes'],
                    "crossed_eyes_from" => $_POST['crossed_eyes_from'],
                    "is_glaucoma" => $_POST['is_glaucoma'],
                    "glaucoma_from" => $_POST['glaucoma_from'],
                    "is_macular_degeneration" => $_POST['is_macular_degeneration'],
                    "macular_degeneration_from" => $_POST['macular_degeneration_from'],
                    "is_retinal_detachment" => $_POST['is_retinal_detachment'],
                    "retinal_detachment_from" => $_POST['retinal_detachment_from'],
                    "is_diabetes" => $_POST['is_diabetes'],
                    "diabetes_from" => $_POST['diabetes_from'],
                    "is_heart_disease" => $_POST['is_heart_disease'],
                    "heart_disease_from" => $_POST['heart_disease_from'],
                    "is_high_blood_pressure" => $_POST['is_high_blood_pressure'],
                    "high_blood_pressure_from" => $_POST['high_blood_pressure_from'],
                    "is_cancer" => $_POST['is_cancer'],
                    "cancer_from" => $_POST['cancer_from'],
                    "is_thyroid_disease" => $_POST['is_thyroid_disease'],
                    "thyroid_disease_from" => $_POST['thyroid_disease_from'],
                    "is_vision_loss" => $_POST['is_vision_loss'],
                    "is_blurred_vision" => $_POST['is_blurred_vision'],
                    "is_distorted_vision" => $_POST['is_distorted_vision'],
                    "is_side_vision_loss" => $_POST['is_side_vision_loss'],
                    "is_double_vision" => $_POST['is_double_vision'],
                    "is_burning" => $_POST['is_burning'],
                    "is_redness" => $_POST['is_redness'],
                    "is_itching" => $_POST['is_itching'],
                    "is_excess_tearing_watering" => $_POST['is_excess_tearing_watering'],
                    "is_dryness" => $_POST['is_dryness'],
                    "is_sandy_gritty_feeling" => $_POST['is_sandy_gritty_feeling'],
                    "is_mucous_discharge" => $_POST['is_mucous_discharge'],
                    "is_eyepain_soreness" => $_POST['is_eyepain_soreness'],
                    "is_vision_flashes" => $_POST['is_vision_flashes'],
                    "headaches" => $_POST['headaches'],
                    "migraines" => $_POST['migraines'],
                    "seizures" => $_POST['seizures'],
                    "heart_pain" => $_POST['heart_pain'],
                    "sinus_congestion" => $_POST['sinus_congestion'],
                    "dry_throat_mouth" => $_POST['dry_throat_mouth'],
                    "chronic_cough" => $_POST['chronic_cough'],
                    "asthma" => $_POST['asthma'],
                    "chronic_bronchitis" => $_POST['chronic_bronchitis'],
                    "emphysema" => $_POST['emphysema'],
                    "rheumatoid_athritis" => $_POST['rheumatoid_athritis'],
                    "joint_pain" => $_POST['joint_pain'],
                    "anemia" => $_POST['anemia'],
                    "bleeding_problem" => $_POST['bleeding_problem'],
                    "skin" => $_POST['skin'],
                    "genitals_kidney_bladder" => $_POST['genitals_kidney_bladder'],
                    "psychiatric" => $_POST['psychiatric'],
                    "thyroid_other_glands" => $_POST['thyroid_other_glands'],
                    "explanations" => $_POST['explanations'],
                    'modified' => $current_date
                );

                $saveInfo = $globalManager->runInsertQuery('user_informations', $infoArray);
                #################### END OF USER MADICAL DETAILS #########################

                //allow to login
                $_SESSION['moore']['user']['userid'] = $userId;
                $_SESSION['moore']['user']['email'] = $_POST['email'];
                $_SESSION['moore']['user']['name'] = ucwords($_POST['name']);

                ################### SEND ACCOUNT ACTIVATION EMAIL ##########################
                $owner_email = $_POST['email'];
                $owner_name = $_POST['firstname'];

                $message = 'Dear '.$owner_name;
                $message .= '<p>Thanks for signing up!</p>';
                $message .= '<p>Welcome to the Moore vision family. Your account has been created, you can login with the credentials below.</p>';
                $message .= '<p>------------------------------------------------------------------------</p>';
                $message .= '<p>Email: '.$owner_email.'</p>';
                $message .= '<p>Password: '.$_POST['password'].'</p>';
                $message .= '<p>------------------------------------------------------------------------</p>';

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
                
                $_SESSION['message'] = "Thank you for signing up to the ".SITE_NAME.".";
                redirect(USER_SITE_URL);
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