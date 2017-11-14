<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$foo = file_get_contents("php://input");
$result = json_decode($foo, true);

if(is_array($result) && count($result)>0) {
    if(isset($result['doctor_id'],$result['doctor_key'],$result['patient_id'],$result['examination_id'],$result['action']) && trim($result['doctor_id'])!=='' && trim($result['doctor_key'])!=='' && trim($result['patient_id'])!=='' && trim($result['examination_id'])!=='' && trim($result['action'])=='get_examination_details') {
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

        //find out the patient's examinations list
        $getExamination = $globalManager->runSelectQuery("patient_examinations as pe LEFT JOIN users as u ON pe.user_id=u.id", "pe.*,CONCAT(u.firstname,' ',u.lastname) as patientName", "pe.user_id='".$result['patient_id']."' AND pe.id='".$result['examination_id']."'");
        if(is_array($getExamination) && count($getExamination)>0){
            $arrExamination = $getExamination[0];
            //set image path
            if($arrExamination['exam_left_image']!=="" && file_exists(STORAGE_PATH.'examinations/'.$arrExamination['exam_left_image'])){
                $arrExamination['exam_left_image'] = STORAGE_HTTP_PATH.'examinations/'.$arrExamination['exam_left_image'];
            }else{
                $arrExamination['exam_left_image'] = "";
            }
            if($arrExamination['exam_right_image']!=="" && file_exists(STORAGE_PATH.'examinations/'.$arrExamination['exam_right_image'])){
                $arrExamination['exam_right_image'] = STORAGE_HTTP_PATH.'examinations/'.$arrExamination['exam_right_image'];
            }else{
                $arrExamination['exam_right_image'] = "";
            }
            
            //find out the prescription
            $getPrescription = $globalManager->runSelectQuery("patient_prescriptions", "*", "examination_id='".$arrExamination['id']."' AND user_id='".$result['patient_id']."'");
            if(is_array($getPrescription) && count($getPrescription)>0){
                $arrExamination['prescription'] = $getPrescription[0];
            }else{
                //$arrExamination['prescription'] = array();
            }
            header('Content-Type: application/json');
            $arr = array('status'=>'success','data'=>$arrExamination);
            echo json_encode($arr); die;
        }else{
            header('Content-Type: application/json');
            $arr = array('status'=>'error','message'=>'No examination found.','data'=>array());
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
