<?php
include('../cnf.php');
##-----------CHECK DOCTOR LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK DOCTOR LOGIN END---------------##
include(LIB_PATH . 'doctors/examinations/view-init.php');
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
                                    <h2 class="text-center">Examination has been saved.</h2>
                                    <h2 class="text-center">Would you like to create a prescription</h2>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group text-center topmarg20">
                                    <input type="hidden" name="exam_id" value="<?php echo $_GET['eid'];?>" />
                                    <input type="hidden" name="next-step" value="Submit">
                                    <input type="submit" name="submit" class="btn btn-success btn-square" value="Yes" />
                                    <input type="button" class="btn btn-default" value="No" id="btnCancel" />
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
});
</script>