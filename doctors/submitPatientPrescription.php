<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/examinations/view-prescription-init.php');
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
                        <form name="frmContinue" id="frmContinue" action="" method="post">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h2 class="text-center">Prescription has been saved.</h2>
                                    <h2 class="text-center">How would you like to proceed?</h2>
                                </div>
                            </div>
                            <div class="clear btborder"></div>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="border height200 text-center topmarg20">
                                        <div class="form-group">
                                            <button type="button" id="btnPrint"><img src="<?php echo IMG_PATH;?>print-icon.png" alt="Print" /></button>
                                            <h3>Print</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200 text-center topmarg20">
                                        <div class="form-group">
                                            <button type="button" id="btnEmail"><img src="<?php echo IMG_PATH;?>email-icon.png" alt="Email" /></button>
                                            <h3>Email</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border height200 text-center topmarg20">
                                        <div class="form-group">
                                            <button type="button" id="btnEmailPrint"><img src="<?php echo IMG_PATH;?>email-print-icon.png" alt="Both" /></button>
                                            <h3>Both</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<script type="text/javascript">
$(document).ready(function() {
    $("#btnCancel").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL.'examinations.php?pid='.$arrExamination['user_id'];?>";
    });
    $("#btnPrint").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL.'submitPatientPrescription.php?act=print&eid='.$arrExamination['id'];?>";
    });
    $("#btnEmail").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL.'submitPatientPrescription.php?act=email&eid='.$arrExamination['id'];?>";
    });
    $("#btnEmailPrint").click(function () {
        window.location.href = "<?php echo DOCTOR_SITE_URL.'submitPatientPrescription.php?act=email&opt=both&eid='.$arrExamination['id'];?>";
    });
});
</script>