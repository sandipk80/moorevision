<?php
include('cnf.php');
################# CHECK LOGGED IN USER ##############
validateUserLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH.'users/message/index-init.php');
include(LIB_HTML . 'header.php');
?>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.form.js"></script>
<div class="main-banner five">
    <div class="container">
        <h2><span>Messages</span></h2>
    </div>
</div>
<!-- Breadcrumb Starts -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled list-inline">
            <li><a href="index.html">Home</a></li>
            <li class="active">Messages</li>
        </ul>
    </div>
</div>
<div class="container main-container">
    <!-- Doctor Profile Starts -->
    <div class="row">
        <div class="col-md-4 bg-white ">
            <div class="lt-member-header row border-bottom padding-sm text-center">
                Doctors
            </div>
            
            <!-- =============================================================== -->
            <!-- member list -->
            <ul class="friend-list">
                <?php
                if(is_array($arrDoctors) && count($arrDoctors)>0){
                    foreach($arrDoctors as $doc){
                        $postedTime = UtilityManager::get_time_difference($doc['msg_date']);
                        if($doc['picture'] !== "" && file_exists(STORAGE_PATH.'doctors/'.$doc['picture'])){
                            $docImg = STORAGE_HTTP_PATH.'doctors/'.$doc['picture'];
                        }else{
                            $docImg = IMG_PATH.'doctor.jpg';
                        }
                        if(isset($doctorId) && $doctorId==$doc['docId']){
                            $actClass = "active";
                        }else{
                            $actClass = "";
                        }
                        if($doc['msg_date'] !== ""){
                            $postedTime = UtilityManager::get_time_difference($doc['msg_date']);
                        }else{
                            $postedTime = "";
                        }
                ?>
                <li class="<?php echo $actClass;?> bounceInDown">
                    <a href="<?php echo USER_SITE_URL.'message.php?room='.$doc['docId'];?>" class="clearfix">
                        <img src="<?php echo $docImg;?>" alt="" class="img-circle">
                        <div class="friend-name">   
                            <strong><?php echo $doc['docname'];?></strong>
                        </div>
                        <div class="last-message text-muted"><?php echo $doc['last_msg'];?></div>
                        <small class="time text-muted"><?php echo $postedTime;?></small>
                        <?php echo $doc['msg_count']>0 ? '<small class="chat-alert label label-danger">'.$doc['msg_count'].'</small>' : '';?>
                    </a>
                </li>
                <?php
                    }
                }
                ?>
                                
            </ul>
        </div>

        <!--=========================================================-->
        <!-- selected chat -->
        <div class="col-md-8 bg-white ">
            <div class="chat-message display-message">
                
            </div>
            <div class="chat-box bg-white">
                <form id="frmPostMessage" name="frmPostMessage" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" id="conversation_id" value="<?php echo base64_encode($conversation_id); ?>">
                        <input type="hidden" id="doc_id" value="<?php echo base64_encode($doctorId); ?>">
                        <textarea id="message" name="message" class="form-control border no-shadow no-rounded" placeholder="Type your message here"></textarea>
                    </div>
                    <div class="input-group">
                        <div id="attachBtn">
                            <input type="file" id="msgFile" name="msgFile"/> <img src="<?php echo IMG_PATH;?>attach.png" alt="Upload" />
                        </div>
                        <span class="input-group-btn">
                            <button class="btn btn-success no-rounded" type="submit" id="send-message">Send</button>
                            <span id="loading" style="display:none;"><img src="<?php echo IMG_PATH;?>loading.gif" alt="loading"></span>
                        </span>
                    </div><!-- /input-group --> 
                    <span id="error"></span>
                </form>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("#myAppointments").addClass("active");

    /*post message via ajax*/
    $("#frmPostMessage").submit(function() {
        var message = $.trim($("#message").val()),
            conversation_id = $.trim($("#conversation_id").val()),
            doc_id = $.trim($("#doc_id").val()),
            error = $("#error");

        if(message !== "" && conversation_id !== "" && doc_id != ""){
            $('#loading').show();
            var data = new FormData();
            data.append('conversation_id', $("#conversation_id").val());
            data.append('doc_id', $("#doc_id").val());
            data.append('message', $("#message").val());
            data.append('msgFile', $('input[name=msgFile]')[0].files[0]);
            $.ajax({
                url: "<?php echo AJAX_PATH;?>postPatientMessage.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                cache: false,
                success: function(data) {
                    $('#loading').hide();
                    $("#message").val("");
                    error.text("");
                }
            });
        }
        return false;
    });


    //get message
    c_id = $("#conversation_id").val();
    //get new message every 2 second
    setInterval(function(){
        $(".display-message").load("<?php echo AJAX_PATH;?>loadPateintMessages.php?c_id="+c_id);
    }, 2000);

    $(".display-message").scrollTop($(".display-message")[0].scrollHeight);
});
</script>
<?php include(LIB_HTML . 'footer.php');?>