<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/tickets/add-init.php');
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
                            <h3 class="panel-title">Add Ticket</h3>
                            <div class="actions pull-right"></div>
                        </div>

                        <div class="panel-body">
                            <form method="post" action="" name="frmAddTicket" id="frmAddTicket" class="form-border" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="is_guest">Create Ticket as <span class="required">*</span></label>
                                    <select name="is_guest" id="is_guest" class="form-control">
                                        <option value="0">Guest User</option>
                                        <option value="1">Registered User</option>
                                    </select>
                                </div>
                                <div id="patientRow" style="display:none;">
                                    <div class="form-group">
                                        <label for="is_guest">Select Patient <span class="required">*</span></label>
                                        <select name="user_id" id="user_id" class="form-control">
                                            <option value="">-- Select Patient --</option>
                                            <?php
                                            if(is_array($arrPatients) && count($arrPatients)>0){
                                                foreach($arrPatients as $patient){
                                                    echo '<option value="'.$patient['id'].'">'.ucwords($patient['firstname'].' '.$patient['lastname']).' ('.$patient['email'].')</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="name">Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $name;?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $email;?>">
                                </div>
                                

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
                                    <label for="priority">Attachments </label>
                                    <input type="file" name="attachments[]" id="attachments" multiple="true">
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="is_public" id="is_public" value="1"> Make Ticket Public
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="notify_owner" id="notify_owner" value="1"> Don't Notify Owner
                                </div>
                                <div class="form-group btn-row">
                                    <input type="hidden" name="add-ticket" value="submit" />
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
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>fastselect/fastselect.min.css">
<script src="<?php echo SCRIPT_SITE_URL;?>fastselect/fastselect.standalone.js"></script>
<style type="text/css">
.fstElement{width: 100% !important; font-size: 14px !important;}
.fstMultipleMode { display: block; }
.fstMultipleMode .fstControls { width: 100%; }
.top_margin{margin-top: 15px;}
.fstResults{position: relative;}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $("#user_id").fastselect();
    // validate signup form on keyup and submit
    $("#frmAddTicket").validate({
        rules: {
            firstname: {
                required: true,
                minlength:2
            },
            lastname: {
                required: true,
                minlength:2
            },
            social_security_number: {
                required: true,
                minlength:9
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            },
            phone: {
                required: true
            },
            address: {
                required: true
            },
            state_id: {
                required: true
            },
            city_id: {
                required: true,
                digits: true
            },
            zipcode: {
                required: true
            },
            employer: {
                required: true
            },
            reason: {
                required: true
            }
        }
    });

    $("#btnCancel").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL;?>tickets.php";
    });

    $(document).on("change", "#is_guest", function (e) {
        var opt = $(this).val();
        if(opt == "1"){
            $("#patientRow").show();
        }else{
            $("#user_id").val('');
            $("#patientRow").hide();
        }
    });

    $(document).on("change", "#user_id", function (e) {
        var pid = $(this).val();
        if(pid=='' || pid==null) {
            $("#name").val('');
            $("#email").val('');
            return false;
        }
        $(this).after('<img class="loading" src="<?php echo IMG_PATH;?>loading.gif" />');
        $.ajax({
            url:'<?php echo AJAX_PATH;?>getUserDetails.php?pid='+pid,
            cache: false,
            contentType: "application/json; charset=utf-8",
            dataType:"json",
            success:function(data){
                /*var obj = $.parseJSON(data);
                $("#name").val(obj[0].name);
                $("#email").val(obj[1].email);*/
                $.each(data, function(index, element) {
                    if(index == "name")
                        $("#name").val(element);
                    if(index == "email")
                        $("#email").val(element);
                });
                $(".loading").remove();
            }
        });

    });

});
</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>