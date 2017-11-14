<?php
include('../cnf.php');
################# CHECK LOGGED IN USER ##############
validateDoctorLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH.'doctors/message/index-init.php');
include(LIB_HTML . 'doctors/header.php');
include(LIB_HTML . 'doctors/leftbar.php');
?>

<section class="main-content-wrapper">
    <div class="pageheader">
        <h1><?php echo $pageTitle;?> </h1>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li><a href="<?php echo OWNER_SITE_URL;?>dashboard.php">Dashboard</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
        <section id="main-content" class="animated fadeInUp">
            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        
                        <div class="panel-body">
                            <div class="col-md-4 bg-white ">
                                <div class="lt-member-header row border-bottom padding-sm text-center">
                                    Patients
                                </div>
                                <div class="border-bottom padding-sm text-center topmarg10">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="search_patient" id="txtSearchPatient" placeholder="Search Patient">
                                    </div>
                                </div>
                                <!-- =============================================================== -->
                                <!-- member list -->
                                <ul class="friend-list">
                                    <?php
                                    if(is_array($arrPatients) && count($arrPatients)>0){
                                        foreach($arrPatients as $pRow){
                                            $patientImg = IMG_PATH.'user.jpg';
                                            if(isset($userId) && $userId==$pRow['userId']){
                                                $actClass = "active";
                                            }else{
                                                $actClass = "";
                                            }
                                            if($pRow['msg_date'] !== ""){
                                                $postedTime = UtilityManager::get_time_difference($pRow['msg_date']);
                                            }else{
                                                $postedTime = "";
                                            }
                                    ?>
                                    <li class="<?php echo $actClass;?> bounceInDown">
                                        <a href="<?php echo DOCTOR_SITE_URL.'message.php?room='.$pRow['userId'];?>" class="clearfix">
                                            <img src="<?php echo $patientImg;?>" alt="" class="img-circle">
                                            <div class="friend-name">   
                                                <strong><?php echo $pRow['username'];?></strong>
                                            </div>
                                            <div class="last-message text-muted"><?php echo $pRow['last_msg'];?></div>
                                            <small class="time text-muted"><?php echo $postedTime;?></small>
                                            <?php echo $pRow['msg_count']>0 ? '<small class="chat-alert label label-danger">'.$pRow['msg_count'].'</small>' : '';?>
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
                                            <input type="hidden" id="user_id" value="<?php echo base64_encode($userId); ?>">
                                            <textarea id="message" class="form-control border no-shadow no-rounded" placeholder="Type your message here"></textarea>
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
                </div>
            </div>
        </section>
    </div>
</section>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#messagePage").addClass("active");

    //search patient
    $('#txtSearchPatient').keyup(function() {
        var pstr = $('#txtSearchPatient').val();
        $.ajax({
            url: "<?php echo AJAX_PATH;?>ajaxSearchPatient.php?p="+pstr+"&u=<?php echo $userId;?>",
            type: "GET",
            contentType: "html",
            processData: false,
            cache: false,
            success: function(data) {
                $('.friend-list').html(data);
            }
        });
    });

    /*post message via ajax*/
    $("#frmPostMessage").submit(function() {
        var message = $.trim($("#message").val()),
            conversation_id = $.trim($("#conversation_id").val()),
            user_id = $.trim($("#user_id").val()),
            error = $("#error");

        if(message !== "" && conversation_id !== "" && user_id != ""){
            $('#loading').show();
            var data = new FormData();
            data.append('conversation_id', $("#conversation_id").val());
            data.append('user_id', $("#user_id").val());
            data.append('message', $("#message").val());
            data.append('msgFile', $('input[name=msgFile]')[0].files[0]);
            $.ajax({
                url: "<?php echo AJAX_PATH;?>postDoctorMessage.php",
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

    /*post message via ajax
    $("#send-message").on("click", function(){
        var message = $.trim($("#message").val()),
            conversation_id = $.trim($("#conversation_id").val()),
            user_id = $.trim($("#user_id").val()),
            error = $("#error");

        if((message != "") && (conversation_id != "") && (user_id != "")){
            error.text("Sending...");
            $.post("<?php echo AJAX_PATH;?>postDoctorMessage.php",{message:message,conversation_id:conversation_id,user_id:user_id}, function(data){
                error.text(data);
                //clear the message box
                $("#message").val("");
            });
        }
    });*/


    //get message
    c_id = $("#conversation_id").val();
    //get new message every 2 second
    setInterval(function(){
        $(".display-message").load("<?php echo AJAX_PATH;?>loadDoctorMessages.php?c_id="+c_id);
    }, 2000);

    $(".display-message").scrollTop($(".display-message")[0].scrollHeight);
});
</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>