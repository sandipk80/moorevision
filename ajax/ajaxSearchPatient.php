<?php
include('../cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

//find out the list of doctors whom contacted
$uWhere = "u.status='1' AND u.active='1'";
if(isset($_GET['p']) && trim($_GET['p'])!==""){
	$uWhere .= " AND (firstname LIKE '".trim($_GET['p'])."%' OR lastname LIKE '".trim($_GET['p'])."%')";
}

$arrPatients = $globalManager->runSelectQuery("users as u LEFT JOIN conversations as c ON u.id=c.user_id", "u.id as userId,CONCAT(u.firstname,' ',u.lastname) as username,IFNULL(c.id,0) as conversationId", $uWhere);
if(is_array($arrPatients) && count($arrPatients)>0){
	foreach($arrPatients as $k=>$uRow){
		$patientImg = IMG_PATH.'user.jpg';
		if(isset($userId) && $userId==$uRow['userId']){
            $actClass = "active";
        }else{
            $actClass = "";
        }
		if($uRow['conversationId']){
			//find out the last message
			$getMessage = $globalManager->runSelectQuery("messages", "message,msg_date", "conversation_id='".$uRow['conversationId']."' ORDER BY msg_date DESC LIMIT 1");
			if(is_array($getMessage) && count($getMessage)>0){
				$last_msg = $getMessage[0]['message'];
				$postedTime = UtilityManager::get_time_difference($getMessage[0]['msg_date']);
				//find out the count of total unread messages
				$getMessageCount = $globalManager->runSelectQuery("messages", "IFNULL(COUNT(id),0) as total", "conversation_id='".$uRow['conversationId']."' AND doctor_flag='0'");
				$msg_count = $getMessageCount[0]['total'];
			}else{
				$last_msg = "";
				$postedTime = "";
				$msg_count = 0;
			}
		}else{
			$last_msg = "";
			$postedTime = "";
			$msg_count = 0;
		}
?>
	<li class="<?php echo $actClass;?> bounceInDown">
        <a href="<?php echo DOCTOR_SITE_URL.'message.php?room='.$uRow['userId'];?>" class="clearfix">
            <img src="<?php echo $patientImg;?>" alt="" class="img-circle">
            <div class="friend-name">   
                <strong><?php echo $uRow['username'];?></strong>
            </div>
            <div class="last-message text-muted"><?php echo $last_msg;?></div>
            <small class="time text-muted"><?php echo $postedTime;?></small>
            <?php echo $msg_count>0 ? '<small class="chat-alert label label-danger">'.$msg_count.'</small>' : '';?>
        </a>
    </li>
<?php
	}
}else{
	echo '<li>No patient found</li>';
}
?>