<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
//find out logged in user id
$doctorId = $_SESSION['moore']['doctor']['userid'];
$doctorName = $_SESSION['moore']['doctor']['name'];
//set page title
$pageTitle = "Edit Ticket";

$error = array();	
$output_dir = STORAGE_PATH."tickets/";

if(isset($_POST['edit-ticket']) && trim($_POST['edit-ticket'])=='submit') {
	if(isset($_POST['subject']) && trim($_POST['subject'])=='') {
		$error[] = "Please enter the subject of ticket";
	}
	else {
		$subject = $_POST['subject'];
    }
	if(isset($_POST['description']) && trim($_POST['description'])=='') {
		$error[] = "Please enter the ticket description";
	}
	else {
		$description = $_POST['description'];
    }
    
    if(count($error) == '0') {
        $where = "id='".$_POST['tktId']."'";
        //find out the patient email and name
        $getPatient = $globalManager->runSelectQuery("tickets", "name,email", $where);
    	$curr_date = date("Y-m-d H:i:s");
        
        //save ticket
        $ticketArray = array(
        	'subject' => $subject,
        	'description' => $description,
        	'ticket_category_id' => $_POST['ticket_category_id'],
        	'priority' => $_POST['priority'],
        	'status' => $_POST['status'],
        	'is_public' => $_POST['is_public'],
        	'notify_owner' => $_POST['notify_owner'],
        	'modified' => $curr_date
    	);

        $saveTicket = $globalManager->runUpdateQuery('tickets',$ticketArray, $where);
        if($saveTicket){
        	$ticketId =$_POST['tktId'];
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
		                            'ticket_id' => $ticketId,
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
            $message .= '<p>Your ticket <i>'.$_POST['subject'].'</i> has been updated by doctor <strong>'.$doctorName.'</strong> for you on '.$_POST['priority'].' priority.</p>';
            $message .= '<p>Your ticket status is <i>'.$_POST['status'].'</i></p>';
            $message .= '<p><i>'.$_POST['description'].'</i></p>';

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
            
            $phpmailer->Subject = "Ticket Update | ".SITE_NAME;
            $sendmail = $phpmailer->send();

            ################### END SEND ACCOUNT ACTIVATION EMAIL ######################

            $_SESSION['message'] = "Your ticket has been updated.";
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
        $subject = $arrTicket[0]['subject'];
        $description = $arrTicket[0]['description'];
        $status = $arrTicket[0]['status'];
        $priority = $arrTicket[0]['priority'];
        $ticketCategoryId = $arrTicket[0]['ticket_category_id'];
        $is_public = $arrTicket[0]['is_public'];
        $notify_owner = $arrTicket[0]['notify_owner'];
    }else{
        $_SESSION['errmsg'] = "Invalid ticket selected! Please select valid ticket to update";
        redirect(DOCTOR_SITE_URL.'tickets.php');
    }
}else{
    $_SESSION['errmsg'] = "No ticket selected! Please select valid ticket to update";
    redirect(DOCTOR_SITE_URL.'tickets.php');
}