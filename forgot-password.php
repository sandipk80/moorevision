<?php
include('cnf.php');
require_once(LIB_PATH.'users/forgot-password-init.php');
include(LIB_HTML . 'header.php');
?>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
<div class="main-banner five">
    <div class="container">
        <h2><span>Forgot Password</span></h2>
    </div>
</div>
<div class="container main-container">
    <div class="contact-content">
        <div class="row">
            <!-- Contact Form Starts -->
            <div class="col-sm-12 col-xs-12">
                <h3>Submit your email to reset your password</h3>
                <div class="status alert alert-success contact-status"></div>
                <?php
                if(is_array($error) && count($error)>0) {
                    ?>
                    <!-- our error container -->
                    <div class="error-container" style="display:block;">
                        <ol>
                            <?php
                            foreach($loginError as $key=>$val) {
                                ?>
                                <li>
                                    <label class="error" for="<?php echo $key;?>"><?php echo $val;?></label>
                                </li>
                                <?php
                            }
                            ?>
                        </ol>
                    </div>
                    <?php
                }
                include(LIB_HTML.'message.php');
                ?>

                <form id="frmForgotPassword" class="contact-form" name="frmForgotPassword" method="post" action="" role="form">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="username">Email <span class="required">*</span></label>
                                <input type="text" class="form-control" name="email" id="email" value="<?php echo $email;?>">
                            </div>
                        </div>

                        <div class="col-xs-8">
                            <input type="hidden" name="forgot-password" value="Submit" />
                            <input type="submit" class="btn btn-black text-uppercase" value="Submit">
                            <a href="<?php echo USER_SITE_URL;?>" class="ltmarg20">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    //form validation
    $("#frmForgotPassword").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            }
        }
    });
});
</script>
<?php include(LIB_HTML . 'footer.php');?>