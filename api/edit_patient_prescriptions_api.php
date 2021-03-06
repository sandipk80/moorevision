<?php
include('../cnf.php');
$foo = file_get_contents("php://input");
$result = json_decode($foo, true);
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$error = array();

if(is_array($result) && count($result)>0) {
    if(isset($result['doctor_id'],$result['doctor_key'],$result['patient_id'],$result['prescription_id'],$result['action']) && trim($result['doctor_id'])!=='' && trim($result['doctor_key'])!=='' && trim($result['patient_id'])!=='' && trim($result['prescription_id'])!=='' && trim($result['action'])=='edit_patient_prescription') {
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
        
        ##---------------CHECK USERS IN DATABASE START------------------##
        $pWhere = "id='".$result['prescription_id']."' AND user_id='".$result['patient_id']."'";
        $getUserRecord = $globalManager->runSelectQuery('patient_prescriptions','IFNULL(COUNT(id),0) as total',$pWhere);
        if($getUserRecord[0]['total']>0) {
        }
        else {
            header('Content-Type: application/json');
            $arr = array('status'=>'error','message'=>'Patient prescription not exists in our database');
            echo json_encode($arr); die;
        }
        ##---------------CHECK USERS IN DATABASE END------------------##
		$curr_date = date("Y-m-d H:i:s");
		$prescriptionArray = array(
			'user_id' => $result['patient_id'],
			'doctor_id' => $result['doctor_id'],
			'patient_name' => $result['patient_name'],
			'prescription_date' => date("Y-m-d", strtotime($result['prescription_date'])),
			'age' => $result['age'],
            'sphere_right' => $result['sphere_right'],
			'sphere_left' => $result['sphere_left'],
			'cylinder_right' => $result['cylinder_right'],
			'cylinder_left' => $result['cylinder_left'],
			'axis_right' => $result['axis_right'],
			'axis_left' => $result['axis_left'],
			'additional_right_power' => $result['additional_right_power'],
			'additional_left_power' => $result['additional_left_power'],
			'right_puppilary_distance' => $result['right_puppilary_distance'],
			'left_puppilary_distance' => $result['left_puppilary_distance'],
			'lens_type' => $result['lens_type'],
            'use_instructions' => $result['use_instructions'],
            'lens_recommendations' => $result['lens_recommendations'],
            'notes' => $result['notes'],
			'modified' => $curr_date
		);

		$savePrescription = $globalManager->runUpdateQuery("patient_prescriptions", $prescriptionArray, "id='".$result['prescription_id']."' AND user_id='".$result['patient_id']."'");
		if($savePrescription){
			header('Content-Type: application/json');
            $arr = array('status'=>'success','message'=>'Patient prescription details has been updated.');
            echo json_encode($arr); die;
        }else{
            header('Content-Type: application/json');
            $arr = array('status'=>'error','message'=>'Action failed');
            echo json_encode($arr);die;
        }
        
    }else{
        header('Content-Type: application/json');
        $arr = array('status'=>'error','message'=>'Sorry! you have posted invalid information');
        echo json_encode($arr);die;
    }
}else{
    header('Content-Type: application/json');
    $arr = array('status'=>'error','message'=>'Sorry! you have not posted any information');
    echo json_encode($arr);die;
}