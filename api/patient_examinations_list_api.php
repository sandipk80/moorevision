<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
$foo = file_get_contents("php://input");
$result = json_decode($foo, true);

if(is_array($result) && count($result)>0) {
    if(isset($result['doctor_id'],$result['doctor_key'],$result['patient_id'],$result['action']) && trim($result['doctor_id'])!=='' && trim($result['doctor_key'])!=='' && trim($result['patient_id'])!=='' && trim($result['action'])=='get_examinations_list') {
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
        $arrPrescription = array();
        //find out the patient's examinations list
        $arrExaminations = $globalManager->runSelectQuery("patient_examinations as pe LEFT JOIN users as u ON pe.user_id=u.id", "pe.id as examId,pe.age,pe.modified as examDate,CONCAT(u.firstname,' ',u.lastname) as patientName", "pe.user_id='".$result['patient_id']."' ORDER BY pe.modified DESC");
        if(is_array($arrExaminations) && count($arrExaminations)>0){
            foreach($arrExaminations as $key=>$value){
                //find out the prescription
                $getPrescription = $globalManager->runSelectQuery("patient_prescriptions", "id,prescription_date", "examination_id='".$value['id']."' AND user_id='".$result['patient_id']."'");
                if(is_array($getPrescription) && count($getPrescription) > 0){
                    $arrPrescription[] = $getPrescription[0];
                    $arrExaminations[$key]['isPrecription'] = "1";
                }else{
                    $arrExaminations[$key]['isPrecription'] = "0";
                }
            }
            header('Content-Type: application/json');
            $arr = array('status'=>'success','examinations'=>$arrExaminations,'prescriptions'=>$arrPrescription);
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
