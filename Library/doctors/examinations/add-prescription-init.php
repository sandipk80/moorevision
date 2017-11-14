<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
$pageTitle = "Add Patient Prescription";

$doctorId = $_SESSION['moore']['doctor']['userid'];

//find out the exam details
if(isset($_GET['eid']) && trim($_GET['eid']) !== ""){
    $getExam = $globalManager->runSelectQuery("patient_examinations", "user_id", "id='".$_GET['eid']."'");
    if(is_array($getExam) && count($getExam)>0){
        $patientId = $getExam[0]['user_id'];
    }else{
        $_SESSION['errmsg'] = "Invalid patient examination";
        redirect(DOCTOR_SITE_URL.'examinations.php');
    }
}else{
    $_SESSION['errmsg'] = "Invalid patient examination";
    redirect(DOCTOR_SITE_URL.'examinations.php');
}

//signup submit
$error = array();
$prescription_date = date("m/d/Y");
if(isset($_POST['add-prescription']) && trim($_POST['add-prescription'])=='submit') {
    if (isset($_POST['patient_name']) && trim($_POST['patient_name']) == '') {
        $error[] = "Please enter patient name";
    }else{
        $patient_name = trim($_POST['patient_name']);
    }
    if (isset($_POST['age']) && trim($_POST['age']) == '') {
        $error[] = "Please enter the patient age";
    }else{
        $age = trim($_POST['age']);
    }

    if(isset($_POST['pid']) && trim($_POST['pid'])!==""){
        $examId = trim($_POST['exam_id']);
        $prescId = trim($_POST['prescription_id']);
        $pWhere = "examination_id='".$examId."' AND id='".$prescId."'";
        $prescrptionArray = array(
            'patient_name' => $_POST['patient_name'],
            'age' => $_POST['age'],
            'prescription_date' => date("Y-m-d", strtotime($_POST['prescription_date'])),
            'sphere_right' => $_POST['sphere_right'],
            'sphere_left' => $_POST['sphere_left'],
            'cylinder_right' => $_POST['cylinder_right'],
            'cylinder_left' => $_POST['cylinder_left'],
            'axis_right' => $_POST['axis_right'],
            'axis_left' => $_POST['axis_left'],
            'bifocal_power' => $_POST['bifocal_power'],
            'additional_right_power' => $_POST['additional_right_power'],
            'additional_left_power' => $_POST['additional_left_power'],
            'right_puppilary_distance' => $_POST['right_puppilary_distance'],
            'left_puppilary_distance' => $_POST['left_puppilary_distance'],
            'notes' => $_POST['notes'],
            'modified' => date("Y-m-d H:i:s")
        );
        $savePrescription = $globalManager->runUpdateQuery("patient_prescriptions", $prescrptionArray, $pWhere);
        if($savePrescription){
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
            if(file_exists(STORAGE_HTTP_PATH.'examinations/'.$pdfFile.'.pdf')){
                $examArray = array(
                    'pdf_file' => $pdfFile.'.pdf'
                );
                $updateExam = $globalManager->runUpdateQuery("patient_examinations", $examArray, "id='".$examId."'");
            }
            ################ END OF PDF FILE #####################
            $_SESSION['message'] = "Patient prescription has been updated.";
            redirect(DOCTOR_SITE_URL."examinations.php");
        }else{
            $_SESSION['errmsg'] = "Updated failed. Please try again";
        }
    }else{
        $prescrptionArray = array(
            'user_id' => $patientId,
            'doctor_id' => $doctorId,
            'examination_id' => $_POST['exam_id'],
            'patient_name' => $_POST['patient_name'],
            'age' => $_POST['age'],
            'prescription_date' => date("Y-m-d", strtotime($_POST['prescription_date'])),
            'sphere_right' => $_POST['sphere_right'],
            'sphere_left' => $_POST['sphere_left'],
            'cylinder_right' => $_POST['cylinder_right'],
            'cylinder_left' => $_POST['cylinder_left'],
            'axis_right' => $_POST['axis_right'],
            'axis_left' => $_POST['axis_left'],
            'bifocal_power' => $_POST['bifocal_power'],
            'additional_right_power' => $_POST['additional_right_power'],
            'additional_left_power' => $_POST['additional_left_power'],
            'right_puppilary_distance' => $_POST['right_puppilary_distance'],
            'left_puppilary_distance' => $_POST['left_puppilary_distance'],
            'notes' => $_POST['notes'],
            'created' => date("Y-m-d H:i:s"),
            'modified' => date("Y-m-d H:i:s")
        );
        $savePrescription = $globalManager->runInsertQuery("patient_prescriptions", $prescrptionArray);
        if($savePrescription){
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
            if(file_exists(STORAGE_HTTP_PATH.'examinations/'.$pdfFile.'.pdf')){
                $examArray = array(
                    'pdf_file' => $pdfFile.'.pdf'
                );
                $updateExam = $globalManager->runUpdateQuery("patient_examinations", $examArray, "id='".$_POST['exam_id']."'");
            }
            ################ END OF PDF FILE #####################
            $_SESSION['message'] = "Patient prescription has been saved.";
            //redirect(DOCTOR_SITE_URL."examinations.php");
            redirect(DOCTOR_SITE_URL.'submitPatientPrescription.php?eid='.$_POST['exam_id']);
        }else{
            $_SESSION['errmsg'] = "Prescription not saved. Please try again";
        }
    }



}

if(isset($_GET['pid'],$_GET['eid']) && trim($_GET['pid'])!=="" && trim($_GET['eid'])!==""){
    //find out the prescription details
    $arrPrescription = $globalManager->runSelectQuery("patient_prescriptions", "*", "id='".$_GET['pid']."' AND examination_id='".$_GET['eid']."'");
    if(is_array($arrPrescription) && count($arrPrescription)>0){
        extract($arrPrescription[0]);
        $prescription_date = date("m/d/Y", strtotime($prescription_date));
    }else{
        $_SESSION['errmsg'] = "Invalid prescription selected to edit";
        redirect(DOCTOR_SITE_URL.'examinations.php');
    }
}