<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$error = array();
$output_dir = STORAGE_PATH."examinations/";
if(is_array($_REQUEST) && count($_REQUEST)>0) {
    $result = $_REQUEST;
    if(isset($result['doctor_id'],$result['doctor_key'],$result['patient_id'],$result['action']) && trim($result['doctor_id'])!=='' && trim($result['doctor_key'])!=='' && trim($result['patient_id'])!=='' && trim($result['action'])=='save_patient_examination') {
    	##---------------CHECK VALID DOCTOR IN DATABASE START------------------##
    	$doctorId = trim($result['doctor_id']);
		//decrypt security key
        $securityKey = UtilityManager::decrypt($result['doctor_key']);
        //check user
        $dWhere = "id='".$result['doctor_id']."' AND security_key='".$securityKey."'";
		$getDoctorRecord = $globalManager->runSelectQuery('doctors','IFNULL(COUNT(id),0) as total',$dWhere);
		if($getDoctorRecord[0]['total'] == "0"){
			header('Content-Type: application/json');
			$arr = array('status'=>'error','message'=>'Doctor not exists in our database');
			echo json_encode($arr); die;
		}

    	##---------------END CHECK DOCTOR IN DATABASE START------------------##

        ##---------------CHECK PATIENT IN DATABASE START------------------##
        $whereUser= "id='".$result['patient_id']."'";
        $getUserRecord = $globalManager->runSelectQuery('users','id,email',$whereUser);
        if(is_array($getUserRecord) && count($getUserRecord)>0) {
        }
        else {
            header('Content-Type: application/json');
            $arr = array('status'=>'error','message'=>'Patient not exists in our database');
            echo json_encode($arr); die;
        }
        ##---------------CHECK USERS IN DATABASE END------------------##
		$curr_date = date("Y-m-d H:i:s");
		//save examination

		//upload images
		$leftImage = "";
		$rightImage = "";
		$extensions = array("jpeg","jpg","png","bmp","gif");
		if(is_array($_FILES['exam_left_image']) && trim($_FILES['exam_left_image']['name'])!=='' && isset($_FILES['exam_left_image']['error']) && trim($_FILES['exam_left_image']['error'])=='0') {
			$imgFile = $_FILES['exam_left_image'];
            $file_name = $imgFile['name'];
            $file_size = $imgFile['size'];
            $file_tmp = $imgFile['tmp_name'];
            $file_type = $imgFile['type'];

            //check the file extension
            $file_ext = pathinfo($imgFile['name'], PATHINFO_EXTENSION);
            $file_ext = strtolower($file_ext);
            if(in_array($file_ext,$extensions ) === false){
                header('Content-Type: application/json');
                $arr = array('status'=>'error','message'=>"Extension not allowed for file ".$file_name);
                echo json_encode($arr);
                die;
            }

            //check the file size
            if($file_size > 2097152){
                header('Content-Type: application/json');
                $arr = array('status'=>'error','message'=>"File size for image ".$file_name." must be less than 2 MB");
                echo json_encode($arr);
                die;
            }

            if(empty($error)){
                $filename = UtilityManager::generateImageName(18).'.'.$file_ext;
                if(move_uploaded_file($file_tmp, $output_dir.$filename)) {
                    $leftImage = $filename;
                }
            }
		}

		if(is_array($_FILES['exam_right_image']) && trim($_FILES['exam_right_image']['name'])!=='' && isset($_FILES['exam_right_image']['error']) && trim($_FILES['exam_right_image']['error'])=='0') {
			$imgFile = $_FILES['exam_right_image'];
            $file_name = $imgFile['name'];
            $file_size = $imgFile['size'];
            $file_tmp = $imgFile['tmp_name'];
            $file_type = $imgFile['type'];

            //check the file extension
            $file_ext = pathinfo($imgFile['name'], PATHINFO_EXTENSION);
            $file_ext = strtolower($file_ext);
            if(in_array($file_ext,$extensions ) === false){
                header('Content-Type: application/json');
                $arr = array('status'=>'error','message'=>"Extension not allowed for file ".$file_name);
                echo json_encode($arr);
                die;
            }

            //check the file size
            if($file_size > 2097152){
                header('Content-Type: application/json');
                $arr = array('status'=>'error','message'=>"File size for image ".$file_name." must be less than 2 MB");
                echo json_encode($arr);
                die;
            }

            if(empty($error)){
                $filename = UtilityManager::generateImageName(18).'.'.$file_ext;
                if(move_uploaded_file($file_tmp, $output_dir.$filename)) {
                    $rightImage = $filename;
                }
            }

		}

		$examArray = array(
			'user_id' => $result['patient_id'],
			'doctor_id' => $result['doctor_id'],
			'age' => $result['age'],
			'chief_complaint' => $result['chief_complaint'],
			'symptoms' => $result['symptoms'],
			'location' => $result['location'],
			'onset' => $result['onset'],
			'frequency' => $result['frequency'],
			'severity' => $result['severity'],
			'context' => $result['context'],
			'modifiers' => $result['modifiers'],
			'allergies' => $result['allergies'],
			'medications' => $result['medications'],
			'ocular_ros' => $result['ocular_ros'],
			'hx_fhx' => $result['hx_fhx'],
			'hx_ros_from' => date("Y-m-d", strtotime($result['hx_ros_from'])),
			'head_face' => $result['head_face'],
			'mood_affect' => $result['mood_affect'],
			'is_oriented' => $result['is_oriented'],
			'eom_full_smooth' => $result['eom_full_smooth'],
			'cover_test' => $result['cover_test'],
			'npc_text' => $result['npc_text'],
			'confrontations' => $result['confrontations'],
			'dvasc_text' => $result['dvasc_text'],
			'dvasc_od' => $result['dvasc_od'],
			'dvasc_os' => $result['dvasc_os'],
			'tonometry_time' => date("H:i:s", strtotime($_POST['tonometry_time'])),
            'tonometry_od' => $_POST['tonometry_od'],
            'tonometry_os' => $_POST['tonometry_os'],
			'current_rx' => $result['current_rx'],
			'current_rx_od' => $result['current_rx_od'],
			'current_rx_os' => $result['current_rx_os'],
			'current_rx_add' => $result['current_rx_add'],
			'keratometry_od' => $result['keratometry_od'],
			'keratometry_os' => $result['keratometry_os'],
			'nva' => $result['nva'],
			'nva_od' => $result['nva_od'],
			'nva_os' => $result['nva_os'],
			'pupils' => $result['pupils'],
			'subjective_od' => $result['subjective_od'],
			'subjective_os' => $result['subjective_os'],
			'subjective_add' => $result['subjective_add'],
			'trial_frame' => $result['trial_frame'],
			'slit_lamp_tear_od' => $result['slit_lamp_tear_od'],
			'slit_lamp_tear_os' => $result['slit_lamp_tear_os'],
			'slit_lamp_ll_od' => $result['slit_lamp_ll_od'],
			'slit_lamp_ll_os' => $result['slit_lamp_ll_os'],
			'slit_lamp_conj_od' => $result['slit_lamp_conj_od'],
			'slit_lamp_conj_os' => $result['slit_lamp_conj_os'],
			'slit_lamp_cornea_od' => $result['slit_lamp_cornea_od'],
			'slit_lamp_cornea_os' => $result['slit_lamp_cornea_os'],
			'slit_lamp_angles_od' => $result['slit_lamp_angles_od'],
			'slit_lamp_angles_os' => $result['slit_lamp_angles_os'],
			'slit_lamp_ac_od' => $result['slit_lamp_ac_od'],
			'slit_lamp_ac_os' => $result['slit_lamp_ac_os'],
			'slit_lamp_iris_od' => $result['slit_lamp_iris_od'],
			'slit_lamp_iris_os' => $result['slit_lamp_iris_os'],
			'slit_lamp_lens_od' => $result['slit_lamp_lens_od'],
			'slit_lamp_lens_os' => $result['slit_lamp_lens_os'],
			'slit_lamp_vit_od' => $result['slit_lamp_vit_od'],
			'slit_lamp_vit_os' => $result['slit_lamp_vit_os'],
			'slit_lamp_comment' => $result['slit_lamp_comment'],
			'fundus' => $result['fundus'],
			'fundus_cd_od' => $result['fundus_cd_od'],
			'fundus_cd_os' => $result['fundus_cd_os'],
			'fundus_disc_od' => $result['fundus_disc_od'],
			'fundus_disc_os' => $result['fundus_disc_os'],
			'fundus_bv_od' => $result['fundus_bv_od'],
			'fundus_bv_os' => $result['fundus_bv_os'],
			'fundus_macuala_od' => $result['fundus_macuala_od'],
			'fundus_macuala_os' => $result['fundus_macuala_os'],
			'fundus_fundus_od' => $result['fundus_fundus_od'],
			'fundus_fundus_os' => $result['fundus_fundus_os'],
			'fundus_periph_od' => $result['fundus_periph_od'],
			'fundus_periph_os' => $result['fundus_periph_os'],
			'fundus_comment' => $result['fundus_comment'],
			'rtc_text' => $result['rtc_text'],
			'extent_seen_ou' => $result['extent_seen_ou'],
			'ed_adaption' => $result['ed_adaption'],
			'ed_uv_protection' => $result['ed_uv_protection'],
			'ed_bs_bp_control' => $result['ed_bs_bp_control'],
			'ed_sg_sx_rd' => $result['ed_sg_sx_rd'],
			'ed_cl_wear' => $result['ed_cl_wear'],
			'ed_compliance_med' => $result['ed_compliance_med'],
			'examining_doctor' => $result['examining_doctor'],
			'modified' => $curr_date,
			'created' => $curr_date
		);

		if($leftImage !== ""){
			$examArray['exam_left_image'] = $leftImage;
		}
		if($rightImage !== ""){
			$examArray['exam_right_image'] = $rightImage;
		}

		$saveExamination = $globalManager->runInsertQuery("patient_examinations", $examArray);
		if($saveExamination){
			$examId = $saveExamination;
			header('Content-Type: application/json');
            $arr = array('status'=>'success','data'=>(string)$examId);
            echo json_encode($arr); die;
        }else{
            header('Content-Type: application/json');
            $arr = array('status'=>'error','message'=>'Action failed','data'=>'');
            echo json_encode($arr);die;
        }
        
    }else{
        header('Content-Type: application/json');
        $arr = array('status'=>'error','message'=>'Sorry! you have posted invalid information','data'=>array());
        echo json_encode($arr);die;
    }
}else{
    header('Content-Type: application/json');
    $arr = array('status'=>'error','message'=>'Sorry! you have not posted any information','data'=>array());
    echo json_encode($arr);die;
}