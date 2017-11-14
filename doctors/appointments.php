<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'doctors/appointments/index-init.php');
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
        <section id="main-content" class="animated fadeInUp">
            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3><?php echo $pageTitle;?></h3>
                            <div class="actions pull-right">
                                <button class="btn btn-default" id="btnAddPatient">Add Patient</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form method="post" name="frmListing" id="frmListing" action="">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th><input name="chkRecordId" value="0" onclick="checkAll(this.form)" type='checkbox' class="checkbox" /></th>
                                            <th>Name</th>
                                            <th>Doctor</th>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th>Patients</th>
                                            <th>Payment Type</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(is_array($result) && count($result)>0){
                                            foreach($result as $row){
                                                $deleteItem=DOCTOR_SITE_URL."appointments.php?act=delete&id=".$row['id'];
                                                $msgURL=DOCTOR_SITE_URL."message.php?room=".$row['user_id'];
                                        ?>
                                        <tr>
                                            <td align="center"><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $row['id'];?>" /></td>
                                            <td><?php echo ucwords($row['name']);?></td>
                                            <td><?php echo $row['docname'];?></td>
                                            <td><?php echo $row['catname'].', '.$row['service'];?></td>
                                            <td><?php echo date("F d, Y H:i A", strtotime($row['appointment_date']));?></td>
                                            <td><?php echo $row['patient_count'];?></td>
                                            <td><?php echo $row['payment_type'];?></td>
                                            <td><?php echo date("F d, Y", strtotime($row['created']));?></td>
                                            <td>
                                                <a class="btn btn-danger" href="<?php echo $deleteItem;?>" onclick="javascript: return confirmDelete();">Delete</a>
                                                <?php
                                                if($row['user_id'] > 0){
                                                ?>
                                                <a class="btn btn-default" href="<?php echo $msgURL;?>">Send Message</a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                if(is_array($result) && count($result)>0) {
                                ?>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="left" width="12%" height="28px">
                                            <span><input name="Delete" type="submit" class="btn btn-danger" value="Delete"  onclick="setStatus('Delete','delete', document.frmListing);"/></span>
                                            <input type='hidden' name="hidAct" value="" />
                                            <input type='hidden' name="hidAllId" value="" />
                                        </td>
                                    </tr>
                                </table>
                                <?php
                                }
                                ?>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#bookingsPage").addClass("active");
    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 4, "desc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,8 ] }
        ]
    });

    $(document).on('click', '#btnAddPatient', function (e){
        window.location.href = "add-patient.php";
    });
});

function confirmDelete() {
    if(!confirm("Are you sure you want to delete this appointment?")) {
        return false;
    }
    else {
        return true;
    }
}

</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>script/functions.js"></script>
<?php include(LIB_HTML.'doctors/footer.php');?>