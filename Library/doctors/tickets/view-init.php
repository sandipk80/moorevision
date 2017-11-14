<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
//find out logged in user id
$doctorId = $_SESSION['moore']['doctor']['userid'];
$doctorName = $_SESSION['moore']['doctor']['name'];
$doctorEmail = $_SESSION['moore']['doctor']['email'];
//set page title
$pageTitle = "View Ticket";

$error = array();	
$output_dir = STORAGE_PATH."tickets/";

if(isset($_POST['add-reply']) && trim($_POST['add-reply'])=='submit') {
	if(isset($_POST['message']) && trim($_POST['message'])=='') {
		$error[] = "Please enter the message";
	}
	else {
		$message = $_POST['message'];
    }
	if(isset($_POST['status']) && trim($_POST['status'])=='') {
		$error[] = "Please select the ticket status";
	}
	else {
		$status = $_POST['status'];
    }
    if(isset($_POST['priority']) && trim($_POST['priority'])=='') {
        $error[] = "Please select the ticket priority";
    }
    else {
        $priority = $_POST['priority'];
    }
    if(count($error) == '0') {
        //find out the patient email and name
        $getPatient = $globalManager->runSelectQuery("tickets", "name,email", $where);
    	$curr_date = date("Y-m-d H:i:s");
        
        //save ticket reply
        $replyArray = array(
            'ticket_id' => $_POST['tktId'],
            
            'doctor_id' => $doctorId,
        	'message' => $message,
            'reply_from' => 'D',
            'created' => $curr_date
    	);

        $saveReply = $globalManager->runInsertQuery('ticket_replies',$replyArray);
        if($saveReply){
        	$replyId =$saveReply;
            //update ticket
            $ticketArray = array(
                'status' => $_POST['status'],
                'priority' => $_POST['priority'],
                'modified' => $curr_date
            );
            $saveTicket = $globalManager->runUpdateQuery("tickets", $ticketArray, "id='".$_POST['tktId']."'");

        	//create loop for each selected attachment
        	$filename = array();
		    if(empty($error)){
		        if(isset($_FILES['attachments'])) {
		            foreach($_FILES['attachments']['tmp_name']  as $key => $tmp_name ){
		                if(trim($_FILES['attachments']['name'][$key])=='') {
		                    continue;
		                }
		                $fileNumber = $key+1;
		                $file_name = $_FILES['attachments']['name'][$key];
		                $file_size = $_FILES['attachments']['size'][$key];
		                $file_tmp = $_FILES['attachments']['tmp_name'][$key];
		                $file_type = $_FILES['attachments']['type'][$key];

		                //check the file extension
		                $extensions = array("jpeg","jpg","png","bmp","gif","doc","docx","xls","xlsx","txt","rtf");
		                $file_ext = pathinfo($_FILES['attachments']['name'][$key], PATHINFO_EXTENSION);
		                $file_ext = strtolower($file_ext);
		                if(in_array($file_ext,$extensions ) === false){
		                    $error[] = "Extension not allowed for file ".$fileNumber." (".$file_name.")";
		                }

		                //check the file size
		                if($file_size > 2097152){
		                    $error[] = "File size for attachment ".$fileNumber." (".$file_name.") must be less than 2 MB";
		                }
		                $created = date('Y-m-d H:i:s');

		                if(empty($error)){
		                    $filename[$key] = $key.UtilityManager::generateImageName(18).'.'.$file_ext;
		                    if(move_uploaded_file($file_tmp, $output_dir.$filename[$key])) {
		                        $filesArray = array(
		                            'ticket_id' => $_POST['tktId'],
                                    'ticket_reply_id' => $replyId,
		                            'filename' => $filename[$key],
		                            'file_size' => $file_size,
		                            'file_type' => $file_type,
		                            'created' => $created
		                        );
		                        $addAttachment = $globalManager->runInsertQuery('ticket_attachments', $filesArray);
		                    }
		                }
		            }
		        }
		    }

		    ################### SEND NOTIFICATION EMAIL TO PATIENT ##########################
            $patient_email = $getPatient[0]['email'];
            $patient_name = $getPatient[0]['name'];

            $message = 'Dear '.$patient_name;
            $message .= '<p>Doctor <strong>'.$doctorName.'</strong> has replied your ticket <i>'.$_POST['subject'].'</i> on '.$_POST['priority'].' priority.</p>';
            $message .= '<p>Your ticket status is <i>'.$_POST['status'].'</i></p>';
            $message .= '<p><i>'.$_POST['message'].'</i></p>';

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
            //save attachment
            if(count($filename) > 0){
            	foreach($filename as $key=>$value){
            		if($value !== "" && file_exists(STORAGE_PATH . "tickets/" . $value)){
            			$phpmailer->AddAttachment(STORAGE_PATH . "tickets/" . $value);
        			}
            	}
            }
            
            $phpmailer->Subject = "Ticket Reply | ".SITE_NAME;
            $sendmail = $phpmailer->send();

            ################### END SEND ACCOUNT ACTIVATION EMAIL ######################

            $_SESSION['message'] = "Your reply has been send.";
            redirect(DOCTOR_SITE_URL."tickets.php");
        }else{
            $_SESSION['errmsg'] = "Action failed! Please try again";
        }		
	}

}

//find out the list of ticket categories
$tCategories = $globalManager->runSelectQuery("ticket_categories", "id,name", "status='1'");

//find out the details of ticket
if(isset($_GET['id']) && trim($_GET['id'])!==""){   
    $arrTicket = $globalManager->runSelectQuery("tickets", "*", "id='".$_GET['id']."' AND doctor_id='".$doctorId."'");
    if(is_array($arrTicket) && count($arrTicket)>0){
        $name = $arrTicket[0]['name'];
        $email = $arrTicket[0]['email'];
        $subject = $arrTicket[0]['subject'];
        $description = $arrTicket[0]['description'];
        $status = $arrTicket[0]['status'];
        $priority = $arrTicket[0]['priority'];
        $ticketCategoryId = $arrTicket[0]['ticket_category_id'];
        $is_public = $arrTicket[0]['is_public'];
        $notify_owner = $arrTicket[0]['notify_owner'];

        //find out the communications of this ticket
        $arrReplies = $globalManager->runSelectQuery("ticket_replies", "*", "ticket_id='".$_GET['id']."' ORDER BY created DESC");

        if(is_array($arrReplies) && count($arrReplies)>0){
            foreach($arrReplies as $key=>$value){
                //find out the attachments of this reply
                $getAttachments = $globalManager->runSelectQuery("ticket_attachments", "*", "ticket_id='".$_GET['id']."' AND ticket_reply_id='".$value['id']."'");
                if(is_array($getAttachments) && count($getAttachments)>0){
                    $arrReplies[$key]['attachments'] = $getAttachments;
                }else{
                    $arrReplies[$key]['attachments'] = array();
                }
            }
        }else{
            $arrReplies = array();
        }
    }else{
        $_SESSION['errmsg'] = "Invalid ticket selected! Please select valid ticket";
        redirect(DOCTOR_SITE_URL.'tickets.php');
    }
}else{
    $_SESSION['errmsg'] = "No ticket selected! Please select valid ticket";
    redirect(DOCTOR_SITE_URL.'tickets.php');
}