<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'doctors/patients/index-init.php');
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
                            <h3 class="panel-title"><?php echo $pageTitle;?></h3>
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
                                            <th>Email</th>
                                            <th>DOB</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(is_array($result) && count($result)>0){
                                            foreach($result as $row){
                                                $msgUrl=DOCTOR_SITE_URL."message.php?room=".$row['id'];
                                                $examUrl=DOCTOR_SITE_URL."examinations.php?pid=".$row['id'];
                                                $address = $row['address'].", ".$row['city'].", ".$row['state']." - ".$row['zipcode'];
                                        ?>
                                        <tr>
                                            <td align="center"><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $row['id'];?>" /></td>
                                            <td><?php echo ucwords($row['firstname'].' '.$row['lastname']);?></td>
                                            <td><?php echo $row['email'];?></td>
                                            <td><?php echo date("F d, Y", strtotime($row['date_of_birth']));?></td>
                                            <td><?php echo $address;?></td>
                                            <td><?php echo $row['phone'];?></td>
                                            <td align="center">
                                                <?php
                                                if ($row['status'] == "1") {
                                                    ?>
                                                    <a rel="0" class="updateStatus" title="Click to deactivate" data="<?php echo $row['id'];?>" href="javascript:void(0)"><img src="<?php print IMG_PATH;?>/activate.png" title="Click to deactivate" alt="Click to deactivate" border="0" /></a>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                    <a rel="1" class="updateStatus" title="Click to activate" data="<?php echo $row['id'];?>" href="javascript:void(0)"><img src="<?php print IMG_PATH;?>/deactivate.png" title="Click to activate" alt="Click to activate" border="0" /></a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo date("F d, Y", strtotime($row['created']));?></td>
                                            <td>
                                                <a class="btn btn-success" href="<?php echo DOCTOR_SITE_URL.'patient.php?id='.$row['id'];?>">View</a>
                                                <a class="btn btn-danger" href="<?php echo $msgUrl;?>">Messageaa</a>
                                                <a class="btn btn-default" href="<?php echo $examUrl;?>">Examinations</a>
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
        </section>
    </div>
</section>
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/dataTables/css/dataTables.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo ASSET_SITE_URL;?>plugins/dataTables/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#usersPage").addClass("active");
    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 7, "desc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,8 ] }
        ]
    });
});
$(document).on('click', '#btnAddPatient', function (e){
    window.location.href = "add-patient.php";
});

</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>script/functions.js"></script>
<?php include(LIB_HTML.'doctors/footer.php');?>