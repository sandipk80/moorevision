<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/examinations/view-init.php');
include(LIB_HTML . 'doctors/header.php');
include(LIB_HTML . 'doctors/leftbar.php');
$imgArray = array(
    '0' => 'cross.png',
    '1' => 'checked.png'
);
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Patient Name: </label>
                                    <div class="col-sm-8"><?php echo $patient_name;?></div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-md-2">Age: </label>
                                    <div class="col-sm-10"><?php echo $age;?> Years</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3">Date: </label>
                                    <div class="col-sm-9"><?php echo $exam_date;?></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Chief Complaint</label>
                                    <div class="col-sm-8"><?php echo $chief_complaint;?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Allergies </label>
                                    <div class="col-sm-8"><?php echo $allergies;?></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Symptoms </label>
                                    <div class="col-sm-8"><?php echo $symptoms;?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Medications </label>
                                    <div class="col-sm-8"><?php echo $medications;?></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2">Location </label>
                                    <div class="col-sm-10"><?php echo $location;?></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Onset</label>
                                    <div class="col-sm-8"><?php echo $onset;?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Ocular ROS</label>
                                    <div class="col-sm-8"><?php echo $ocular_ros;?></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2">Frequency </label>
                                    <div class="col-sm-10"><?php echo $frequency;?></div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Severity </label>
                                    <div class="col-sm-8"><?php echo $severity;?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Hx/FHx</label>
                                    <div class="col-sm-8"><?php echo $hx_fhx;?></div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2">context </label>
                                    <div class="col-sm-10"><?php echo $context;?></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Modifiers </label>
                                    <div class="col-sm-8"><?php echo $modifiers;?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4">Medical Hx and ROS from </label>
                                    <div class="col-sm-8"><?php echo $hx_ros_from;?></div>
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
                                            <label class="control-label col-sm-8">Head Face: </label>
                                            <div class="col-sm-4">
                                                <img src="<?php echo IMG_PATH.$imgArray[$head_face];?>" alt="1" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-8">Mood/Affect (anxiety/depression): </label>
                                            <div class="col-sm-4">
                                                <img src="<?php echo IMG_PATH.$imgArray[$mood_affect];?>" alt="1" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-7">Oriented (person/time/place): </label>
                                            <div class="col-sm-5">
                                                <?php echo $is_oriented=="1" ? "Yes" : "No";?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-6">E.O.M.: </label>
                                            <div class="col-sm-6">
                                                <img src="<?php echo IMG_PATH.$imgArray[$eom_full_smooth];?>" alt="1" />
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-3">Cover Test: SC/CC</label>
                                            <div class="col-sm-9"><?php echo $cover_test;?></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="npc_text" class="control-label col-sm-3">NPC: </label>
                                            <div class="col-sm-9"><?php echo $npc_text;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200" style="border-right:0;">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="confrontations" class="control-label col-sm-12">Confrontations: </label>
                                            <div class="col-sm-12">
                                                <div class="radio">
                                                    <?php
                                                    if($confrontations=='BOTH' || $confrontations=='FTFC'){
                                                        echo '<img src="'.IMG_PATH.'checked.png" alt="" />';
                                                    }else{
                                                        echo '<img src="'.IMG_PATH.'cross.png" alt="" />';
                                                    }
                                                    ?>
                                                    <label>FTFC OD/OS</label>
                                                </div>
                                                <div class="radio">
                                                    <?php
                                                    if($confrontations=='BOTH' || $confrontations=='DEFECT'){
                                                        echo '<img src="'.IMG_PATH.'checked.png" alt="" />';
                                                    }else{
                                                        echo '<img src="'.IMG_PATH.'cross.png" alt="" />';
                                                    }
                                                    ?>
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
                                            <label class="control-label col-sm-6">OD </label>
                                            <div class="col-sm-6">20/<?php echo $dvasc_od;?></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-6">OS </label>
                                            <div class="col-sm-6">20/<?php echo $dvasc_os?></div>
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
                                            <div class="col-sm-11"><?php echo $tonometry_time;?></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" style="overflow:hidden;">
                                                <label class="control-label col-sm-5">OD</label>
                                                <?php echo $tonometry_od;?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" style="overflow:hidden;">
                                                <label class="control-label col-sm-5">OS</label>
                                                <?php echo $tonometry_os;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-3">Current Rx: </label>
                                            <div class="col-sm-9">SV BF PAL RDG</div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">OD </label>
                                            <div class="col-sm-8">20/<?php echo $current_rx_od;?></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">OS </label>
                                            <div class="col-sm-8">20/<?php echo $current_rx_os;?></div>
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
                                            <div class="col-sm-8">20/<?php echo $keratometry_od;?></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="current_rx_os" class="control-label col-sm-4">OS </label>
                                            <div class="col-sm-6">20/<?php echo $keratometry_os;?></div>
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
                                            <div class="col-sm-8">20/<?php echo $nav_od;?></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="nva_os" class="control-label col-sm-4">OS </label>
                                            <div class="col-sm-2">20/<?php echo $keratometry_os;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border height200">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-12">PUPILS: </label>
                                            <div class="col-sm-12">
                                                <div class="radio">
                                                    <?php
                                                    if($pupils=="PERRL-APD"){
                                                        echo '<img src="'.IMG_PATH.'checked.png" alt="">';
                                                    }else{
                                                        echo '<img src="'.IMG_PATH.'cross.png" alt="">';
                                                    }
                                                    ?>
                                                    <label for="pupils-PERRL-APD">PERRL-APD</label>
                                                </div>
                                                <div class="radio">
                                                    <?php
                                                    if($pupils=="OTHER"){
                                                        echo '<img src="'.IMG_PATH.'checked.png" alt="">';
                                                    }else{
                                                        echo '<img src="'.IMG_PATH.'cross.png" alt="">';
                                                    }
                                                    ?>
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
                                            <div class="col-sm-8">20/<?php echo $subjective_od;?></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label for="subjective_os" class="control-label col-sm-4">OS </label>
                                            <div class="col-sm-8">20/<?php echo $subjective_os;?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200" style="border-right:0;">
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-12">TRIAL FRAME: </label>
                                            <div class="col-sm-12"><?php echo $trial_frame;?></div>
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
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_tear_od];?>" alt="1" /></div>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_tear_os];?>" alt="1" /></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">LL</label>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_ll_od];?>" alt="1" /></div>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_ll_os];?>" alt="1" /></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">CONJ</label>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_conj_od];?>" alt="1" /></div>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_conj_os];?>" alt="1" /></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">CORNEA</label>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_cornea_od];?>" alt="1" /></div>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_cornea_os];?>" alt="1" /></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">ANGLES</label>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_angles_od];?>" alt="1" /></div>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_angles_os];?>" alt="1" /></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">A/C</label>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_ac_od];?>" alt="1" /></div>
                                            <div class="col-sm-4">
                                                <img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_ac_os];?>" alt="1" />
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">IRIS</label>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_iris_od];?>" alt="1" /></div>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_iris_os];?>" alt="1" /></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">LENS</label>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_lens_od];?>" alt="1" /></div>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_lens_os];?>" alt="1" /></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">VIT</label>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_vit_od];?>" alt="1" /></div>
                                            <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_vit_os];?>" alt="1" /></div>
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
                                            <div class="col-sm-10"><?php echo $fundus;?></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">&nbsp;</label>
                                            <label class="control-label col-sm-2">OD</label>
                                            <label class="control-label col-sm-2">OS</label>
                                            <label class="control-label col-sm-4">&nbsp;</label>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">C/D</label>
                                            <div class="col-sm-2"><?php echo $fundus_cd_od;?></div>
                                            <div class="col-sm-2"><?php echo $fundus_cd_os;?></div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">DISC</label>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_disc_od];?>" alt="1" /></div>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_disc_os];?>" alt="1" /></div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">BV's(A/V)</label>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_bv_od];?>" alt="1" /></div>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_bv_os];?>" alt="1" /></div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">MACULA</label>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_macuala_od];?>" alt="1" /></div>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_macuala_os];?>" alt="1" /></div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">FUNDUS</label>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_fundus_od];?>" alt="1" /></div>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_fundus_os];?>" alt="1" /></div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-4">PERIPH</label>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_periph_od];?>" alt="1" /></div>
                                            <div class="col-sm-2"><img src="<?php echo IMG_PATH.$imgArray[$fundus_periph_os];?>" alt="1" /></div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                        <div class="form-group" style="overflow:hidden;">
                                            <label class="control-label col-sm-3">Comment</label>
                                            <div class="col-sm-9"><?php echo $fundus_comment;?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clear btborder"></div>

                            <div class="col-md-12">
                                <div class="border" style="border-right:0;">
                                <div class="col-sm-6">
                                    <div class="form-group" style="overflow:hidden;">
                                        <img src="<?php echo $exam_left_image;?>" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" style="overflow:hidden;">
                                        <img src="<?php echo $exam_right_image;?>" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="clear btborder"></div>

                            <div class="col-md-12">
                                <div class="border" style="border-right:0;">
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$extent_seen_ou];?>" alt="1" /> Hole / tear / RD to extent seen (OU)</div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$ed_adaption];?>" alt="1" /> Ed adaptation to Rx changes</div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$ed_uv_protection];?>" alt="1" /> Ed UV-protection</div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$ed_bs_bp_control];?>" alt="1" /> Ed importance of BS/BP control</div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$ed_sg_sx_rd];?>" alt="1" /> Ed sg's & sx's of RD</div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$ed_cl_wear];?>" alt="1" /> Ed impt of d/c-ing of cl wear</div>
                                    </div>
                                    <div class="form-group" style="overflow:hidden;">
                                        <label class="control-label col-sm-8">&nbsp;</label>
                                        <div class="col-sm-4"><img src="<?php echo IMG_PATH.$imgArray[$ed_compliance_med];?>" alt="1" /> Ed impt of compliance w/ meds</div>
                                    </div>
                                </div>
                            </div>

                            <div class="clear btborder"></div>

                            <div class="col-md-12 topmarg20">
                                <div class="form-group" style="overflow:hidden;">
                                    <label class="control-label col-sm-1">RTC:</label>
                                    <div class="col-sm-5"><?php echo $rtc_text;?></div>

                                    <label class="control-label col-sm-2">Examining Doctor:</label>
                                    <div class="col-sm-4"><?php echo $examining_doctor;?></div>
                                </div>
                            </div>
                        </div>
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

<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/icheck/css/all.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/icheck/js/icheck.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#usersPage").addClass("active");
    //$("#social_security_number").mask("999-99-9999");

    $('input.icheck').iCheck({
        checkboxClass: 'icheckbox_flat-grey',
        radioClass: 'iradio_flat-grey'
    });

    $("#btnCancel").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL;?>patient-examinations.php";
    });

});
</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>