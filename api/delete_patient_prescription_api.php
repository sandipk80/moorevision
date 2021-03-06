<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$foo = file_get_contents("php://input");
$result = json_decode($foo, true);

if(is_array($result) && count($result)>0) {
    if(isset($result['doctor_id'],$result['doctor_key'],$result['prescription_id'],$result['action']) && trim($result['doctor_id'])!=='' && trim($result['doctor_key'])!=='' && trim($result['prescription_id'])!=='' && trim($result['action'])=='delete_patient_prescription') {
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

        //delete the patient's prescription
        $delPrescription = $globalManager->runDeleteQuery("patient_prescriptions", "id='".$result['prescription_id']."'");
        if($delPrescription){
            header('Content-Type: application/json');
            $arr = array('status'=>'success','message'=>'Patient prescription deleted.');
            echo json_encode($arr); die;
        }else{
            header('Content-Type: application/json');
            $arr = array('status'=>'error','message'=>'Action failed');
            echo json_encode($arr); die;
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
