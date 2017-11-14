<?php
include('../cnf.php');
##-----------CHECK OWNER LOGIN START---------------##
validateAdminLogin();
##-----------CHECK OWNER LOGIN END---------------##
require_once(LIB_PATH.'admin/dashboard-init.php');
include(LIB_HTML . 'admin/header.php');
include(LIB_HTML . 'admin/leftbar.php');
?>
<section class="main-content-wrapper">
    <div class="pageheader">
        <h1>Dashboard</h1>
        <p class="description">Welcome to Admin Portal</p>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">You are here:</span>
            <ol class="breadcrumb">
                <li class="active"><a href="<?php echo ADMIN_SITE_URL;?>dashboard.php">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <section id="main-content" class="animated fadeInUp">
        <div class="row">
            <?php include(LIB_HTML . 'message.php');?>

            


        </div>
    </section>
</section>
<?php include(LIB_HTML . 'admin/footer.php');?>