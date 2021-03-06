<?php
include('../cnf.php');
################# CHECK LOGGED IN USER ##############
validateDoctorLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();

$doctorId = $_SESSION['moore']['doctor']['userid'];
$docname = $_SESSION['moore']['doctor']['name'];

$arrImgExtns = array("jpeg", "jpg", "png", "bmp", "gif");
$arrDocExtns = array("doc", "docx");

//post message
if(isset($_GET['c_id'])){
	//get the conversation id and
    $conversation_id = base64_decode($_GET['c_id']);

    //find out the doctor details
    $dWhere = "c.id='".$conversation_id."'";
	$arrPatient = $globalManager->runSelectQuery("conversations as c LEFT JOIN doctors as d ON c.doctor_id=d.id LEFT JOIN users as u ON c.user_id=u.id", "u.id as userId,CONCAT(u.firstname,' ',u.lastname) as username,d.picture as docPic", $dWhere);
	if(is_array($arrPatient) && count($arrPatient)>0){
		if($arrPatient[0]['docPic'] !== "" && file_exists(STORAGE_PATH.'doctors/'.$arrPatient[0]['docPic'])){
			$docImage = STORAGE_HTTP_PATH.'doctors/'.$arrPatient[0]['docPic'];
		}else{
			$docImage = IMG_PATH.'doctor.jpg';
		}
		$username = $arrPatient[0]['username'];
	}
	
    //find out the earlier messages of this room of last 1 month
	$mWhere = "conversation_id='".$conversation_id."'";// AND msg_date BETWEEN CURDATE() - INTERVAL 60 DAY AND NOW()";
	$arrMessages = $globalManager->runSelectQuery("messages", "*", $mWhere);
}else{

}
?>
<ul class="chat">
	<?php
	if(is_array($arrMessages) && count($arrMessages)>0){
		foreach($arrMessages as $mRow){
			$timeAgo = UtilityManager::get_time_difference($mRow['msg_date']);
			if($mRow['msg_from'] == "D"){
	?>
	<li class="left clearfix">
	    <span class="chat-img pull-left">
	    	<img src="<?php echo $docImage;?>" alt="<?php echo $docname;?>">
	    </span>
	    <div class="chat-body clearfix">
	        <div class="header">
	            <strong class="primary-font"><?php echo $docname;?></strong>
	            <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?php echo $timeAgo;?></small>
	        </div>
	        <p>
	            <?php echo $mRow['message'];?>
	        </p>
	        <?php
	        if($mRow['attachment'] !== "" && file_exists(STORAGE_PATH.'messages/'.$mRow['attachment'])){
	        	$file_ext = pathinfo(STORAGE_PATH.'messages/'.$mRow['attachment'], PATHINFO_EXTENSION);
	        	if(in_array(strtolower($file_ext), $arrImgExtns)) {
	        		echo '<p style="text-align:right;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'" alt="" class="msg-image"></a></p>';
        		}elseif(in_array(strtolower($file_ext), $arrDocExtns)) {
	        		echo '<p style="text-align:right;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.IMG_PATH.'/doc.jpg" alt="" class="msg-file">'.$mRow['filename'].'</a></p>';
        		}elseif($file_ext=="pdf") {
	        		echo '<p style="text-align:right;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.IMG_PATH.'/pdf.png" alt="" class="msg-file">'.$mRow['filename'].'</a></p>';
        		}
	        }
	        ?>
	    </div>
	</li>
	<?php
			}else{
	?>
	<li class="right clearfix">
        <span class="chat-img pull-right">
            <img src="<?php echo IMG_PATH;?>user.jpg" alt="<?php echo $username;?>">
        </span>
        <div class="chat-body clearfix">
            <div class="header">
                <strong class="primary-font"><?php echo $username;?></strong>
                <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?php echo $timeAgo;?></small>
            </div>
            <p>
                <?php echo $mRow['message'];?>
            </p>
            <?php
	        if($mRow['attachment'] !== "" && file_exists(STORAGE_PATH.'messages/'.$mRow['attachment'])){
	        	$file_ext = pathinfo(STORAGE_PATH.'messages/'.$mRow['attachment'], PATHINFO_EXTENSION);
	        	if(in_array(strtolower($file_ext), $arrImgExtns)) {
	        		echo '<p style="text-align:left;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'" alt="" class="msg-image"></a></p>';
        		}elseif(in_array(strtolower($file_ext), $arrDocExtns)) {
	        		echo '<p style="text-align:left;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.IMG_PATH.'/doc.jpg" alt="" class="msg-file">'.$mRow['filename'].'</a></p>';
        		}elseif($file_ext=="pdf") {
	        		echo '<p style="text-align:left;"><a href="'.STORAGE_HTTP_PATH.'messages/'.$mRow['attachment'].'"  download="'.$mRow['filename'].'"><img src="'.IMG_PATH.'/pdf.png" alt="" class="msg-file">'.$mRow['filename'].'</a></p>';
        		}
	        }
	        ?>
        </div>
    </li>
	<?php
			}
		}
	}else{
		//echo '<li class="text-center">No message found</li>';
	}
	?>
</ul>