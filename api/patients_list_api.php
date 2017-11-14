<?php
include('../cnf.php');
$foo = file_get_contents("php://input");
$result = json_decode($foo, true);
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

if(is_array($result) && count($result)>0) {
	if(isset($result['doctor_id'],$result['doctor_key'],$result['action']) && trim($result['doctor_id'])!=='' && trim($result['doctor_key'])!=='' && trim($result['action']) == "get_patient_list"){
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


		$where = "status='1' AND active='1'";
		$arrUsers = $globalManager->runSelectQuery("users", "id,firstname,lastname,email,phone,date_of_birth", $where);
		if(is_array($arrUsers) && count($arrUsers)>0){
			header('Content-Type: application/json');
	        $arr = array('status'=>'success','patients'=>$arrUsers);
	        echo json_encode($arr); die;
		}else{
			header('Content-Type: application/json');
	        $arr = array('status'=>'error','patients'=>array());
	        echo json_encode($arr); die;
		}
	}else {
		header('Content-Type: application/json');
		$arr = array('status'=>'error','message'=>'Sorry! please provide valid information.');
		echo json_encode($arr); die;
	}
}
else {
	header('Content-Type: application/json');
	$arr = array('status'=>'error','message'=>'Sorry! you have not posted any information');
	echo json_encode($arr); die;
}