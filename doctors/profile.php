<?php
include('../cnf.php');
##-----------CHECK Doctor LOGIN START---------------##
validateDoctorLogin();
##-----------CHECK Doctor LOGIN END---------------##
include(LIB_PATH . 'doctors/edit-profile-init.php');
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
                <li><a href="<?php echo DOCTOR_SITE_URL;?>doctors.php">Doctors</a></li>
                <li class="active"><?php echo $pageTitle;?></li>
            </ol>
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
							<form method="post" action="" name="frmEditProfile" id="frmEditProfile" class="form-horizontal form-border" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">First Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" id="first_name" value="<?php echo $first_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Last Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" id="last_name" value="<?php echo $last_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-6">
                                        <?php echo $email; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Fee</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="fee" placeholder="Doctor Fee" id="name" value="<?php echo $fee; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Select Category</label>
                                    <div class="col-sm-6">
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">-- Select Category --</option>
                                            <?php
                                            if(is_array($arrCategories) && count($arrCategories)>0){
                                                foreach($arrCategories as $cat){
echo '<option value="'.$cat['id'].'">'.ucwords($cat['name']).'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Select Service</label>
                                    <div class="col-sm-6">
                                        <select name="service_id" id="service_id" class="form-control">
                                            <option value="">-- Select Service --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Phone</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="phone" placeholder="Doctor Phone" id="phone" value="<?php echo $phone; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Address</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="address" placeholder="Doctor Address" id="address" value="<?php echo $address; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">State</label>
                                    <div class="col-sm-6">
                                        <select name="state_id" id="state_id" class="form-control">
                                            <option value="">-- Select State --</option>
                                            <?php
                                            if(is_array($arrStates) && count($arrStates)>0){
                                                foreach($arrStates as $state){
                                                    echo '<option value="'.$state['id'].'">'.$state['name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">City</label>
                                    <div class="col-sm-6">
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="">-- Select City --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Postcode</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="zipcode" placeholder="Postcode" id="name" value="<?php echo $zipcode; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Upload Photo</label>
                                    <div class="col-sm-3">
                                        <input type="file" name="primary_image" id="primary_image" />
                                        <p class="help-block">Upload doctor profile image</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <?php
                                        if(isset($docImage) && file_exists(STORAGE_PATH.'doctors/'.$docImage)){
                                            $docPhoto = STORAGE_HTTP_PATH.'doctors/'.$docImage;
                                        }else{
                                            $docPhoto = STORAGE_HTTP_PATH.'doctors/no-image.jpg';
                                        }
                                        ?>
                                        <img src="<?php echo $docPhoto;?>" alt="" id="imgArea" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Intro Text</label>
                                    <div class="col-sm-6">
                                        <textarea name="intro_text" id="intro_text" class="form-control" rows="3"><?php echo $intro_text;?></textarea>

                                <div class="form-group btn-row">
                                    <input type="hidden" name="pre_doc_photo" id="pre_doc_photo" value="<?php echo $docImage;?>" />
                                    <input type="hidden" name="edit-profile" value="submit" />
                                    <input type="submit" class="btn btn-success btn-square" value="Submit" />
                                    <input type="button" class="btn btn-default" value="Cancel" id="btnCancel" />
                                </div>
							</form>
						</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<script type="text/javascript">
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#imgArea').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#primary_image").change(function(){
    readURL(this);
});
$(document).on("change", "#category_id", function (e) {
    var category_id = $(this).val();
    if(category_id=='' || category_id==null) {
        $("#service_id option").remove();
        return false;
    }
    $(this).after('<img class="loading" src="<?php echo IMG_PATH;?>loading.gif" />');
    $.ajax({
        url:'<?php echo AJAX_PATH;?>listCategoryServices.php?cid='+category_id,
        cache: false,
        dataType: "html",
        success:function(data){
            $("#service_id option").remove();
            $("#service_id").append(data);
            $(".loading").remove();
        }
    });
});
$(document).on("change", "#state_id", function (e) {
    var state_id = $(this).val();
    if(state_id=='' || state_id==null) {
        $("#city_id option").remove();
        return false;
    }
    $(this).after('<img class="loading" src="<?php echo IMG_PATH;?>loading.gif" />');
    $.ajax({
        url:'<?php echo AJAX_PATH;?>listCityByState.php?state_id='+state_id,
        cache: false,
        dataType:"html",
        success:function(data){
            $("#city_id option").remove();
            $("#city_id").append(data);
            $(".loading").remove();
        }
    });
});

$(document).ready(function() {
    $(".nav-pills li").removeClass("active");
    $("#doctorsPage").addClass("active");

    $("#frmEditProfile").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            fee: "required",
            category_id: "required",
            service_id: "required",
            address: {
                required: true
            },
            state_id: {
                required: true
            },
            city_id: {
                required: true,
                digits: true
            },
            zipcode: {
                required: true
            }
        }
    });
    $(document).on('click', '#btnCancel', function (e){
        window.location.href = "doctors.php";
    });

    $("#category_id").val("<?php echo $category_id; ?>").trigger('change');
    setTimeout(function() {
        $("#service_id").val("<?php echo $service_id; ?>");
    }, 1500);

    $("#state_id").val("<?php echo $state_id; ?>").trigger('change');
    setTimeout(function() {
        $("#city_id").val("<?php echo $city_id; ?>");
    }, 1500);
});
</script>
<?php include(LIB_HTML.'doctors/footer.php');?>