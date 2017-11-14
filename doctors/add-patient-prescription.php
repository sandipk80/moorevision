<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/examinations/add-prescription-init.php');
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
                            
                        </div>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="" name="formAddPrescription" id="formAddPrescription" class="form-border">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="patient_name">Patient Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="patient_name" id="patient_name" value="<?php echo $patient_name;?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="age">Age <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="age" id="age" value="<?php echo $age;?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exam">Date <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="prescription_date" id="prescription_date" value="<?php echo $prescription_date;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="clear topmarg20"></div>

                            <div class="col-md-12">
                                <div class="form-group topmarg20">
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-3">
                                        <label class="control-label">SPHERE (SPH) </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="control-label">CYLINDER (CYL) </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">AXIS (0 - 180) </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group topmarg20">
                                    <div class="col-md-2">
                                        <label class="control_label">RIGHT EYE (OD) </label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="sphere_right" id="sphere_right">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=-20; $i<=20; $i++){
                                                echo '<option value="'.$i.'.00">'.$i.'.00</option>';
                                                echo '<option value="'.$i.'.25">'.$i.'.25</option>';
                                                echo '<option value="'.$i.'.50">'.$i.'.50</option>';
                                                echo '<option value="'.$i.'.75">'.$i.'.75</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="cylinder_right" id="cylinder_right">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=-1; $i<=10; $i++){
                                                if($i==-1){
                                                    echo '<option value="-0.25">-0.25</option>';
                                                    echo '<option value="-0.50">-0.50</option>';
                                                    echo '<option value="-0.75">-0.75</option>';
                                                }
                                                echo '<option value="'.$i.'.00">'.$i.'.00</option>';
                                                echo '<option value="'.$i.'.25">'.$i.'.25</option>';
                                                echo '<option value="'.$i.'.50">'.$i.'.50</option>';
                                                echo '<option value="'.$i.'.75">'.$i.'.75</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="axis_right" id="axis_right">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=1; $i<=180; $i++){
                                                if($i < 10){
                                                    echo '<option value="00'.$i.'">00'.$i.'&deg;</option>';
                                                }elseif($i < 100){
                                                    echo '<option value="0'.$i.'">0'.$i.'&deg;</option>';
                                                }else{
                                                    echo '<option value="'.$i.'">'.$i.'&deg;</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group topmarg20">
                                    <div class="col-md-2">
                                        <label class="control_label">LEFT EYE (OS) </label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="sphere_left" id="sphere_left">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=-20; $i<=20; $i++){
                                                echo '<option value="'.$i.'.00">'.$i.'.00</option>';
                                                echo '<option value="'.$i.'.25">'.$i.'.25</option>';
                                                echo '<option value="'.$i.'.50">'.$i.'.50</option>';
                                                echo '<option value="'.$i.'.75">'.$i.'.75</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="cylinder_left" id="cylinder_left">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=-1; $i<=10; $i++){
                                                if($i==-1){
                                                    echo '<option value="-0.25">-0.25</option>';
                                                    echo '<option value="-0.50">-0.50</option>';
                                                    echo '<option value="-0.75">-0.75</option>';
                                                }
                                                echo '<option value="'.$i.'.00">'.$i.'.00</option>';
                                                echo '<option value="'.$i.'.25">'.$i.'.25</option>';
                                                echo '<option value="'.$i.'.50">'.$i.'.50</option>';
                                                echo '<option value="'.$i.'.75">'.$i.'.75</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="axis_left" id="axis_left">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=1; $i<=180; $i++){
                                                if($i < 10){
                                                    echo '<option value="00'.$i.'">00'.$i.'&deg;</option>';
                                                }elseif($i < 100){
                                                    echo '<option value="0'.$i.'">0'.$i.'&deg;</option>';
                                                }else{
                                                    echo '<option value="'.$i.'">'.$i.'&deg;</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="clear form-row-brk">&nbsp;</div>

                            <div class="col-md-12">
                                <div class="form-group topmarg20">
                                    <div class="col-md-3">
                                        <label class="control-label">DO YOU HAVE A BI-FOCAL POWER?</label>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="checkbox-inline">
                                            <input type="radio" class="icheck" name="bifocal_power" id="bifocal_power1" value="1"> YES
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="radio" class="icheck" name="bifocal_power" id="bifocal_power0" value="0"> NO
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group topmarg20">
                                    <div class="col-md-2">&nbsp;</div>
                                    <div class="col-md-5">
                                        <label class="control-label">ADDITIONAL POWER </label>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="control-label">PUPILLARY DISTANCE </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group topmarg20">
                                    <div class="col-md-2">
                                        <label class="control_label">RIGHT EYE (OD) </label>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" name="additional_right_power" id="additional_right_power">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=-20; $i<=20; $i++){
                                                echo '<option value="'.$i.'.00">'.$i.'.00</option>';
                                                echo '<option value="'.$i.'.25">'.$i.'.25</option>';
                                                echo '<option value="'.$i.'.50">'.$i.'.50</option>';
                                                echo '<option value="'.$i.'.75">'.$i.'.75</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" name="right_puppilary_distance" id="right_puppilary_distance">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=-1; $i<=10; $i++){
                                                if($i==-1){
                                                    echo '<option value="-0.25">-0.25</option>';
                                                    echo '<option value="-0.50">-0.50</option>';
                                                    echo '<option value="-0.75">-0.75</option>';
                                                }
                                                echo '<option value="'.$i.'.00">'.$i.'.00</option>';
                                                echo '<option value="'.$i.'.25">'.$i.'.25</option>';
                                                echo '<option value="'.$i.'.50">'.$i.'.50</option>';
                                                echo '<option value="'.$i.'.75">'.$i.'.75</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group topmarg20">
                                    <div class="col-md-2">
                                        <label class="control_label">LEFT EYE (OS) </label>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" name="additional_left_power" id="additional_left_power">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=-20; $i<=20; $i++){
                                                echo '<option value="'.$i.'.00">'.$i.'.00</option>';
                                                echo '<option value="'.$i.'.25">'.$i.'.25</option>';
                                                echo '<option value="'.$i.'.50">'.$i.'.50</option>';
                                                echo '<option value="'.$i.'.75">'.$i.'.75</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" name="left_puppilary_distance" id="left_puppilary_distance">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            for($i=-1; $i<=10; $i++){
                                                if($i==-1){
                                                    echo '<option value="-0.25">-0.25</option>';
                                                    echo '<option value="-0.50">-0.50</option>';
                                                    echo '<option value="-0.75">-0.75</option>';
                                                }
                                                echo '<option value="'.$i.'.00">'.$i.'.00</option>';
                                                echo '<option value="'.$i.'.25">'.$i.'.25</option>';
                                                echo '<option value="'.$i.'.50">'.$i.'.50</option>';
                                                echo '<option value="'.$i.'.75">'.$i.'.75</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group topmarg20">
                                    <label for="notes">Notes </label>
                                    <textarea class="form-control" name="notes" id="notes" rows="5"><?php echo $notes;?></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group btn-row">
                                    <input type="hidden" name="exam_id" value="<?php echo $_GET['eid'];?>" />
                                    <input type="hidden" name="prescription_id" value="<?php echo $_GET['id'];?>" />
                                    <input type="hidden" name="add-prescription" value="submit" />
                                    <input type="submit" class="btn btn-success btn-square" value="Submit" />
                                    <input type="button" class="btn btn-default" value="Cancel" id="btnCancel" />
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<style>
.form-control{width:90% !important;}
select{padding: 7px 14px !important; height: 40px !important;}
.control-label{font-weight:normal !important;}
</style>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/icheck/css/all.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/icheck/js/icheck.min.js"></script>
<script type="text/javascript">
$(function() {
    $("#prescription_date").datetimepicker({
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

    $('input.icheck').iCheck({
        checkboxClass: 'icheckbox_flat-grey',
        radioClass: 'iradio_flat-grey'
    });


    // validate signup form on keyup and submit
    $("#formAddPrescription").validate({
        rules: {
            patient_name: {
                required: true,
                minlength:2
            },
            age: {
                required: true,
                number:true
            },
            prescription_date: {
                required: true
            }
        }
    });

    $("#sphere_right").val('<?php echo $sphere_right;?>');
    $("#sphere_left").val('<?php echo $sphere_left;?>');
    $("#cylinder_right").val('<?php echo $cylinder_right;?>');
    $("#cylinder_left").val('<?php echo $cylinder_left;?>');
    $("#axis_right").val('<?php echo $axis_right;?>');
    $("#axis_left").val('<?php echo $axis_left;?>');
    $("input[name=bifocal_power][value='<?php echo $sphere_right;?>']").prop("checked",true);
    $("#additional_right_power").val('<?php echo $additional_right_power;?>');
    $("#additional_left_power").val('<?php echo $additional_left_power;?>');
    $("#right_puppilary_distance").val('<?php echo $right_puppilary_distance;?>');
    $("#left_puppilary_distance").val('<?php echo $left_puppilary_distance;?>');

    $("#btnCancel").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL;?>patient-examinations.php";
    });

    
});
</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>