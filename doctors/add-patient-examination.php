<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/examinations/add-init.php');
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
                        <form method="post" action="" name="formAddExam" id="formAddExam" class="form-border" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" name="exam_date" id="exam_date" value="<?php echo $exam_date;?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chief_complaint">Chief Complaint <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="chief_complaint" id="chief_complaint" value="<?php echo $chief_complaint;?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="allergies">Allergies </label>
                                    <input type="text" class="form-control" name="allergies" id="allergies" value="<?php echo $allergies;?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="symptoms">Symptoms </label>
                                    <input type="text" class="form-control" name="symptoms" id="symptoms" value="<?php echo $symptoms;?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="medications">Medications </label>
                                    <input type="text" class="form-control" name="medications" id="medications" value="<?php echo $medications;?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="location">Location </label>
                                    <input type="text" class="form-control" name="location" id="location" value="<?php echo $location;?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="onset">Onset <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="onset" id="onset" value="<?php echo $onset;?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ocular_ros">Ocular ROS <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="ocular_ros" id="ocular_ros" value="<?php echo $ocular_ros;?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="frequency">Frequency </label>
                                    <input type="text" class="form-control" name="frequency" id="frequency" value="<?php echo $frequency;?>">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="severity">Severity </label>
                                    <input type="text" class="form-control" name="severity" id="severity" value="<?php echo $severity;?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hx_fhx">Hx/FHx <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="hx_fhx" id="hx_fhx" value="<?php echo $hx_fhx;?>">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="context">context </label>
                                    <input type="text" class="form-control" name="context" id="context" value="<?php echo $context;?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modifiers">Modifiers </label>
                                    <input type="text" class="form-control" name="modifiers" id="modifiers" value="<?php echo $modifiers;?>" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hx_ros_from">Medical Hx and ROS from </label>
                                    <input type="text" class="form-control" name="hx_ros_from" id="hx_ros_from" value="<?php echo $hx_ros_from;?>" >
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="rowHeader"><strong>Doctor Initials</strong></div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="clear btborder"></div>
                                <div class="col-md-4">
                                    <div class="border height200">
                                        <div class="form-group">
                                            <label for="head_face" class="control-label col-sm-8">Head Face: </label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="head_face" id="head_face" value="1" <?php echo $head_face=="1" ? "checked" : "";?>> nl
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="mood_affect" class="control-label col-sm-8">Mood/Affect (anxiety/depression): </label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="mood_affect" id="mood_affect" value="1" <?php echo $mood_affect=="1" ? "checked" : "";?>> nl
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="is_oriented" class="control-label col-sm-7">Oriented (person/time/place): </label>
                                            <div class="col-sm-5">
                                                <label class="checkbox-inline">
                                                    <input type="radio" class="icheck" name="is_oriented" id="is_oriented" value="1" <?php echo $is_oriented=="1" ? "checked" : "";?>> Y
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="radio" class="icheck" name="is_oriented" id="is_oriented" value="0" <?php echo $is_oriented=="0" ? "checked" : "";?>> N
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="eom_full_smooth" class="control-label col-sm-6">E.O.M.: </label>
                                            <div class="col-sm-6">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="eom_full_smooth" id="eom_full_smooth" value="1" <?php echo $eom_full_smooth=="1" ? "checked" : "";?>> Full &amp; Smooth
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="cover_test" class="control-label col-sm-12">Cover Test: SC/CC</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="cover_test" id="cover_test" value="<?php echo $cover_test;?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="npc_text" class="control-label col-sm-3">NPC: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="npc_text" id="npc_text" value="<?php echo $npc_text;?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200" style="border-right:0;">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="confrontations" class="control-label col-sm-12">Confrontations: </label>
                                            <div class="col-sm-12">
                                                <div class="radio">
                                                    <input class="icheck" type="checkbox" name="confrontations[]" id="confrontationsFTFC" value="FTFC" <?php echo ($confrontations=='BOTH' || $confrontations=='FTFC' ? 'checked' : '');?>>
                                                    <label>FTFC OD/OS</label>
                                                </div>
                                                <div class="radio">
                                                    <input class="icheck" type="checkbox"  name="confrontations[]" id="confrontationsDEFECT" value="DEFECT" <?php echo ($confrontations=='BOTH' || $confrontations=='DEFECT' ? 'checked' : '');?>>
                                                    <label>DEFECT OD/OS</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear btborder"></div>

                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-6">DVAsc: </label>
                                            <div class="col-sm-6">PH</div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="dvasc_od" class="control-label col-sm-4">OD </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="dvasc_od" id="dvasc_od" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="dvasc_od" class="control-label col-sm-4">OS </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="dvasc_os" id="dvasc_os" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-6">TONOMETRY: </label>
                                            <div class="col-sm-6">NCT / GAT</div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="tonometry_time" class="control-label col-sm-1">@ </label>
                                            <div class="col-sm-11">
                                                <input type="text" class="form-control" name="tonometry_time" id="tonometry_time" value="<?php echo $tonometry_time;?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" style="overflow:hidden;">
                                                <label for="tonometry_od" class="control-label col-sm-3">OD</label>
                                                <select name="tonometry_od" id="tonometry_od" class="form-control">
                                                    <?php
                                                    for($i=8; $i<46; $i++){
                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" style="overflow:hidden;">
                                                <label for="tonometry_os" class="control-label col-sm-3">OS</label>
                                                <select name="tonometry_os" id="tonometry_os" class="form-control">
                                                    <?php
                                                    for($i=8; $i<46; $i++){
                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-6">Current Rx: </label>
                                            <div class="col-sm-6">SV BF PAL RDG</div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="current_rx_od" class="control-label col-sm-4">OD </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="current_rx_od" id="current_rx_od" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="current_rx_os" class="control-label col-sm-4">OS </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="current_rx_os" id="current_rx_os" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border height200" style="border-right:0;">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-12">KERATOMETRY / RETINOSCOPY: </label>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="current_rx_od" class="control-label col-sm-4">OD </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="keratometry_od" id="keratometry_od" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="current_rx_os" class="control-label col-sm-4">OS </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="keratometry_os" id="keratometry_os" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="clear btborder"></div>

                            <div class="col-md-12">

                                <div class="col-md-2">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-6">NVA: </label>
                                            <div class="col-sm-6">sc / cc</div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="nva_od" class="control-label col-sm-4">OD </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="nva_od" id="nva_od" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="nva_os" class="control-label col-sm-4">OS </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="nva_os" id="nva_os" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-12">PUPILS: </label>
                                            <div class="col-sm-12">
                                                <div class="radio">
                                                    <input class="icheck" type="radio" name="pupils" id="pupils-PERRL-APD" value="PERRL-APD" <?php echo $pupils=="PERRL-APD" ? "checked" : "";?>>
                                                    <label for="pupils-PERRL-APD">PERRL-APD</label>
                                                </div>
                                                <div class="radio">
                                                    <input class="icheck" type="radio" name="pupils" id="pupils-OTHER" value="OTHER" <?php echo $pupils=="OTHER" ? "checked" : "";?>>
                                                    <label for="pupils-OTHER">OTHER</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-12">SUBJECTIVE: </label>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="subjective_od" class="control-label col-sm-4">OD </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="subjective_od" id="subjective_od" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="subjective_os" class="control-label col-sm-4">OS </label>
                                            <div class="col-sm-2">20/</div>
                                            <div class="col-sm-6">
                                                <select name="subjective_os" id="subjective_os" class="form-control">
                                                    <option value=""></option>
                                                    <option value="FC">FC</option>
                                                    <option value="400">400</option>
                                                    <option value="200">200</option>
                                                    <option value="100">100</option>
                                                    <option value="80">80</option>
                                                    <option value="70">70</option>
                                                    <option value="60">60</option>
                                                    <option value="50">50</option>
                                                    <option value="40">40</option>
                                                    <option value="30">30</option>
                                                    <option value="25">25</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200" style="border-right:0;">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-12">TRIAL FRAME: </label>
                                            <div class="col-sm-12">
                                                <input type="text" name="trial_frame" id="trial_frame" class="form-control" value="<?php echo $trial_frame;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clear btborder"></div>

                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-12">SLIT LAMP EVALUATION: </label>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">&nbsp;</label>
                                            <label class="control-label col-sm-4">OD</label>
                                            <label class="control-label col-sm-4">OS</label>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">TEAR</label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_tear_od" id="slit_lamp_tear_od" value="1" <?php echo $slit_lamp_tear_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_tear_os" id="slit_lamp_tear_os" value="1" <?php echo $slit_lamp_tear_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">LL</label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_ll_od" id="slit_lamp_ll_od" value="1" <?php echo $slit_lamp_ll_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_ll_os" id="slit_lamp_ll_os" value="1" <?php echo $slit_lamp_ll_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">CONJ</label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_conj_od" id="slit_lamp_conj_od" value="1" <?php echo $slit_lamp_conj_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_conj_os" id="slit_lamp_conj_os" value="1" <?php echo $slit_lamp_conj_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">CORNEA</label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_cornea_od" id="slit_lamp_conj_od" value="1" <?php echo $slit_lamp_cornea_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_cornea_os" id="slit_lamp_conj_os" value="1" <?php echo $slit_lamp_cornea_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">ANGLES</label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_angles_od" id="slit_lamp_conj_od" value="1" <?php echo $slit_lamp_angles_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_angles_os" id="slit_lamp_conj_os" value="1" <?php echo $slit_lamp_angles_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">A/C</label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_ac_od" id="slit_lamp_ac_od" value="1" <?php echo $slit_lamp_ac_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_ac_os" id="slit_lamp_ac_os" value="1" <?php echo $slit_lamp_ac_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">IRIS</label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_iris_od" id="slit_lamp_iris_od" value="1" <?php echo $slit_lamp_iris_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_iris_os" id="slit_lamp_iris_os" value="1" <?php echo $slit_lamp_iris_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">LENS</label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_lens_od" id="slit_lamp_lens_od" value="1" <?php echo $slit_lamp_lens_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_lens_os" id="slit_lamp_lens_os" value="1" <?php echo $slit_lamp_lens_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">VIT</label>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_vit_od" id="slit_lamp_vit_od" value="1" <?php echo $slit_lamp_vit_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="slit_lamp_vit_os" id="slit_lamp_vit_os" value="1" <?php echo $slit_lamp_vit_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-12">Comment:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="slit_lamp_comment" id="slit_lamp_comment" value="<?php echo $slit_lamp_comment;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="border" style="border-right:0;">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-2">FUNDUS: </label>
                                            <div class="col-sm-10">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus[]" value="90D"> 90D
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus[]" value="BIO/20D"> BIO/20D
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus[]" value="Direct OD/OS"> Direct 
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus[]" value="1%T"> 1%T
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus[]" value="2.5%Phenyl"> 2.5%Phenyl
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">&nbsp;</label>
                                            <label class="control-label col-sm-2">OD</label>
                                            <label class="control-label col-sm-2">OS</label>
                                            <label class="control-label col-sm-4">&nbsp;</label>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">C/D</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="fundus_cd_od" id="fundus_cd_od" value="<?php echo $fundus_cd_od;?>">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="fundus_cd_os" id="fundus_cd_os" value="<?php echo $fundus_cd_os;?>">
                                            </div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">DISC</label>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_disc_od" id="fundus_disc_od" value="1" <?php echo $fundus_disc_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_disc_os" id="fundus_disc_os" value="1" <?php echo $fundus_disc_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">BV's(A/V)</label>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_bv_od" id="fundus_bv_od" value="1" <?php echo $fundus_bv_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_bv_os" id="fundus_bv_os" value="1" <?php echo $fundus_bv_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">MACULA</label>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_macuala_od" id="fundus_macuala_od" value="1" <?php echo $fundus_macuala_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_macuala_os" id="fundus_macuala_os" value="1" <?php echo $fundus_macuala_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">FUNDUS</label>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_fundus_od" id="fundus_fundus_od" value="1" <?php echo $fundus_fundus_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_fundus_os" id="fundus_fundus_os" value="1" <?php echo $fundus_fundus_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">PERIPH</label>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_periph_od" id="fundus_periph_od" value="1" <?php echo $fundus_periph_od=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" class="icheck" name="fundus_periph_os" id="fundus_periph_os" value="1" <?php echo $fundus_periph_os=="1" ? "checked" : "";?>>
                                                </label>
                                            </div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-3">Comment</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="fundus_comment" id="fundus_comment" value="<?php echo $fundus_comment;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clear btborder"></div>

                            <div class="col-md-12">
                                <div class="border" style="border-right:0;">
                                <div class="col-sm-6">
                                    <div class="form-group" style="overflow:hidden;">
                                        <div id="wPaintLeft" style="position:relative; width:500px; height:200px; margin:70px auto 20px auto;"><img src="<?php echo IMG_PATH;?>left-eye.png" /></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group" style="overflow:hidden;">
                                        <div id="wPaintRight" style="position:relative; width:500px; height:200px; margin:70px auto 20px auto;"><img src="<?php echo IMG_PATH;?>right-eye.png" /></div>
                                    </div>
                                </div>
                            </div>

                            <div class="clear btborder"></div>

                            <div class="col-md-12">
                                <div class="border" style="border-right:0;">
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="icheck" name="extent_seen_ou" id="extent_seen_ou" value="1" <?php echo $fundus_periph_os=="1" ? "checked" : "";?>> Hole / tear / RD to extent seen (OU)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="icheck" name="ed_adaption" id="ed_adaption" value="1" <?php echo $fundus_periph_os=="1" ? "checked" : "";?>> Ed adaptation to Rx changes
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="icheck" name="ed_uv_protection" id="ed_uv_protection" value="1" <?php echo $ed_uv_protection=="1" ? "checked" : "";?>> Ed UV-protection
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="icheck" name="ed_bs_bp_control" id="ed_bs_bp_control" value="1" <?php echo $ed_bs_bp_control=="1" ? "checked" : "";?>> Ed importance of BS/BP control
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="icheck" name="ed_sg_sx_rd" id="ed_sg_sx_rd" value="1" <?php echo $ed_sg_sx_rd=="1" ? "checked" : "";?>> Ed sg's & sx's of RD
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="icheck" name="ed_cl_wear" id="ed_cl_wear" value="1" <?php echo $ed_cl_wear=="1" ? "checked" : "";?>> Ed impt of d/c-ing of cl wear
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="icheck" name="ed_compliance_med" id="ed_compliance_med" value="1" <?php echo $ed_compliance_med=="1" ? "checked" : "";?>> Ed impt of compliance w/ meds
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clear btborder"></div>

                            <div class="col-md-12 topmarg20">
                                <div class="form-group" style="overflow:hidden;">
                                    <label class="control-label col-sm-1">RTC:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="rtc_text" id="rtc_text" value="<?php echo $rtc_text;?>">
                                    </div>

                                    <label class="control-label col-sm-1">Examining Doctor:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="examining_doctor" id="examining_doctor" value="<?php echo $examining_doctor;?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group btn-row">
                                    <input type="hidden" name="patient_id" value="<?php echo $_GET['pid'];?>" />
                                    <input type="hidden" name="exam_id" value="<?php echo $_GET['eid'];?>" />
                                    <input type="hidden" name="add-examination" value="submit" />
                                    <input type="hidden" name="left_eye_image" id="left_eye_image" value="" />
                                    <input type="hidden" name="right_eye_image" id="right_eye_image" value="" />
                                    <button type="submit" class="btn btn-success btn-square" id="btnSubmit" name="submit">Submit</button>
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

<style>
.form-control{width:90% !important;}
select{padding: 7px 14px !important; height: 40px !important;}
.control-label{font-weight:normal !important;}
</style>
<script type="text/javascript">
var SITE_URL = '<?php echo SITE_URL;?>';
</script>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/icheck/css/all.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/icheck/js/icheck.min.js"></script>

<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/jquery.ui.core.1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/jquery.ui.widget.1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/jquery.ui.mouse.1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/jquery.ui.draggable.1.10.3.min.js"></script>

<!-- wColorPicker -->
<link rel="Stylesheet" type="text/css" href="<?php echo CSS_SITE_URL;?>wColorPicker.min.css" />
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/wColorPicker.min.js"></script>

<!-- wPaint -->
<link rel="Stylesheet" type="text/css" href="<?php echo CSS_SITE_URL;?>wPaint.min.css" />
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/wPaint.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/plugins/main/wPaint.menu.main.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/plugins/text/wPaint.menu.text.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/plugins/shapes/wPaint.menu.main.shapes.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/plugins/file/wPaint.menu.main.file.min.js"></script>

<script type="text/javascript">
var images = [
  '<?php echo IMG_PATH;?>left-eye.png',
];
var rtimage = [
  '<?php echo IMG_PATH;?>right-eye.png',
];

function saveLeftImg(image) {
    var _this = this;
    alert("Left eye image saved");
    $.ajax({
        type: 'POST',
        url: '../ajax/upload-examination-image.php',
        data: {image: image},
        success: function (resp) {
            // internal function for displaying status messages in the canvas
            _this._displayStatus('Image saved successfully');
            resp = $.parseJSON(resp);
            images.push(resp.img);
            $('#left_eye_image').val(resp.img);
        }
    });
    return true;
}

function loadLeftImgBg () {
    // internal function for displaying background images modal
    // where images is an array of images (base64 or url path)
    // NOTE: that if you can't see the bg image changing it's probably
    // becasue the foregroud image is not transparent.
    this._showFileModal('bg', images);
}

function loadLeftImgFg () {
    // internal function for displaying foreground images modal
    // where images is an array of images (base64 or url path)
    this._showFileModal('fg', images);
}

// init wPaint
$('#wPaintLeft').wPaint({
    path: '',
    theme: 'standard classic',
    menuOffsetLeft: -35,
    menuOffsetTop: -50,
    saveImg: saveLeftImg,
    loadImgBg: loadLeftImgBg,
    loadImgFg: loadLeftImgFg,
    bg: '<?php echo IMG_PATH;?>left-eye.png',
    image: '<?php echo IMG_PATH;?>left-eye.png',
    fillStyle: '#000000',
    strokeStyle: '#000000',
    strokeColor: '#FFFF00',
    menuTitles: {
        'fillColor': '#000000'
    }
});

function saveRightImg(image) {
    var _this = this;
    alert("Right eye image saved");
    $.ajax({
        type: 'POST',
        url: '../ajax/upload-examination-image.php',
        data: {image: image},
        success: function (resp) {
            // internal function for displaying status messages in the canvas
            _this._displayStatus('Image saved successfully');
            resp = $.parseJSON(resp);
            rtimage.push(resp.img);
            $('#right_eye_image').val(resp.img);
            return true;
        }
    });
    return true;
}

function loadRightImgBg () {
    // internal function for displaying background images modal
    // where images is an array of images (base64 or url path)
    // NOTE: that if you can't see the bg image changing it's probably
    // becasue the foregroud image is not transparent.
    this._showFileModal('bg', rtimage);
}

function loadRightImgFg () {
    // internal function for displaying foreground images modal
    // where images is an array of images (base64 or url path)
    this._showFileModal('fg', rtimage);
}

// init wPaint
$('#wPaintRight').wPaint({
    path: '',
    theme: 'standard classic',
    menuOffsetLeft: -35,
    menuOffsetTop: -50,
    saveImg: saveRightImg,
    loadImgBg: loadRightImgBg,
    loadImgFg: loadRightImgFg,
    bg: '<?php echo IMG_PATH;?>right-eye.png',
    image: '<?php echo IMG_PATH;?>right-eye.png',
    fillStyle: '#000000',
    strokeStyle: '#000000',
    strokeColor: '#FFFF00',
    menuTitles: {
        'fillColor': '#000000'
    }
});

$(function() {
    $("#exam_date,#hx_ros_from").datetimepicker({
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
    $("#tonometry_date").datetimepicker({
        datepicker: false,
        format:'g:i A',
        formatTime: 'g:i A',
        mask:'29:59 99',
        scrollInput: false,
        step: 30,
        ampm: true,
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
    $("#formAddExam").validate({
        rules: {
            patient_name: {
                required: true,
                minlength:2
            },
            age: {
                required: true,
                number:true
            },
            exam_date: {
                required: true
            },
            chief_complaint: {
                required: true,
                minlength:2
            }
        }/*,
        submitHandler: function() {
            $(".wPaintLeft>.wPaint-menu-icon-name-save").click();
            $(".wPaintRight>.wPaint-menu-icon-name-save").click();
            $( "#formAddExam" ).submit();
            //return true;
        }*/

    });

    $("#btnSubmit").click(function (){alert("ddd");
        $(".wPaint-menu-icon-name-save").click();
        $(".wPaint-menu-icon-name-save").click();
        //$( "#formAddExam" ).submit();
        return true;
    });

    $("#btnCancel").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL;?>patient-examinations.php";
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

    $("#dvasc_od").val('<?php echo $dvasc_od;?>');
    $("#dvasc_os").val('<?php echo $dvasc_os;?>');
    $("#tonometry_od").val('<?php echo $tonometry_od;?>');
    $("#tonometry_os").val('<?php echo $tonometry_os;?>');
    $("#current_rx_od").val('<?php echo $current_rx_od;?>');
    $("#current_rx_os").val('<?php echo $current_rx_os;?>');
    $("#keratometry_od").val('<?php echo $keratometry_od;?>');
    $("#keratometry_os").val('<?php echo $keratometry_os;?>');
    $("#nva_od").val('<?php echo $nva_od;?>');
    $("#nva_os").val('<?php echo $nva_os;?>');
    $('input[name="pupils"][value="<?php echo $pupils;?>"]').attr('checked', true);
    $("#subjective_od").val('<?php echo $subjective_od;?>');
    $("#subjective_os").val('<?php echo $subjective_os;?>');

});
</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>