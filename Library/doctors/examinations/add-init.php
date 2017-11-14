<?php
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
require_once(LIB_PATH. "PHPMailer/class.phpmailer.php");
$pageTitle = "Add Patient Examination";

$doctorId = $_SESSION['moore']['doctor']['userid'];

//signup submit
$error = array();

if(isset($_POST['add-examination']) && trim($_POST['add-examination'])=='submit') {
    
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
    if(is_array($_POST['confrontations']) && count($_POST['confrontations'])>0){
        if(count($_POST['confrontations']) > 1){
            $confrontations = 'BOTH';
        }else{
            $confrontations = implode(",", $_POST['confrontations']);
            $confrontations = trim($confrontations, ",");
        }
    }else{
        $confrontations = "";
    }
    if(is_array($_POST['fundus']) && count($_POST['fundus'])>0){
        $fundus = implode(",", $_POST['fundus']);
    }else{
        $fundus = "";
    }

    if (empty($error)) {
        $current_date = date("Y-m-d H:i:s");
        if(isset($_POST['exam_id']) && trim($_POST['exam_id'])!==""){
            $eWhere = "id='".$_POST['exam_id']."'";
            $examArray = array(
                'patient_name' => $_POST['patient_name'],
                'age' => $_POST['age'],
                'exam_date' => date("Y-m-d", strtotime($_POST['exam_date'])),
                'chief_complaint' => $_POST['chief_complaint'],
                'symptoms' => $_POST['symptoms'],
                'location' => $_POST['location'],
                'onset' => $_POST['onset'],
                'frequency' => $_POST['frequency'],
                'severity' => $_POST['severity'],
                'context' => $_POST['context'],
                'modifiers' => $_POST['modifiers'],
                'allergies' => $_POST['allergies'],
                'medications' => $_POST['medications'],
                'ocular_ros' => $_POST['ocular_ros'],
                'hx_fhx' => $_POST['hx_fhx'],
                'hx_ros_from' => date("Y-m-d", strtotime($_POST['hx_ros_from'])),
                'head_face' => $_POST['head_face'],
                'mood_affect' => $_POST['mood_affect'],
                'is_oriented' => $_POST['is_oriented'],
                'eom_full_smooth' => $_POST['eom_full_smooth'],
                'cover_test' => $_POST['cover_test'],
                'npc_text' => $_POST['npc_text'],
                'confrontations' => $confrontations,
                'dvasc_text' => $_POST['dvasc_text'],
                'dvasc_od' => $_POST['dvasc_od'],
                'dvasc_os' => $_POST['dvasc_os'],
                'tonometry_time' => date("H:i:s", strtotime($_POST['tonometry_time'])),
                'tonometry_od' => $_POST['tonometry_od'],
                'tonometry_os' => $_POST['tonometry_os'],
                'current_rx' => $_POST['current_rx'],
                'current_rx_od' => $_POST['current_rx_od'],
                'current_rx_os' => $_POST['current_rx_os'],
                'current_rx_add' => $_POST['current_rx_add'],
                'keratometry_od' => $_POST['keratometry_od'],
                'keratometry_os' => $_POST['keratometry_os'],
                'nva' => $_POST['nva'],
                'nva_od' => $_POST['nva_od'],
                'nva_os' => $_POST['nva_os'],
                'pupils' => $_POST['pupils'],
                'subjective_od' => $_POST['subjective_od'],
                'subjective_os' => $_POST['subjective_os'],
                'subjective_add' => $_POST['subjective_add'],
                'trial_frame' => $_POST['trial_frame'],
                'slit_lamp_tear_od' => $_POST['slit_lamp_tear_od'],
                'slit_lamp_tear_os' => $_POST['slit_lamp_tear_os'],
                'slit_lamp_ll_od' => $_POST['slit_lamp_ll_od'],
                'slit_lamp_ll_os' => $_POST['slit_lamp_ll_os'],
                'slit_lamp_conj_od' => $_POST['slit_lamp_conj_od'],
                'slit_lamp_conj_os' => $_POST['slit_lamp_conj_os'],
                'slit_lamp_cornea_od' => $_POST['slit_lamp_cornea_od'],
                'slit_lamp_cornea_os' => $_POST['slit_lamp_cornea_os'],
                'slit_lamp_angles_od' => $_POST['slit_lamp_angles_od'],
                'slit_lamp_angles_os' => $_POST['slit_lamp_angles_os'],
                'slit_lamp_ac_od' => $_POST['slit_lamp_ac_od'],
                'slit_lamp_ac_os' => $_POST['slit_lamp_ac_os'],
                'slit_lamp_iris_od' => $_POST['slit_lamp_iris_od'],
                'slit_lamp_iris_os' => $_POST['slit_lamp_iris_os'],
                'slit_lamp_lens_od' => $_POST['slit_lamp_lens_od'],
                'slit_lamp_lens_os' => $_POST['slit_lamp_lens_os'],
                'slit_lamp_vit_od' => $_POST['slit_lamp_vit_od'],
                'slit_lamp_vit_os' => $_POST['slit_lamp_vit_os'],
                'slit_lamp_comment' => $_POST['slit_lamp_comment'],
                'fundus' => $fundus,
                'fundus_cd_od' => $_POST['fundus_cd_od'],
                'fundus_cd_os' => $_POST['fundus_cd_os'],
                'fundus_disc_od' => $_POST['fundus_disc_od'],
                'fundus_disc_os' => $_POST['fundus_disc_os'],
                'fundus_bv_od' => $_POST['fundus_bv_od'],
                'fundus_bv_os' => $_POST['fundus_bv_os'],
                'fundus_macuala_od' => $_POST['fundus_macuala_od'],
                'fundus_macuala_os' => $_POST['fundus_macuala_os'],
                'fundus_fundus_od' => $_POST['fundus_fundus_od'],
                'fundus_fundus_os' => $_POST['fundus_fundus_os'],
                'fundus_periph_od' => $_POST['fundus_periph_od'],
                'fundus_periph_os' => $_POST['fundus_periph_os'],
                'fundus_comment' => $_POST['fundus_comment'],
                'rtc_text' => $_POST['rtc_text'],
                'extent_seen_ou' => $_POST['extent_seen_ou'],
                'ed_adaption' => $_POST['ed_adaption'],
                'ed_uv_protection' => $_POST['ed_uv_protection'],
                'ed_bs_bp_control' => $_POST['ed_bs_bp_control'],
                'ed_sg_sx_rd' => $_POST['ed_sg_sx_rd'],
                'ed_cl_wear' => $_POST['ed_cl_wear'],
                'ed_compliance_med' => $_POST['ed_compliance_med'],
                'examining_doctor' => $_POST['examining_doctor'],
                'modified' => $current_date
            );
            if(isset($_POST['left_eye_image']) && $_POST['left_eye_image'] !== ""){
                $examArray['exam_left_image'] = $_POST['left_eye_image'];
            }
            if(isset($_POST['right_eye_image']) && $_POST['right_eye_image'] !== ""){
                $examArray['exam_right_image'] = $_POST['right_eye_image'];
            }
            //prx($examArray);
            $saveExamination = $globalManager->runUpdateQuery("patient_examinations", $examArray, $eWhere);
            if($saveExamination){
                $_SESSION['message'] = "Patient examination has been updated.";
                redirect(DOCTOR_SITE_URL.'examinations.php?pid='.$_GET['pid']);
            }
        }else{
            //add new examination
            $examArray = array(
                'user_id' => $_POST['patient_id'],
                'doctor_id' => $doctorId,
                'patient_name' => $_POST['patient_name'],
                'age' => $_POST['age'],
                'exam_date' => date("Y-m-d", strtotime($_POST['exam_date'])),
                'chief_complaint' => $_POST['chief_complaint'],
                'symptoms' => $_POST['symptoms'],
                'location' => $_POST['location'],
                'onset' => $_POST['onset'],
                'frequency' => $_POST['frequency'],
                'severity' => $_POST['severity'],
                'context' => $_POST['context'],
                'modifiers' => $_POST['modifiers'],
                'allergies' => $_POST['allergies'],
                'medications' => $_POST['medications'],
                'ocular_ros' => $_POST['ocular_ros'],
                'hx_fhx' => $_POST['hx_fhx'],
                'hx_ros_from' => date("Y-m-d", strtotime($_POST['hx_ros_from'])),
                'head_face' => $_POST['head_face'],
                'mood_affect' => $_POST['mood_affect'],
                'is_oriented' => $_POST['is_oriented'],
                'eom_full_smooth' => $_POST['eom_full_smooth'],
                'cover_test' => $_POST['cover_test'],
                'npc_text' => $_POST['npc_text'],
                'confrontations' => $confrontations,
                'dvasc_text' => $_POST['dvasc_text'],
                'dvasc_od' => $_POST['dvasc_od'],
                'dvasc_os' => $_POST['dvasc_os'],
                'tonometry_time' => date("H:i:s", strtotime($_POST['tonometry_time'])),
                'tonometry_od' => $_POST['tonometry_od'],
                'tonometry_os' => $_POST['tonometry_os'],
                'current_rx' => $_POST['current_rx'],
                'current_rx_od' => $_POST['current_rx_od'],
                'current_rx_os' => $_POST['current_rx_os'],
                'current_rx_add' => $_POST['current_rx_add'],
                'keratometry_od' => $_POST['keratometry_od'],
                'keratometry_os' => $_POST['keratometry_os'],
                'nva' => $_POST['nva'],
                'nva_od' => $_POST['nva_od'],
                'nva_os' => $_POST['nva_os'],
                'pupils' => $_POST['pupils'],
                'subjective_od' => $_POST['subjective_od'],
                'subjective_os' => $_POST['subjective_os'],
                'subjective_add' => $_POST['subjective_add'],
                'trial_frame' => $_POST['trial_frame'],
                'slit_lamp_tear_od' => $_POST['slit_lamp_tear_od'],
                'slit_lamp_tear_os' => $_POST['slit_lamp_tear_os'],
                'slit_lamp_ll_od' => $_POST['slit_lamp_ll_od'],
                'slit_lamp_ll_os' => $_POST['slit_lamp_ll_os'],
                'slit_lamp_conj_od' => $_POST['slit_lamp_conj_od'],
                'slit_lamp_conj_os' => $_POST['slit_lamp_conj_os'],
                'slit_lamp_cornea_od' => $_POST['slit_lamp_cornea_od'],
                'slit_lamp_cornea_os' => $_POST['slit_lamp_cornea_os'],
                'slit_lamp_angles_od' => $_POST['slit_lamp_angles_od'],
                'slit_lamp_angles_os' => $_POST['slit_lamp_angles_os'],
                'slit_lamp_ac_od' => $_POST['slit_lamp_ac_od'],
                'slit_lamp_ac_os' => $_POST['slit_lamp_ac_os'],
                'slit_lamp_iris_od' => $_POST['slit_lamp_iris_od'],
                'slit_lamp_iris_os' => $_POST['slit_lamp_iris_os'],
                'slit_lamp_lens_od' => $_POST['slit_lamp_lens_od'],
                'slit_lamp_lens_os' => $_POST['slit_lamp_lens_os'],
                'slit_lamp_vit_od' => $_POST['slit_lamp_vit_od'],
                'slit_lamp_vit_os' => $_POST['slit_lamp_vit_os'],
                'slit_lamp_comment' => $_POST['slit_lamp_comment'],
                'fundus' => $fundus,
                'fundus_cd_od' => $_POST['fundus_cd_od'],
                'fundus_cd_os' => $_POST['fundus_cd_os'],
                'fundus_disc_od' => $_POST['fundus_disc_od'],
                'fundus_disc_os' => $_POST['fundus_disc_os'],
                'fundus_bv_od' => $_POST['fundus_bv_od'],
                'fundus_bv_os' => $_POST['fundus_bv_os'],
                'fundus_macuala_od' => $_POST['fundus_macuala_od'],
                'fundus_macuala_os' => $_POST['fundus_macuala_os'],
                'fundus_fundus_od' => $_POST['fundus_fundus_od'],
                'fundus_fundus_os' => $_POST['fundus_fundus_os'],
                'fundus_periph_od' => $_POST['fundus_periph_od'],
                'fundus_periph_os' => $_POST['fundus_periph_os'],
                'fundus_comment' => $_POST['fundus_comment'],
                'rtc_text' => $_POST['rtc_text'],
                'extent_seen_ou' => $_POST['extent_seen_ou'],
                'ed_adaption' => $_POST['ed_adaption'],
                'ed_uv_protection' => $_POST['ed_uv_protection'],
                'ed_bs_bp_control' => $_POST['ed_bs_bp_control'],
                'ed_sg_sx_rd' => $_POST['ed_sg_sx_rd'],
                'ed_cl_wear' => $_POST['ed_cl_wear'],
                'ed_compliance_med' => $_POST['ed_compliance_med'],
                'examining_doctor' => $_POST['examining_doctor'],
                'modified' => $current_date,
                'created' => $current_date
            );
            if(isset($_POST['left_eye_image']) && $_POST['left_eye_image'] !== ""){
                $examArray['exam_left_image'] = $_POST['left_eye_image'];
            }
            if(isset($_POST['right_eye_image']) && $_POST['right_eye_image'] !== ""){
                $examArray['exam_right_image'] = $_POST['right_eye_image'];
            }
            //prx($examArray);
            $saveExamination = $globalManager->runInsertQuery("patient_examinations", $examArray);
            if($saveExamination){
                $examId = $saveExamination;
                $_SESSION['message'] = "Patient examination has been added. You can add the prescription below for this saved examination.";
                redirect(DOCTOR_SITE_URL.'submitPatientExamination.php?eid='.$examId);
            } else {
                $_SESSION['errmsg'] = "Submission failed! Please try again";
            }

        }
    }
}

if(isset($_GET['eid'],$_GET['pid']) && trim($_GET['eid'])!=="" && trim($_GET['pid'])!==""){
    $getExaminations = $globalManager->runSelectQuery("patient_examinations", "*", "id='".$_GET['eid']."'");
    if(is_array($getExaminations) && count($getExaminations)>0){
        //prx($getExaminations[0]);
        extract($getExaminations[0]);
        if($exam_date !== "0000-00-00"){
            $exam_date = date("m/d/Y", strtotime($exam_date));
        }
        if($hx_ros_from !== "0000-00-00"){
            $hx_ros_from = date("m/d/Y", strtotime($hx_ros_from));
        }
    }else{
        $_SESSION['errmsg'] = "Selected examination does not exist! Please select valid examination to update";
        redirect(DOCTOR_SITE_URL.'examinations.php?pid='.$getExaminations);
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