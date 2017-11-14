<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/tickets/view-init.php');
include(LIB_HTML . 'doctors/header.php');
include(LIB_HTML . 'doctors/leftbar.php');
?>
<section class="main-content-wrapper">
    <div class="pageheader">
        <h1><?php echo $pageTitle;?> </h1>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li><a href="<?php echo DOCTOR_SITE_URL;?>dashboard.php">Dashboard</a></li>
                <li><a href="<?php echo DOCTOR_SITE_URL;?>tickets.php">Tickets</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
        <section id="main-content" class="animated fadeInUp">
            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <?php
                if(is_array($error) && count($error)>0) {
                ?>
                <!-- our error container -->
                <div class="error-container" style="display:block;">
                    <ol>
                        <?php
                        foreach($error as $key=>$val) {
                        ?>
                            <li>
                                <label class="error" for="<?php echo $key;?>"><?php echo $val;?></label>
                            </li>
                        <?php
                        }
                        ?>
                    </ol>
                </div>
                <?php
                }
                ?>
                <div class="col-md-12 topmarg20">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ticket: <?php echo $subject;?></h3>
                            <div class="actions pull-right"></div>
                        </div>

                        <div class="panel-body">
                            <?php
                            if(is_array($arrReplies) && count($arrReplies)>0){
                                foreach($arrReplies as $reply){
                                    if($reply['reply_from'] == "P"){
                                        $replyFrom = $name;
                                        $fromEmail = $email;
                                    }else{
                                        $replyFrom = $doctorName;
                                        $fromEmail = $doctorEmail;
                                    }
                            ?>
                            <div class="panel panel-solid-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $replyFrom;?></h3>
                                    <div class="actions pull-right">
                                        <?php echo UtilityManager::get_time_difference($reply['created']);?>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $reply['message'];?>
                                </div>
                                <div class="panel-footer">
                                    Attachments
                                    <?php
                                    if(is_array($reply['attachments']) && count($reply['attachments'])>0){
                                        foreach($reply['attachments'] as $file){
                                            echo '<p style="text-align:left;"><a href="'.STORAGE_HTTP_PATH.'tickets/'.$file['filename'].'" download="'.$file['filename'].'">'.$file['filename'].'</a></p>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                            
                            <form method="post" action="" name="frmPostReply" id="frmPostReply" class="form-border" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label for="message">Message </label>
                                    <textarea name="message" id="message" class="form-control" rows="5"><?php echo $message;?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="priority">Priority </label>
                                    <select name="priority" id="priority" class="form-control">
                                        <option value="normal">Normal</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="priority">Status </label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="open">Open</option>
                                        <option value="pending">Order in Progress</option>
                                        <option value="closed">Order Completed</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="priority">Attachments </label>
                                    <input type="file" name="attachments[]" id="attachments" multiple="true">
                                </div>
                                
                                <div class="form-group btn-row">
                                    <input type="hidden" name="tktId" value="<?php echo $_GET['id'];?>" />
                                    <input type="hidden" name="add-reply" value="submit" />
                                    <input type="submit" class="btn btn-success btn-square" value="Submit" />
                                    <input type="button" class="btn btn-default" value="Cancel" id="btnCancel" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function() {
    // validate signup form on keyup and submit
    $("#frmAddTicket").validate({
        rules: {
            message: {
                required: true,
                minlength:5
            },
            status: {
                required: true
            },
            priority: {
                required: true
            }
        }
    });

    $("#status").val("<?php echo $status;?>");
    $("#priority").val("<?php echo $priority;?>");
    $("#btnCancel").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL;?>tickets.php";
    });


});
</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>