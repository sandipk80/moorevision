<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'admin/pages/index-init.php');
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
                            <h3><?php echo $pageTitle;?></h3>
                            <div class="actions pull-right">
                                <button name="add-new-page" class="btn btn-primary" type="button" onclick="javascript:return addNewPage();"><i class="fa fa-plus-circle"></i> Add New Page</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form method="post" name="frmListing" id="frmListing" action="">
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th><input name="chkRecordId" value="0" onclick="checkAll(this.form)" type='checkbox' class="checkbox" /></th>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Created</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(is_array($result) && count($result)>0){
                                            foreach($result as $row){
                                                $deleteItem=ADMIN_SITE_URL."pages.php?act=delete&id=".$row['id'];
                                        ?>
                                        <tr>
                                            <td align="center"><input type="checkbox" onclick="javascript:isAllSelect(this.form);" name="chkRecordId" value="<?php echo $row['id'];?>" /></td>
                                            <td><?php echo $row['title'];?></td>
                                            <td><?php echo $row['slug'];?></td>
                                            <td><?php echo date("F d, Y", strtotime($row['created']));?></td>
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
                                            <td>
                                                <a class="btn btn-default" href="<?php echo ADMIN_SITE_URL.'add-page.php?id='.$row['id'];?>">Edit</a>
                                                <a class="btn btn-danger" href="<?php echo $deleteItem;?>" onclick="javascript: return confirmDelete();">Delete</a>
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
                                            <span><input name="Active" type="submit" class="btn btn-success" value="Activate"  onclick="setStatus('Activate','activate', document.frmListing);"/></span>
                                            &nbsp;<span><input name="Inactivate" type="submit" class="btn btn-warning" value="Deactivate"  onclick="setStatus('Deactivate','deactivate', document.frmListing);"/></span>
                                            &nbsp;<span><input name="Delete" type="submit" class="btn btn-danger" value="Delete"  onclick="setStatus('Delete','delete', document.frmListing);"/></span>
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
    $("#staticPage").addClass("active");
    $('#dynamic-table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "order": [[ 1, "desc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0,4 ] }
        ]
    });
});
function addNewPage(){
    location.href="<?php echo ADMIN_SITE_URL; ?>add-page.php";
    return false;
}
function confirmDelete() {
    if(!confirm("Are you sure you want to delete this page?")) {
        return false;
    }
    else {
        return true;
    }
}
$(document).on("click", ".updateStatus", function (e) {
    var this_link = $(this);
    var status = $(this).attr("rel");
    var id = $(this).attr("data");
    if(confirm("Are you sure want to update the status of this doctor?")) {
        $.ajax({
            url:'<?php echo AJAX_PATH;?>admin/ajaxUpdateStatus.php',
            dataType: "json",
            method: "post",
            data: {id:id,st:status,tb:'pages'},
            cache: false,
            success:function(data){
                var obj = jQuery.parseJSON(JSON.stringify(data));
                alert(obj.message);
                if(obj.result == "success"){
                    if(status==0){
                        $(this_link).attr("rel",1).html('<img src="<?php print IMG_PATH;?>/deactivate.png" title="Click to activate" alt="Inactive" border="0" />');
                    }else{
                        $(this_link).attr("rel",0).html('<img src="<?php print IMG_PATH;?>/activate.png" title="Click to deactivate" alt="Active" border="0" />');
                    }
                    return false;
                }else{
                    alert(obj.message);
                    return false;
                }
            }
        });
    }
    return false;
});
</script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>script/functions.js"></script>
<?php include(LIB_HTML.'admin/footer.php');?>