<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'admin/doctors/index-init.php');
include(LIB_HTML . 'admin/header.php');
include(LIB_HTML . 'admin/leftbar.php');
?>
<section class="main-content-wrapper">
    <div class="pageheader">
        <h1><?php echo $pageTitle;?> </h1>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li><a href="<?php echo OWNER_SITE_URL;?>dashboard.php">Dashboard</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
        <section id="main-content" class="animated fadeInUp">
            <div class="row">
                <?php include(LIB_HTML . 'message.php');?>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><a href="<?php echo ADMIN_SITE_URL;?>add-doctor.php">Add Doctor</a></h3>
                            <div class="actions pull-right">
                                <i class="fa fa-expand"></i>
                                <i class="fa fa-chevron-down"></i>
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="30">#</th>
                                            <th><a href="<?php echo $nameUrl; ?>" class="homeLink">Name</a><?php  displaySortArrow('first_name',$strSortBy,$strSortByOrder);?></th>
                                            <th><a href="<?php echo $emailUrl;?>" class="homeLink">Email</a><?php  displaySortArrow('email',$strSortBy,$strSortByOrder);?></th>
                                            <th><a href="<?php echo $catUrl;?>" class="homeLink">Category</a><?php  displaySortArrow('catname',$strSortBy,$strSortByOrder);?></th>
                                            <th><a href="<?php echo $serviceUrl;?>" class="homeLink">Service</a><?php  displaySortArrow('service',$strSortBy,$strSortByOrder);?></th>
                                            <th><a href="<?php echo $feeUrl;?>" class="homeLink">Fee</a><?php  displaySortArrow('fee',$strSortBy,$strSortByOrder);?></th>
                                            <th>Phone</th>
                                            <th><a href="<?php echo $dateUrl;?>" class="homeLink">Created</a><?php  displaySortArrow('created',$strSortBy,$strSortByOrder);?></th>
                                            <th width="100">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(is_array($result) && count($result)>0){
                                            $n = 1;
                                            foreach($result as $row){
                                                $deleteItem=ADMIN_SITE_URL."doctors.php?act=delete&id=".$row['id'];
                                        ?>
                                        <tr>
                                            <td><?php echo $n;?></td>
                                            <td><?php echo ucwords($row['first_name'].' '.$row['last_name']);?></td>
                                            <td><?php echo $row['email'];?></td>
                                            <td><?php echo $row['catname'];?></td>
                                            <td><?php echo $row['service'];?></td>
                                            <td><?php echo $row['fee'];?></td>
                                            <td><?php echo $row['phone'];?></td>
                                            <td><?php echo date("F d, Y", strtotime($row['created']));?></td>
                                            <td>
                                                <a class="btn btn-default" href="<?php echo ADMIN_SITE_URL.'add-doctor.php?id='.$row['id'];?>">Edit</a>
                                                <a class="btn btn-danger" href="<?php echo $deleteItem;?>" onclick="javascript: return confirmDelete();">Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                            $n++;
                                            }
                                        }else{
                                        ?>
                                        <tr>
                                            <td colspan="9">No doctors available</td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                if(is_array($result) && count($result)>0) {
                                ?>
                                <div id="example_paginate" class="dataTables_paginate paging_simple_numbers">
                                    <?php echo $paging->show(); ?>
                                </div>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<script type="text/javascript">
$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#doctorsPage").addClass("active");
});
function confirmDelete() {
    if(!confirm("Are you sure you want to delete this doctor?")) {
        return false;
    }
    else {
        return true;
    }
}
</script>
<?php include(LIB_HTML.'admin/footer.php');?>