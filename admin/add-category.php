<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
include(LIB_PATH . 'admin/categories/add-init.php');
include(LIB_HTML . 'admin/header.php');
include(LIB_HTML . 'admin/leftbar.php');
?>
<section class="main-content-wrapper">
    <div class="pageheader">
        <h1><?php echo $pageTitle;?> </h1>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li><a href="<?php echo ADMIN_SITE_URL;?>dashboard.php">Dashboard</a></li>
                <li><a href="<?php echo ADMIN_SITE_URL;?>categories.php">Categories</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
        </div>
    </div>
    <section id="main-content" class="animated fadeInUp">
        <div class="row">
            <?php include(LIB_HTML . 'message.php');?>
            <?php
            if(is_array($error) && count($error)>0) {
            ?>
            <!-- our error container -->
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
            <h4>Oh snap! You got an error!</h4>
            <?php
            foreach($error as $key=>$val) {
            ?>
            <p><label class="error" for="<?php echo $key;?>"><?php echo $val;?></label></p>
            <?php
                }
            }
            ?>
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
						<form method="post" action="" name="frmAddCategory" id="frmAddCategory" class="form-horizontal form-border">
							<div class="form-group">
								<label class="col-sm-3 control-label">Name</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="name" placeholder="Category Name" id="name" value="<?php echo $catName; ?>">
								</div>
							</div>
							
							<div class="form-group btn-row">
                                <input type="hidden" name="cid" value="<?php echo $_GET['id'];?>" />
                                <input type="hidden" name="add-category" value="submit" />
								<input type="submit" class="btn btn-success btn-square" value="Submit" />
                                <input type="button" class="btn btn-default" value="Cancel" id="btnCancel" />
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
    $(".nav-pills li").removeClass("active");
    $("#menusPage").addClass("active");
	$("#frmAddCategory").validate({   
		rules: {
			name: {
			  required: true,
			  minlength: 3
			}
		}
    });
	$(document).on('click', '#btnCancel', function (e){
		window.location.href = "menus.php";
	});
});
</script>
<?php include(LIB_HTML.'admin/footer.php');?>