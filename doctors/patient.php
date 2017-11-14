<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'doctors/patients/view-init.php');
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
                <li><a href="<?php echo DOCTOR_SITE_URL;?>users.php">Patients</a></li>
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
                        <div class="col-sm-5 col-xs-12">
                            <div class="profile-block">
                                <div class="panel panel-profile">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php echo ucwords($patient['firstname'].' '.$patient['lastname']);?></h3>
                                        <p class="caption"><?php echo $patient['email'];?></p>
                                        <p class="caption"><label>SSN: </label><?php echo $patient['social_security_number'];?></p>
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-unstyled">
                                            <li class="row">
                                                <span class="col-sm-4 col-xs-12"><strong>Date of Birth</strong></span>
                                                <span class="col-sm-8 col-xs-12"><?php echo date("F d, Y", strtotime($patient['date_of_birth']));?></span>
                                            </li>
                                            <li class="row">
                                                <span class="col-sm-4 col-xs-12"><strong>Address</strong></span>
                                                <span class="col-sm-8 col-xs-12">
                                                    <?php
                                                    $address = "";
                                                    $address .= $patient['address'] ? $patient['address'] : "";
                                                    $address .= $patient['state'] ? ", ".$patient['state'] : "";
                                                    $address .= $patient['city'] ? ", ".$patient['city'] : "";
                                                    $address .= $patient['zipcode'] ? " - ".$patient['zipcode'] : "";
                                                    echo trim($address, ", ");
                                                    ?>
                                                </span>
                                            </li>
                                            <li class="row">
                                                <span class="col-sm-4 col-xs-12"><strong>Phone</strong></span>
                                                <span class="col-sm-8 col-xs-12"><?php echo $patient['phone'];?></span>
                                            </li>
                                            <li class="row">
                                                <span class="col-sm-4 col-xs-12"><strong>Employer</strong></span>
                                                <span class="col-sm-8 col-xs-12"><?php echo $patient['employer'] ? $patient['employer'] : "Not Mentioned";?></span>
                                            </li>
                                            <li class="row">
                                                <span class="col-sm-4 col-xs-12"><strong>Vision Insurance</strong></span>
                                                <span class="col-sm-8 col-xs-12"><?php echo $patient['vision_insurance'] ? $patient['vision_insurance'] : "Not Mentioned";?></span>
                                            </li>
                                            <li class="row">
                                                <span class="col-sm-4 col-xs-12"><strong>Medical Insurance</strong></span>
                                                <span class="col-sm-8 col-xs-12"><?php echo $patient['medical_insurance'] ? $patient['medical_insurance'] : "Not Mentioned";?></span>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7 col-xs-12">
                            <div class="profile-details">
                                <h3 class="main-heading2"><?php echo ucwords($patient['firstname'].' '.$patient['lastname']);?></h3>
                                <h4><?php echo trim($address, ", ");?></h4>

                                <div class="row">
                                <?php
                                if(!empty($patient['history'])) {
                                    $hstRow = $patient['history'];
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Have your eyes ever been dilated</label>
                                            <?php echo $hstRow['is_dilated']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">When were your eyes dilated?</label>
                                            <?php echo $hstRow['dilated_date'] !== "0000-00-00" ? date("F d, Y", strtotime($hstRow['dilated_date'])) : "Not Mentioned"; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Are you allergic to any medication?</label>
                                            <?php echo $hstRow['is_medication_allergy']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">List allergies</label>
                                            <?php echo $hstRow['medication_allergies']!=="" ? $hstRow['medication_allergies'] : "Not Mentioned";?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Are you taking any medication?</label>
                                            <?php echo $hstRow['taking_medication']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Medication list </label>
                                            <?php echo $hstRow['medication_list'] ? $hstRow['medication_list'] : "Not Mentioned";?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Are you pregnant and/or nursing?</label>
                                            <?php echo $hstRow['is_pregnant_nursing']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">How long pregnant or nursing </label>
                                            <?php echo $hstRow['pregnant_nursing_time'] ? $hstRow['pregnant_nursing_time']." month" : "Not Mentioned";?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Any eye injury or surgery</label>
                                            <?php echo $hstRow['have_eye_injury_surgery']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Wear glasses?</label>
                                            <?php echo $hstRow['wear_glass']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Days per week you wear glasses </label>
                                            <?php echo $hstRow['wear_glass_per_week'] ? $hstRow['wear_glass_per_week']." days" : "Not Mentioned";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Start wearing glasses/contact lenses </label>
                                            <?php echo $hstRow['wear_glass_start_date']!=="0000-00-00" ? date("m/d/Y", strtotime($hstRow['wear_glass_start_date'])) : "Not Mentioned";?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Do you now wear contact lenses?</label>
                                            <?php echo $hstRow['wear_lense']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Days per week do you wear contact lenses?</label>
                                            <?php echo $hstRow['wear_lense_per_week'] ? $hstRow['wear_lense_per_week']." days" : "Not Mentioned";?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Complication with current contact lens?</label>
                                            <?php echo $hstRow['lense_complication']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Sleep with your contact lenses?</label>
                                            <?php echo $hstRow['sleep_with_lense']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Days do you continually wear contact lenses? </label>
                                            <?php echo $hstRow['continue_wear_lense_days'] ? $hstRow['continue_wear_lense_days']." days" : "Not Mentioned";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Your work type </label>
                                            <?php echo $hstRow['work_type'] ? $hstRow['work_type'] : "Not Mentioned";?>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Reaction to eye drops or lens solution?</label>
                                            <?php echo $hstRow['is_drop_lense_reaction']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Have any reaction to eye drops or lens solution? </label>
                                            <?php echo $hstRow['drop_lense_reaction'] ? $hstRow['drop_lense_reaction'] : "Not Mentioned";?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">Use computer?</label>
                                            <?php echo $hstRow['use_computer']=="1" ? "Yes" : "No";?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="fullW">How many hours/day do you use a computer?</label>
                                            <?php echo $hstRow['computer_hours_per_day'] ? $hstRow['computer_hours_per_day']." hours" : "Not Mentioned";?>
                                        </div>
                                    </div>
                                
                                <?php }?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#usersPage").addClass("active");
});
</script>
<?php include(LIB_HTML.'doctors/footer.php');?>