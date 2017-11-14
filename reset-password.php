<?php
include('cnf.php');
require_once(LIB_PATH . 'GlobalManager.php');
$globalManager = GlobalManager::getInstance();
include(LIB_HTML . 'header.php');
$pageTitle = "Reset Password";
$showError = "";
if(!isset($_REQUEST['cid'])) {
	$showError = "Link provided by you is not valid";
}

if(isset($_REQUEST['cid']) && trim($_REQUEST['cid'])=='') {
	$showError = "Link provided by you is not valid";
}
$result = array();

if(trim($showError) == '') {
	$condition = "pwd_reset_code='".$_REQUEST['cid']."'";
	$result = $globalManager->runSelectQuery("users", "id,firstname,lastname,email", $condition);
	if(is_array($result) && count($result)>0) {
		if(isset($_POST['reset-password']) && trim($_POST['reset-password'])=='Submit') {
		}
		else {
			$_SESSION['message']="Please enter a new password for this account.";
		}
	}
	else {
		$showError ="Link provided by you is not valid";
	}
}
if(isset($_POST['reset-password']) && trim($_POST['reset-password'])=='Submit') {
	if(isset($_POST['password']) && trim($_POST['password'])=='') {
		$error[] ="Password can not be left blank";
	}
	
	if(isset($_POST['repassword']) && trim($_POST['repassword'])=='') {
		$error[] ="Confirm password can not be left blank";
	}
	
	if(isset($_POST['password']) && trim($_POST['password'])!=='' && isset($_POST['repassword']) && trim($_POST['repassword'])!=='') {
		if(trim($_POST['password'])!==trim($_POST['repassword'])) {
			$error[] ="Please enter same re password as password";
		}
	}
	if(count($error)=='0') {
		$where = "id='".$result[0]['id']."'";
		$recordArray=array(
			'password' => md5($_POST['password']),
			'pwd_reset_code' => ''
		);		
		$globalManager->runUpdateQuery('users',$recordArray,$where);
		$_SESSION['message'] = "Password updated successfully. Please login to continue.";
		redirect(USER_SITE_URL."login.php");
	}	
}
?>
<script src="<?php echo SCRIPT_SITE_URL;?>jquery.validate.js"></script>
<div class="main-banner five">
	<div class="container">
		<h2><span>Reset Password</span></h2>
	</div>
</div>
<div class="container main-container">
	<div class="contact-content">
		<div class="row">
			<!-- Contact Form Starts -->
			<div class="col-sm-12 col-xs-12">
				<h3>Reset your account password by filling the form below</h3>
				<div class="status alert alert-success contact-status"></div>
				<p>Not a member? <a href="<?php echo USER_SITE_URL;?>signup.php"><strong>Sign Up</strong></a></p>
				<?php
				if(trim($showError)!=='') {
				?>
					<div class="msg msg-error">
						<p><strong>
						<?php
						echo $showError;
						?></strong></p>
					</div>
				<?php
				}else {
					include(LIB_HTML.'message.php');
					if (is_array($error) && count($error) > 0) {
				?>
					<!-- our error container -->
					<div class="error-container" style="display:block;">
						<ol>
							<?php
							foreach ($loginError as $key => $val) {
								?>
								<li>
									<label class="error" for="<?php echo $key; ?>"><?php echo $val; ?></label>
								</li>
								<?php
							}
							?>
						</ol>
					</div>
				<?php
					}
				}
				?>

				<form id="frmResetPassword" class="contact-form" name="frmResetPassword" method="post" action="" role="form">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label for="password">New Password <span class="required">*</span></label>
								<input type="password" class="form-control" name="password" id="password" value="">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="repassword">Confirm Password <span class="required">*</span></label>
								<input type="password" class="form-control" name="repassword" id="repassword">
							</div>
						</div>

						<div class="col-xs-8">
                            <input type="hidden" name="reset-password" value="Submit" />
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
	$("#frmResetPassword").validate({
       rules: {        	        		
			password :"required",
			repassword:{
				equalTo: "#password"
		    }		
    	}
    });	
});
</script>
<?php include(LIB_HTML . 'footer.php');?>