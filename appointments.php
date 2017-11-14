<?php
include('cnf.php');
################# CHECK LOGGED IN USER ##############
validateUserLogin();
################# END OF LOGGED IN CHECK ############
require_once(LIB_PATH.'users/appointments/index-init.php');
include(LIB_HTML . 'header.php');
?>
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<div class="main-banner five">
    <div class="container">
        <h2><span>Appointments</span></h2>
    </div>
</div>
<!-- Breadcrumb Starts -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled list-inline">
            <li><a href="index.html">Home</a></li>
            <li class="active">Appointments</li>
        </ul>
    </div>
</div>
<div class="container main-container">
    <!-- Doctor Profile Starts -->
    <div class="row">

        <div class="panel-body">
            <form method="post" name="frmListing" id="frmListing" action="">
                <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Patients</th>
                            <th>Note</th>
                            <th>Payment Type</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(is_array($result) && count($result)>0){
                            foreach($result as $row){
                                $msgURL = USER_SITE_URL."message.php?room=".$row['doctor_id'];
                        ?>
                        <tr>
                            <td><?php echo $row['docname'];?></td>
                            <td><?php echo $row['catname'].', '.$row['service'];?></td>
                            <td><?php echo date("F d, Y H:i A", strtotime($row['appointment_date']));?></td>
                            <td><?php echo $row['patient_count'];?></td>
                            <td><?php echo $row['note'];?></td>
                            <td><?php echo $row['payment_type'];?></td>
                            <td><?php echo date("F d, Y", strtotime($row['created']));?></td>
                            <td>
                                <a class="btn btn-default" href="<?php echo $msgURL;?>">Send Message</a>
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>

        </div>
    </div>



    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("#myAppointments").addClass("active");

    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 2, "desc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 7 ] }
        ]
    });
});
</script>
<?php include(LIB_HTML . 'footer.php');?>