<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/tickets/edit-init.php');
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
                            <h3 class="panel-title">Edit Ticket</h3>
                            <div class="actions pull-right"></div>
                        </div>

                        <div class="panel-body">
                            <form method="post" action="" name="frmAddTicket" id="frmAddTicket" class="form-border" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label for="subject">Subject <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="subject" id="subject" value="<?php echo $subject;?>">
                                </div>
                                <div class="form-group">
                                    <label for="subject">Description </label>
                                    <textarea name="description" id="description" class="form-control" rows="5"><?php echo $description;?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="ticket_category_id">Category </label>
                                    <select name="ticket_category_id" id="ticket_category_id" class="form-control">
                                    <?php
                                    if(is_array($tCategories) && count($tCategories)>0){
                                        foreach($tCategories as $tRow){
                                            echo '<option value="'.$tRow['id'].'">'.$tRow['name'].'</option>';
                                        }
                                    }
                                    ?>
                                    </select>
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
                                <div class="form-group">
                                    <input type="checkbox" name="is_public" id="is_public" value="1" <?php echo $is_public=="1" ? "checked" : "";?>> Make Ticket Public
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="notify_owner" id="notify_owner" value="1" <?php echo $notify_owner=="1" ? "checked" : "";?>> Don't Notify Owner
                                </div>
                                <div class="form-group btn-row">
                                    <input type="hidden" name="tktId" value="<?php echo $_GET['id'];?>" />
                                    <input type="hidden" name="edit-ticket" value="submit" />
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
            subject: {
                required: true,
                minlength:2
            },
            description: {
                required: true,
                minlength:10
            },
            status: {
                required: true
            },
            priority: {
                required: true
            },
            ticket_category_id: {
                required: true
            }
        }
    });

    $("#ticket_category_id").val("<?php echo $ticketCategoryId;?>");
    $("#status").val("<?php echo $status;?>");
    $("#priority").val("<?php echo $priority;?>");
    $("#btnCancel").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL;?>tickets.php";
    });


});
</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>