<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/patients/add-init.php');
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
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
    </div>
    <section id="main-content" class="animated fadeInUp">
        <div class="row">
            <?php include(LIB_HTML . 'message.php');?>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $pageTitle;?></h3>
                        <div class="actions pull-right">
                            <i class="fa fa-expand"></i>
                            <i class="fa fa-chevron-down"></i>
                            <i class="fa fa-times"></i>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="" name="frmAddPatient" id="frmAddPatient" class="form-border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname">First Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $firstname;?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname">Last Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $lastname;?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="social_security_number">Social Security Number <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="social_security_number" id="social_security_number" value="<?php echo $social_security_number;?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $email;?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Primary Phone <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone;?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of Birth <span class="required">*</span></label>
                                    <div id="date_of_birth" class="d_o_b"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo $address;?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state_id">State <span class="required">*</span></label>
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value="">-- Select State --</option>
                                        <?php
                                        if(is_array($arrStates) && count($arrStates)>0){
                                            foreach($arrStates as $state){
                                                echo '<option value="'.$state['id'].'">'.$state['name'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city_id">City <span class="required">*</span></label>
                                    <select class="form-control" name="city_id" id="city_id">
                                        <option value="">-- Select City --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zipcode">Zipcode <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo $zipcode;?>">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="vision_insurance">Vision Insurance </label>
                                    <input type="text" class="form-control" name="vision_insurance" id="vision_insurance" value="<?php echo $vision_insurance;?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="medical_insurance">Medical Insurance </label>
                                    <input type="text" class="form-control" name="medical_insurance" id="medical_insurance" value="<?php echo $medical_insurance;?>" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_examination_date">Last eye examination? </label>
                                    <input type="text" class="form-control" name="last_examination_date" id="last_examination_date" value="<?php echo $last_examination_date;?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_examination_place">Last eye examination place? </label>
                                    <input type="text" class="form-control" name="last_examination_place" id="last_examination_place" value="<?php echo $last_examination_place;?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="last_examination_recommend">Last eye doctor recommend?</label>
                                    <input type="text" class="form-control" name="last_examination_recommend" id="last_examination_recommend" value="<?php echo $last_examination_recommend;?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile_number">Mobile Number </label>
                                    <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="<?php echo $mobile_number;?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_examination_place">Mobile Carrier </label>
                                    <select class="form-control" name="mobile_carrier" id="mobile_carrier">
                                        <option value="">-- Select Mobile Carrier --</option>
                                        <?php
                                        if(is_array($arrMobCarrier) && count($arrMobCarrier)>0){
                                            foreach($arrMobCarrier as $key=>$value){
                                                echo '<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group btn-row">
                                    <input type="hidden" name="add-patient" value="submit" />
                                    <input type="submit" class="btn btn-success btn-square" value="Submit" />
                                    <input type="button" class="btn btn-default" value="Cancel" id="btnCancel" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery-birthday-picker.min.js"></script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<style>
.form-control{width:90% !important;}
.birthMonth,.birthDate,.birthYear{background:#FFF; width:25%; color:#000; margin-right:10px; border:1px solid #d4d6d7; height: 40px; line-height: normal; padding: 7px 14px;}
select{padding: 7px 14px !important; height: 40px !important;}
</style>
<script type="text/javascript">
$(function() {
    $("#last_examination_date").datetimepicker({
        defaultDate: "+1d",
        changeMonth: true,
        numberOfMonths: 1,
        format: "m/d/Y",
        timepicker:false,
        scrollInput: false,
        onClose: function() {
            this.focus();this.blur();
        }
    });


});
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#usersPage").addClass("active");
    //$("#social_security_number").mask("999-99-9999");
    $("#date_of_birth").birthdayPicker({
        "defaultDate": "<?php echo $date_of_birth!=='0000-00-00' ? date('Y-m-d', strtotime($date_of_birth)) : '';?>",
        "maxYear": "<?php echo date('Y');?>",
        "maxAge": 100,
        "minAge": 1,
        "placeholder": true,
        //"defaultDate": true,
        "sizeClass": "span2"
    });

    $("#state_id").val("<?php echo $state_id; ?>").trigger('change');
    setTimeout(function() {
        $("#city_id").val("<?php echo $city_id; ?>");
    }, 1500);

    // validate signup form on keyup and submit
    $("#frmAddPatient").validate({
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
        window.location.href = "<?php echo DOCTOR_SITE_URL;?>dashboard.php";
    });

    $(document).on("change", "#state_id", function (e) {
        var state_id = $(this).val();
        if(state_id=='' || state_id==null) {
            $("#city_id option").remove();
            return false;
        }
        $(this).after('<img class="loading" src="<?php echo IMG_PATH;?>loading.gif" />');
        $.ajax({
            url:'<?php echo AJAX_PATH;?>listCityByState.php?state_id='+state_id,
            cache: false,
            dataType:"html",
            success:function(data){
                $("#city_id option").remove();
                $("#city_id").append(data);
                $(".loading").remove();
            }
        });

    });

});
</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>