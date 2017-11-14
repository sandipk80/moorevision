<?php
include('../cnf.php');
################# CHECK LOGGED IN USER ##############
validateDoctorLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");

$doctorId = $_SESSION['moore']['doctor']['userid'];
$doctorName = $_SESSION['moore']['doctor']['name'];

//post status
if(isset($_POST['tid'],$_POST['status'],$_POST['priority']) && trim($_POST['tid'])!=="" && trim($_POST['status'])!=="" && trim($_POST['priority'])!==""){
	$tWhere = "id='".$_POST['tid']."' AND doctor_id='".$doctorId."'";
	//first check for valid ticket
	$getTicket = $globalManager->runSelectQuery("tickets", "*", $tWhere);
	if(is_array($getTicket) && count($getTicket)>0){
		$tktArray = array(
			'status' => $_POST['status'],
			'priority' => $_POST['priority'],
			'created' => date("Y-m-d H:i:s")
		);
		//prx($tktArray);
		$saveStatus = $globalManager->runUpdateQuery("tickets", $tktArray, $tWhere);
		if($saveStatus){
                  if($_POST['status'] == "closed"){
                        $patientId = $getTicket[0]['user_id'];
                        //find out the details of patient and send SMS
                        $getUser = $globalManager->runSelectQuery("users as u LEFT JOIN countries as ct ON u.country_id=ct.id", "ct.isd_code,u.mobile_number", "u.id='".$patientId."'");
                        if(is_array($getUser) && count($getUser)>0){
                              if(isset($getUser[0]['isd_code']) && trim($getUser[0]['isd_code'])!==""){
                                    $isdCode = trim($getUser[0]['isd_code']);
                              }else{
                                    $isdCode = "1";
                              }
                              if(isset($getUser[0]['mobile_number']) && trim($getUser[0]['mobile_number'])!==""){
                                    $phone = str_replace("+","",$isdCode).''.$getUser[0]['mobile_number'];
                                    $message ="Your Moore Vision Order is ready for pickup.";
                                    UtilityManager::send_sms($phone,$message);
                              }
                        }
                  }
			################### SEND NOTIFICATION EMAIL TO PATIENT ##########################
                  $patient_email = $getTicket[0]['email'];
                  $patient_name = $getTicket[0]['name'];

                  $message = 'Dear '.$patient_name;
                  $message .= '<p>Your ticket <i>'.$_POST['subject'].'</i> has been updated by doctor <strong>'.$doctorName.'</strong> for you on '.$_POST['priority'].' priority.</p>';
                  $message .= '<p>Your ticket status is <i>'.$_POST['status'].'</i></p>';

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
                  $phpmailer->AddAddress($patient_email, $patient_name);
                  $phpmailer->Body = $message;
                  $phpmailer->MsgHTML = $message;
                  
                  $phpmailer->Subject = "Ticket Status | ".SITE_NAME;
                  $sendmail = $phpmailer->send();
                  ################### END SEND ACCOUNT ACTIVATION EMAIL ######################
                  echo "Posted";
			exit;
		}else{
			echo "Error";exit;
		}
	}else{
		echo "Error";exit;
	}
}