<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
$pageTitle = "Patient Examination";

$doctorId = $_SESSION['moore']['doctor']['userid'];

if(isset($_POST['next-step']) && $_POST['next-step'] == "Submit"){
	redirect(DOCTOR_SITE_URL.'add-patient-prescription.php?eid='.$_POST['exam_id']);
	exit;
}

if(isset($_GET['eid']) && trim($_GET['eid']) !== ""){
	//find out the examination details
	$getExamination = $globalManager->runSelectQuery("patient_examinations", "*", "id='".$_GET['eid']."'");
	if(is_array($getExamination) && count($getExamination)>0){
		$arrExamination = $getExamination[0];
		if($arrExamination['pdf_file'] !== "" && file_exists(STORAGE_PATH.'examinations/'.$arrExamination['pdf_file'])){
			
		}else{
			############## CREATE PDF FILE #######################
            include(LIB_PATH."tcpdf/tcpdf.php");
            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(SITE_NAME);
            $pdf->SetAuthor('DOCTOR');
            $pdf->SetTitle('Patient Examination');
            $pdf->SetSubject('TCPDF Tutorial');
            $pdf->SetKeywords('');

            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 021', PDF_HEADER_STRING);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set font
            $pdf->SetFont('helvetica', '', 9);

            // add a page
            $pdf->AddPage();

            $html = UtilityManager::get_remote_data(SITE_URL.'doctors/exam-result.php?eid='.$_GET['eid']);
            // output the HTML content
            $pdf->writeHTML($html, true, 0, true, 0);

            // reset pointer to the last page
            $pdf->lastPage();

            // ---------------------------------------------------------
            $pdfFile = UtilityManager::generateImageName(12);
            //Close and output PDF document
            $pdf->Output(STORAGE_PATH.'examinations/'.$pdfFile.'.pdf', 'F');
            if(file_exists(STORAGE_PATH.'examinations/'.$pdfFile.'.pdf')){
                $examArray = array(
                    'pdf_file' => $pdfFile.'.pdf'
                );
                $updateExam = $globalManager->runUpdateQuery("patient_examinations", $examArray, "id='".$_GET['eid']."'");
            }
		}

		if(isset($_GET['act']) && trim($_GET['act']) == "print"){
			redirect(STORAGE_HTTP_PATH.'examinations/'.$arrExamination['pdf_file']);
			exit;
		}elseif(isset($_GET['act']) && trim($_GET['act']) == "email"){
			############# SEND EMAIL TO PATIENT ################
			//find out the patient name and email
			$getPatient = $globalManager->runSelectQuery("users", "firstname,lastname,email", "id='".$arrExamination['user_id']."'");
			if(is_array($getPatient) && !empty($getPatient)){
				$patientName = ucwords($getPatient[0]['firstname'].' '.$getPatient[0]['lastname']);
				$patientEmail = $getPatient[0]['email'];
				$message = 'Dear '.$patientName;
				$message .= '<p>Please find your examination report and prescription from the attachment.</p>';
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
				$phpmailer->AddAttachment(STORAGE_PATH . "examinations/" . $arrExamination['pdf_file']);
				$phpmailer->Subject = "Examination report and prescription | ".SITE_NAME;
				$sendmail = @$phpmailer->send();
				$_SESSION['message'] = "Patient prescription has been emailed to the patient";
			}
			if(isset($_GET['opt']) && trim($_GET['opt']) == "both"){
				redirect(STORAGE_HTTP_PATH.'examinations/'.$arrExamination['pdf_file']);
				exit;
			}else{
				redirect(DOCTOR_SITE_URL.'submitPatientPrescription.php?eid='.$arrExamination['id']);
			}
			################ END EMAIL TO PATIENT ##############
		}

	}else{
		$_SESSION['errmsg'] = "Patient examination does not exists";
		redirect(DOCTOR_SITE_URL.'examinations.php');
	}
}else{
	$_SESSION['errmsg'] = "Patient examination does not exists";
	redirect(DOCTOR_SITE_URL.'patients.php');
}