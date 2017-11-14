<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
//check for patient login

if(isset($_SESSION['moore']['user']['userid']) && trim($_SESSION['moore']['user']['userid'])!==""){
    $userId = $_SESSION['moore']['user']['userid'];
    $email = $_SESSION['moore']['user']['email'];
    $name = $_SESSION['moore']['user']['name'];
}else{
    $userId = "";
}

//signup submit
$error = array();
if(isset($_POST['book-appointment']) && trim($_POST['book-appointment'])=='submit') {
    if(isset($_POST['category_id']) && trim($_POST['category_id'])=='') {
        $error = 'Category is required';
    }else{
        $category_id = trim($_POST['category_id']);
    }
    if(isset($_POST['service_id']) && trim($_POST['service_id'])=='') {
        $error = 'Service is required';
    }else{
        $service_id = trim($_POST['service_id']);
    }
    if(isset($_POST['doctor_id']) && trim($_POST['doctor_id'])=='') {
        $error = 'Doctor is required';
    }else{
        $doctor_id = trim($_POST['doctor_id']);
    }
    if(isset($_POST['patient_count']) && (trim($_POST['patient_count'])=='' || $_POST['patient_count'] < 1)) {
        $error = 'Please select the total patient';
    }else{
        $patient_count = trim($_POST['patient_count']);
    }
    if(isset($_POST['apt_date']) && trim($_POST['apt_date'])=='') {
        $error = 'Appointment date is required';
    }else{
        $apt_date = trim($_POST['apt_date']);
    }
    if(isset($_POST['apt_time']) && trim($_POST['apt_time'])=='') {
        $error = 'Appointment time is required';
    }else{
        $apt_time = trim($_POST['apt_time']);
    }
    if(isset($_POST['name']) && trim($_POST['name'])=='') {
        $error = 'Your name is required';
    }else{
        $name = trim($_POST['name']);
    }
    if(isset($_POST['email']) && trim($_POST['email'])=='') {
        $error = 'Your email is required';
    }else{
        $email = trim($_POST['email']);
    }
    if(isset($_POST['phone']) && trim($_POST['phone'])=='') {
        $error[] = 'Your phone number is required';
    }else{
        $phone = trim($_POST['phone']);
    }
    if(isset($_POST['notes']) && trim($_POST['notes'])=='') {

    }else{
        $notes = trim($_POST['notes']);
    }
    if(isset($_POST['payment_type']) && trim($_POST['payment_type'])=='') {
        $error[] = 'Payment type for appointment is required';
    }else{
        $payment_type = trim($_POST['payment_type']);
        if($payment_type == "paypal") {
            if (isset($_POST['card_holder_name']) && trim($_POST['card_holder_name']) == '') {
                $error[] = "Please enter the card holder name";
            }
            if (trim($_POST['card_type']) == '') {
                $error[] = "Please select your credit card type";
            }
            if (trim($_POST['card_number']) == '') {
                $error[] = "Please enter your credit card number";
            }
            if (trim($_POST['expiry_month']) == '') {
                $error[] = "Please select expiry month of your credit card";
            }
            if (trim($_POST['expiry_year']) == '') {
                $error[] = "Please select expiry year of your credit card";
            }
            if (trim($_POST['cvv_number']) == '') {
                $error[] = "Please select cvv number of your credit card";
            }
        }
    }

    if(empty($error)){
        $current_date = date("Y-m-d H:i:s");
        $aptDate = date("Y-m-d H:i:s", strtotime($apt_date.' '.$apt_time));
        $bookingArray = array(
            'user_id' => $userId,
            'category_id' => $_POST['category_id'],
            'service_id' => $_POST['service_id'],
            'doctor_id' => $_POST['doctor_id'],
            'patient_count' => $_POST['patient_count'],
            'appointment_date' => $aptDate,
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'notes' => $_POST['notes'],
            'payment_type' => $_POST['payment_type'],
            'status' => '1',
            'modified' => $current_date,
            'created' => $current_date
        );
        
        $saveBooking = $globalManager->runInsertQuery('appointments', $bookingArray);
        if($saveBooking) {
            //find out the selected doctor details
            $arrDoctor = $globalManager->runSelectQuery("doctors as d LEFT JOIN states as st ON d.state_id=st.id LEFT JOIN cities as ct ON d.city_id=ct.id", "CONCAT(first_name,' ',last_name) as name,d.email,d.address,d.zipcode,st.name as state,ct.name as city", "d.id='".$_POST['doctor_id']."'");
            $docAddress = $arrDoctor[0]['address'].', '.$arrDoctor[0]['city'].', '.$arrDoctor[0]['state'].' '.$arrDoctor[0]['zipcode'];
            ################### SEND ACCOUNT ACTIVATION EMAIL ##########################
            $owner_email = $_POST['email'];
            $owner_name = $_POST['name'];

            $message = 'Dear '.$owner_name;
            $message .= '<p>This is confirmation that you have booked Basic Eye Exam.</p>';
            $message .= '<p>We are waiting you at '.$docAddress.' on '.date("F d, Y H:i A", strtotime($aptDate)).'.</p>';
            $message .= '<p>Thank you for choosing our company.</p>';

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
            $phpmailer->Subject = "Your appointment information | ".SITE_NAME;
            $sendmail = @$phpmailer->send();

            ################### END SEND ACCOUNT ACTIVATION EMAIL ######################
            
            
            ########################## SAVE GOOGLE CALENDAR ################
            /*require_once LIB_PATH.'google-api-php-client/src/Google_Client.php';
            require_once LIB_PATH.'google-api-php-client/src/contrib/Google_CalendarService.php';
            $client = new Google_Client();
            $client->setApplicationName("Moore Vision Appointments");

            // Visit https://code.google.com/apis/console?api=calendar to generate your
            // client id, client secret, and to register your redirect uri.
            $client->setClientId('50391218006-lch0slronhjt16ppb8jfm99oncj4a0f2.apps.googleusercontent.com');
            $client->setClientSecret('4cf5J_Z0pN4AxM-zU8Wn5rbA');
            $client->setRedirectUri(SITE_URL.'/book-appointment.php');
            $client->setDeveloperKey('AIzaSyCs33-69KKO44Nt8pjD9lofxHzcPpEFSfM');
            $cal = new Google_CalendarService($client);
            if (isset($_GET['logout'])) {
                unset($_SESSION['token']);
            }

            if (isset($_GET['code'])) {
                $client->authenticate($_GET['code']);
                $_SESSION['token'] = $client->getAccessToken();
                header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
            }

            if (isset($_SESSION['token'])) {
                $client->setAccessToken($_SESSION['token']);
            }

            if ($client->getAccessToken()) {
                //$calList = $cal->calendarList->listCalendarList();
                //print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";

                $event = new Google_Event();
                $event->setSummary('Appointment');
                $event->setLocation('Chandigarh');
                $start = new Google_EventDateTime();
                $start->setDateTime($aptDate);
                $event->setStart($start);
                $end = new Google_EventDateTime();
                $end->setDateTime(date("Y-m-d H:i:s", strtotime("+30 minutes", $aptDate)));
                $event->setEnd($end);
                $attendee1 = new Google_EventAttendee();
                $attendee1->setEmail('sandip.kumar78@gmail.com');

                $attendees = array($attendee1);
                $event->attendees = $attendees;
                $createdEvent = $cal->events->insert('0l6h391d9iaqqthhg4gfrtul9o@group.calendar.google.com', $event);
            } else {
                $authUrl = $client->createAuthUrl();
                redirect($authUrl);
                //print "<a class='login' href='$authUrl'>Connect Me!</a>";
            }*/
            ################## END OF GOOGLE CALENDAR ###########################

            $_SESSION['message'] = "Thank you! Your booking is complete. An email with details of your booking has been sent to you.";
            redirect(USER_SITE_URL);
        } else {
            $_SESSION['errmsg'] = "Submission failed! Please try again";
        }
    }
}

//find 


//find out the list of all the owners
$arrCategories = $globalManager->runSelectQuery("categories", "id,name", "status='1'");

//define array of month
$arrMonths = array(
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
);