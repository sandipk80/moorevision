<?php
include('../cnf.php');
include(LIB_PATH . 'doctors/examinations/add-init.php');
include(LIB_HTML . 'doctors/header.php');
include(LIB_HTML . 'doctors/leftbar.php');
?>
<script type="text/javascript">
var SITE_URL = '<?php echo SITE_URL;?>';
</script>
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
                        <form method="post" action="" name="formAddExam" id="formAddExam" class="form-border" enctype="multipart/form-data">
                            

                            <div class="col-md-12">
                                <div class="border" style="border-right:0;">
                                <div class="col-sm-6">
                                    <div class="form-group" style="overflow:hidden;">
                                        <div id="wPaint" style="position:relative; width:500px; height:200px; margin:70px auto 20px auto;"><img src="<?php echo IMG_PATH;?>left-eye.png" /></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" id="wPaint-img" style="overflow:hidden;"></div>
                                </div>
                            </div>

                            

                            <div class="col-md-12">
                                <div class="form-group btn-row">
                                    <input type="hidden" name="patient_id" value="<?php echo $_GET['pid'];?>" />
                                    <input type="hidden" name="exam_id" value="<?php echo $_GET['eid'];?>" />
                                    <input type="hidden" name="left_image_file" id="left_image_file" value="">
                                    <input type="hidden" name="add-examination" value="submit" />
                                    <input type="submit" class="btn btn-success btn-square" value="Submit" />
                                    <input type="button" class="btn btn-default" value="Cancel" id="btnCancel" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<style>
.form-control{width:90% !important;}
select{padding: 7px 14px !important; height: 40px !important;}
.control-label{font-weight:normal !important;}
</style>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="<?php echo CSS_SITE_URL;?>jquery.datetimepicker.css" type="text/css" />
<link rel="stylesheet" href="<?php echo ASSET_SITE_URL;?>plugins/icheck/css/all.css">
<script src="<?php echo ASSET_SITE_URL;?>plugins/icheck/js/icheck.min.js"></script>

<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/jquery.ui.core.1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/jquery.ui.widget.1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/jquery.ui.mouse.1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/jquery.ui.draggable.1.10.3.min.js"></script>

<!-- wColorPicker -->
<link rel="Stylesheet" type="text/css" href="<?php echo CSS_SITE_URL;?>wColorPicker.min.css" />
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/wColorPicker.min.js"></script>

<!-- wPaint -->
<link rel="Stylesheet" type="text/css" href="<?php echo CSS_SITE_URL;?>wPaint.min.css" />
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/wPaint.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/plugins/main/wPaint.menu.main.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/plugins/text/wPaint.menu.text.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/plugins/shapes/wPaint.menu.main.shapes.min.js"></script>
<script type="text/javascript" src="<?php echo SCRIPT_SITE_URL;?>wpaint/plugins/file/wPaint.menu.main.file.min.js"></script>

<script type="text/javascript">
var images = [
  '<?php echo IMG_PATH;?>left-eye.png',
];

function saveImg(image) {
    var _this = this;
    alert("heello");
    $.ajax({
        type: 'POST',
        url: '../ajax/upload-examination-image.php',
        data: {image: image},
        success: function (resp) {
            // internal function for displaying status messages in the canvas
            _this._displayStatus('Image saved successfully');

            // doesn't have to be json, can be anything
            // returned from server after upload as long
            // as it contains the path to the image url
            // or a base64 encoded png, either will work
            resp = $.parseJSON(resp);

            // update images array / object or whatever
            // is being used to keep track of the images
            // can store path or base64 here (but path is better since it's much smaller)
            images.push(resp.img);

            $('#wPaint-img').attr('src', image);
        }
    });
}

function loadImgBg () {
    // internal function for displaying background images modal
    // where images is an array of images (base64 or url path)
    // NOTE: that if you can't see the bg image changing it's probably
    // becasue the foregroud image is not transparent.
    this._showFileModal('bg', images);
}

function loadImgFg () {
    // internal function for displaying foreground images modal
    // where images is an array of images (base64 or url path)
    this._showFileModal('fg', images);
}

// init wPaint
$('#wPaint').wPaint({
    path: '',
    theme: 'standard classic',
    menuOffsetLeft: -35,
    menuOffsetTop: -50,
    saveImg: saveImg,
    loadImgBg: loadImgBg,
    loadImgFg: loadImgFg,
    bg: '<?php echo IMG_PATH;?>left-eye.png',
    image: '<?php echo IMG_PATH;?>left-eye.png',
    fillStyle: '#000000',
    strokeStyle: '#000000',
    strokeColor: '#FFFF00',
    menuTitles: {
        'fillColor': '#000000'
    }
});


$(document).ready(function() {
    $(".wPaint-menu-icon-name-save").click();
});

</script>
<?php include(LIB_HTML . 'doctors/footer.php');?>