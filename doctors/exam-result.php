<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
//validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/examinations/view-init.php');
$imgArray = array(
    '0' => 'cross.png',
    '1' => 'checked.png'
);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo (isset($pageTitle) ? $pageTitle.' | ' : '');?> <?php echo SITE_NAME;?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>

<body>
<table cellpadding="10" cellspacing="0" border="1" width="100%" align="center">
<tbody>
    <tr>
        <td><h1><?php echo $pageTitle;?></h1></td>
        <td><strong>Date:</strong> <?php echo $exam_date;?></td>
    </tr>
    <tr>
        <td><strong>Patient Name:</strong> <?php echo $patient_name;?></td>
        <td><strong>Age:</strong> <?php echo $age;?> Years</td>
        
    </tr>
    <tr>
        <td><strong>Chief Complaint:</strong> <?php echo $chief_complaint;?></td>
        <td><strong>Chief Complaint:</strong><?php echo $allergies;?></td>
    </tr>
    <tr>
        <td><strong>Symptoms:</strong> <?php echo $symptoms;?></td>
        <td><strong>Medications:</strong> <?php echo $medications;?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Location:</strong> <?php echo $location;?></td>
    </tr>
    <tr>
        <td><strong>Onset:</strong> <?php echo $onset;?></td>
        <td><strong>Ocular ROS:</strong> <?php echo $ocular_ros;?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Frequency:</strong> <?php echo $frequency;?></td>
    </tr>
    <tr>
        <td><strong>Severity:</strong> <?php echo $severity;?></td>
        <td><strong>Hx/FHx:</strong> <?php echo $hx_fhx;?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Context:</strong> <?php echo $context;?></td>
    </tr>
    <tr>
        <td><strong>Modifiers:</strong> <?php echo $modifiers;?></td>
        <td><strong>Medical Hx and ROS from:</strong> <?php echo $hx_ros_from;?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Doctor Initials</strong></td>
    </tr>
    <tr>
        <td colspan="2">
            <table cellspacing="0" cellpadding="10" width="100%" border="1">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>Head Face</strong></td>
                            <td><img src="<?php echo IMG_PATH.$imgArray[$head_face];?>" alt="1" /></td>
                        </tr>
                        <tr>
                            <td><strong>Mood/Affect (anxiety/depression)</strong></td>
                            <td><img src="<?php echo IMG_PATH.$imgArray[$mood_affect];?>" alt="1" /></td>
                        </tr>
                        <tr>
                            <td><strong>Oriented (person/time/place)</strong></td>
                            <td><img src="<?php echo IMG_PATH.$imgArray[$is_oriented];?>" alt="1" /></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>E.O.M.: </strong></td>
                            <td><img src="<?php echo IMG_PATH.$imgArray[$eom_full_smooth];?>" alt="1" /></td>
                        </tr>
                        <tr>
                            <td><strong>Cover Test: </strong></td>
                            <td><?php echo $cover_test;?></td>
                        </tr>
                        <tr>
                            <td><strong>NPC: </strong></td>
                            <td><?php echo $npc_text;?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr><td colspan="2">Confrontations: </td></tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if($confrontations=='BOTH' || $confrontations=='FTFC'){
                                    echo '<img src="'.IMG_PATH.'checked.png" alt="" />';
                                }else{
                                    echo '<img src="'.IMG_PATH.'cross.png" alt="" />';
                                }
                                ?>
                                <label>FTFC OD/OS</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if($confrontations=='BOTH' || $confrontations=='DEFECT'){
                                    echo '<img src="'.IMG_PATH.'checked.png" alt="" />';
                                }else{
                                    echo '<img src="'.IMG_PATH.'cross.png" alt="" />';
                                }
                                ?>
                                <label>DEFECT OD/OS</label>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table cellspacing="0" cellpadding="10" width="100%" border="1">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>DVAsc: </strong>PH</td>
                        </tr>
                        <tr>
                            <td><strong>OD </strong> 20/<?php echo $dvasc_od;?></td>
                        </tr>
                        <tr>
                            <td><strong>OS </strong> 20/<?php echo $dvasc_os;?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>TONOMETRY: </strong>NCT / GAT</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>@ </strong><?php echo $tonometry_time;?></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $tonometry_od.' / '.$tonometry_os;?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>Current Rx: </strong>SV BF PAL RDG</td>
                        </tr>
                        <tr>
                            <td><strong>OD </strong> 20/<?php echo $current_rx_od;?></td>
                        </tr>
                        <tr>
                            <td><strong>OS </strong> 20/<?php echo $current_rx_os;?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>KERATOMETRY / RETINOSCOPY: </strong></td>
                        </tr>
                        <tr>
                            <td><strong>OD </strong> 20/<?php echo $keratometry_od;?></td>
                        </tr>
                        <tr>
                            <td><strong>OS </strong> 20/<?php echo $keratometry_os;?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table cellspacing="0" cellpadding="10" width="100%" border="1">
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>NVA: </strong></td>
                            <td>SC / CC</td>
                        </tr>
                        <tr>
                            <td><strong>OD </strong></td>
                            <td>20/<?php echo $nav_od;?></td>
                        </tr>
                        <tr>
                            <td><strong>OS </strong></td>
                            <td>20/<?php echo $nav_os;?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>PUPILS: </strong></td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if($pupils=="PERRL-APD"){
                                    echo '<img src="'.IMG_PATH.'checked.png" alt="">';
                                }else{
                                    echo '<img src="'.IMG_PATH.'cross.png" alt="">';
                                }
                                ?>
                                <label for="pupils-PERRL-APD">PERRL-APD</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if($pupils=="OTHER"){
                                    echo '<img src="'.IMG_PATH.'checked.png" alt="">';
                                }else{
                                    echo '<img src="'.IMG_PATH.'cross.png" alt="">';
                                }
                                ?>
                                <label for="pupils-OTHER">OTHER</label>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>SUBJECTIVE: </strong></td>
                        </tr>
                        <tr>
                            <td><strong>OD </strong></td>
                            <td>20/<?php echo $subjective_od;?></td>
                        </tr>
                        <tr>
                            <td><strong>OS </strong></td>
                            <td>20/<?php echo $subjective_os;?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td><strong>Trial Frame: </strong></td>
                        </tr>
                        <tr>
                            <td><?php echo $trial_frame;?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table cellspacing="0" cellpadding="10" width="100%" border="1">
            <tr>
                <td>
                    <table width="100%">
                    <tr>
                        <td colspan="4"><strong>SLIT LAMP EVALUATION: </strong></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>OD</td>
                        <td>OS</td>
                        <td>Comment</td>
                    </tr>
                    <tr>
                        <td>TEAR</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_tear_od];?>" alt="1" /></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_tear_os];?>" alt="1" /></td>
                        <td><?php echo $slit_lamp_comment;?></td>
                    </tr>
                    <tr>
                        <td>L/L</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_ll_od];?>" alt="1" /></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_ll_os];?>" alt="1" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>CONJ</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_conj_od];?>" alt="1" /></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_conj_os];?>" alt="1" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>CORNEA</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_cornea_od];?>" alt="1" /></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_cornea_os];?>" alt="1" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>ANGLES</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_angles_od];?>" alt="1" /></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_angles_os];?>" alt="1" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>A/C</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_ac_od];?>" alt="1" /></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_ac_os];?>" alt="1" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>IRIS</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_iris_od];?>" alt="1" /></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_iris_os];?>" alt="1" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>LENS</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_lens_od];?>" alt="1" /></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_lens_os];?>" alt="1" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>VIT</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_vit_od];?>" alt="1" /></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$slit_lamp_vit_os];?>" alt="1" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                    <tr>
                        <td colspan="3"><strong>FUNDUS: </strong><?php echo $fundus;?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>OD</td>
                        <td>OS</td>
                    </tr>
                    <tr>
                        <td>C/D</td>
                        <td><?php echo $fundus_cd_od;?></td>
                        <td><?php echo $fundus_cd_os;?></td>
                    </tr>
                    <tr>
                        <td>DISC</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_disc_od];?>" alt=""></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_disc_os];?>" alt=""></td>
                    </tr>
                    <tr>
                        <td>BV's(A/V)</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_bv_od];?>" alt=""></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_bv_os];?>" alt=""></td>
                    </tr>
                    <tr>
                        <td>MACULA</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_macuala_od];?>" alt=""></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_macuala_os];?>" alt=""></td>
                    </tr>
                    <tr>
                        <td>FUNDUS</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_fundus_od];?>" alt=""></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_fundus_os];?>" alt=""></td>
                    </tr>
                    <tr>
                        <td>PERIPH</td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_periph_od];?>" alt=""></td>
                        <td><img src="<?php echo IMG_PATH.$imgArray[$fundus_periph_od];?>" alt=""></td>
                    </tr>
                    <tr>
                        <td><strong>Comment: </strong></td>
                        <td colspan="2"><?php echo $fundus_comment;?></td>
                    </tr>
                    </table>
                </td>
            </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="right"><img src="<?php echo IMG_PATH.$imgArray[$extent_seen_ou];?>" alt="1" /> Hole / tear / RD to extent seen (OU)</td>
    </tr>
    <tr>
        <td colspan="2" align="right"><img src="<?php echo IMG_PATH.$imgArray[$ed_adaption];?>" alt="1" /> Ed adaptation to Rx changes</td>
    </tr>
    <tr>
        <td colspan="2" align="right"><img src="<?php echo IMG_PATH.$imgArray[$ed_uv_protection];?>" alt="1" /> Ed UV-protection</td>
    </tr>
    <tr>
        <td colspan="2" align="right"><img src="<?php echo IMG_PATH.$imgArray[$ed_bs_bp_control];?>" alt="1" /> Ed importance of BS/BP control</td>
    </tr>
    <tr>
        <td colspan="2" align="right"><img src="<?php echo IMG_PATH.$imgArray[$ed_sg_sx_rd];?>" alt="1" /> Ed sg's & sx's of RD</td>
    </tr>
    <tr>
        <td colspan="2" align="right"><img src="<?php echo IMG_PATH.$imgArray[$ed_cl_wear];?>" alt="1" /> Ed impt of d/c-ing of cl wear</td>
    </tr>
    <tr>
        <td colspan="2" align="right"><img src="<?php echo IMG_PATH.$imgArray[$ed_compliance_med];?>" alt="1" /> Ed impt of compliance w/ meds</td>
    </tr>
    <tr>
        <td><strong>RTC: </strong><?php echo $rtc_text;?></td>
        <td><strong>Examining Doctor: </strong><?php echo $examining_doctor;?></td>
    </tr>
</tbody>
</table>
</body>