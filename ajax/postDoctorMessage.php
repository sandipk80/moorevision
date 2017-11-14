<?php
include('../cnf.php');
################# CHECK LOGGED IN USER ##############
validateDoctorLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

$doctorId = $_SESSION['moore']['user']['userid'];
$output_dir = STORAGE_PATH."messages/";
//post message
if(isset($_POST['message'],$_POST['conversation_id'],$_POST['user_id']) && trim($_POST['conversation_id'])!=="" && trim($_POST['user_id'])!==""){
	$filename = "";
	$attachname = "";
	$filetype = "";
	$filesize = "0";
	//check for attachment
	if (isset($_FILES['msgFile']) && $_FILES['msgFile']['tmp_name'] != '') {
        $file_name = $_FILES['msgFile']['name'];
        $file_size = $_FILES['msgFile']['size'];
        $file_tmp = $_FILES['msgFile']['tmp_name'];
        $file_type = $_FILES['msgFile']['type'];

        //check the file extension
        $extensions = array("jpeg", "jpg", "png", "bmp", "gif", "pdf", "doc", "docx");
        $file_ext = pathinfo($_FILES['msgFile']['name'], PATHINFO_EXTENSION);
        $file_ext = strtolower($file_ext);
        if (in_array($file_ext, $extensions) === false) {
            $error[] = $file_name . " is not uploaded as extension not allowed " . $file_name . '<br>';
        }

        //check the file size
        if ($file_size > 2097152) {
            $error[] = $file_name . ' is not uploaded as file size must be less than 2 MB for image ' . $file_name . '<br>';
        }

        if (empty($error)) {
            $filename = UtilityManager::generateFileName(18) . '.' . $file_ext;
            $attachname = $file_name;
            $filetype = $file_type;
            $filesize = $file_size;
            $normalDestination = STORAGE_PATH . "messages/" . $filename;
            move_uploaded_file($file_tmp, $output_dir . $filename);              
        }
    }
	$msgArray = array(
		'conversation_id' => base64_decode($_POST['conversation_id']),
		'doctor_id' => $doctorId,
		'user_id' => base64_decode($_POST['user_id']),
		'msg_from' => 'D',
		'message' => trim($_POST['message']),
		'attachment' => $filename,
		'file_type' => $filetype,
		'file_size' => $filesize,
		'filename' => $attachname,
		'patient_flag' => '0',
		'doctor_flag' => '1',
		'msg_date' => date("Y-m-d H:i:s"),
		'created' => date("Y-m-d H:i:s")
	);
	//prx($msgArray);
	$saveMessage = $globalManager->runInsertQuery("messages", $msgArray);
	if($saveMessage){
		############# SEND EMAIL TO PATIENT ################
		//find out the patient name and email
		$getPatient = $globalManager->runSelectQuery("users", "firstname,lastname,email", "id='".base64_decode($_POST['user_id'])."'");
		if(is_array($getPatient) && !empty($getPatient)){
			$patientName = ucwords($getPatient[0]['firstname'].' '.$getPatient[0]['lastname']);
			$patientEmail = $getPatient[0]['email'];
			$message = 'Dear '.$patientName;
			$message .= '<p>You just receive a message from doctor on Moore Vision. Below is your message:</p>';
			$message .= '<p>&nbsp;</p>';
			$message .= '<p>'.trim($_POST['message']).'</p>';
			$message .= '<p>&nbsp;</p>';

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
			$phpmailer->AddAddress($patientEmail, $patientName);
			$phpmailer->Body = $message;
			$phpmailer->MsgHTML = $message;
			if($attachname !== ""){
				$phpmailer->AddAttachment(STORAGE_PATH . "messages/" . $attachname);
			}
			$phpmailer->Subject = "Message | ".SITE_NAME;
			$sendmail = $phpmailer->send();
		}
		################ END EMAIL TO PATIENT ##############
		echo "Posted";
	}else{
		echo "Error";
	}
}