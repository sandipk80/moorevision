<?php
include('../cnf.php');
require_once(LIB_PATH.'doctors/signin-init.php');
include(LIB_HTML . 'doctors/front-header.php');
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div id="login-wrapper">
            <header>
                
                <div class="brand">
                    <img src="<?php echo IMG_PATH;?>logo.png" alt="" title="" />
                </div>
            </header>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Sign In
                    </h3>
                </div>
                <div class="panel-body">
                    <p> Login to access your account.</p>
                    <?php
                    if(is_array($errors) && count($errors)>0) {
                        ?>
                        <!-- our error container -->
                        <div class="error-container" style="display:block;">
                            <ol>
                                <?php
                                foreach($errors as $key=>$val) {
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
                    <form name="frmLogin" id="frmLogin" class="form-horizontal" role="form" method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="username" id="username"
                                       placeholder="Email">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Password">
                                <i class="fa fa-lock"></i>
                                <!--<a href="javascript:void(0)" class="help-block">Forgot Your Password?</a>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="hidden" name="loginsubmit" value="login">
                                <input type="submit"  class="btn btn-primary btn-block" value="Sign in" />
                                
                                <!--<a href="javascript:void(0)" class="btn btn-default btn-block">Not a member? Sign Up</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    // USer login validation & submission
    $("#frmLogin").validate({
        rules: {
            username: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        messages: {
            username: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please enter the password",
                minlength: "Your password must be at least 6 characters long"
            }
        }
    });
});
</script>
<?php include(LIB_HTML . 'doctors/front-footer.php');?>