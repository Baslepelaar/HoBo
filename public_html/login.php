<?php
		/* Background */
		
		$bg = array('bg-01.png', 'bg-02.png', 'bg-03.png', 'bg-04.png', );
		
		$i = rand(0, count($bg)-1);
		$selectedBg = "$bg[$i]";
		
		session_start();
		include('core/functions.php');
		$online = false;
			if(is_online())
		{
			$online = true;
		}
		if($online) {
			header('Location: index.php');
		}
		
		$user_ip = get_client_ip();
		addIPtoList($user_ip);
		if(isIPBanned($user_ip)){
			header('Location: https://google.com');
		}
?>
<!DOCTYPE html>
<html>
	<head>
		
		<?php include('inc/header.php'); ?>
		<title>MineThemepark | Sign In</title>
		<style type="text/css">
		body {
			background: url(inc/img/background/<?php echo $selectedBg; ?>);
			background-attachment: fixed;
			background-size: cover;
			background-repeat: no-repeat;
			position: relative;
			background-size: cover;
		}
		</style>
	</head>
	<body>
		<?php include('inc/navbar-1.php'); ?>
		<div class="container ctpadding">
		<?php
		$code = ($_GET['code']);
		$id = ($_GET['id']);
		if(isset($_GET['code'])) {
			if(isset($_GET['id'])) {
				include('inc/passresetmodal.php');
			}
			else
			{
				header("Location: login.php?danger=Something went wrong, conntact an admin from the website!");
			}
		} 
		?>



<!-- Password Reset Modal -->

<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLable" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Password reset</h5>
			</div>
			<div class="modal-body">
				<form id="password_reset" method="GET">
					<input name="Password" id="pr_password" placeholder="Password" type="Password" / required>
					<input name="Password" id="pr_re_password" placeholder="Password" type="Password" / required>
					<input type="hidden" id="pr_code" value="<?php echo $code; ?>">
					<input type="hidden" id="pr_id" value="<?php echo $id; ?>">
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger">Save changes</button>
			</form>
<script>
		$('#password_reset').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/password_reset.php",
        data: {code: " "+$('#pr_code').val(), id: " "+$('#pr_id').val(), password: " "+$('#pr_password').val(), re_password: " "+$('#pr_re_password').val()},
        success: function(data){
            if(data === 'password_reseted'){
                document.location.href = 'login.php?success=Your password has been succesfully changed.';
            }
			else {
				document.location.href = data;
			}
        }
    });
});
</script>
			</div>
		</div>
	</div>
</div>

<!-- Password Reset Modal End -->


<!-- Lost Password Mail Modal -->

<div class="modal fade" id="LostPasswordModal" tabindex="-1" role="dialog" aria-labelledby="LostPasswordModalLable" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title" id="exampleModalLabel"><strong>Lost password?</strong></h5>
			</div>
			<form id="password_reset_mail" class="form-horizontal" method="GET">
			<div class="modal-body">
				<div class="row">
					<div class="form-group">
						<label class="control-label col-sm-3">Email:</label>
						<div class="col-sm-8">
							<input name="email" class="form-control" id="pm_email" placeholder="Your Email" type="email" / required>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger">Send Mail</button>
			</form>
<script>
$('#password_reset_mail').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/password_reset_mail.php",
        data: {email: " "+$('#pm_email').val()},
        success: function(data){
            if(data === 'password_reset_mailed'){
                document.location.href = 'login.php?success=A mail for reset your password has been send.';
            }
			else {
				document.location.href = data;
			}
        }
    });
});
</script>
			</div>
		</div>
	</div>
</div>

<!-- Lost Password Mail Modal End -->

			<div class="row">
				<div class="col-sm-3">
					
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
<?php 					if(getMaintenance() == '1') { ?>
						<div class="alert alert-warning alert-dismissable fade in">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Maintenance mode is active, you cant sign in right now.
						</div>
<?php					}
?>
					<div class="box-login" style="border-radius: 5px;">
						<center><img src="inc/img/favicon.png" height="125px" class="login-logo">
						<h4><strong>Sign In</strong></h4></center>
						<div class="row">
						<div class="col-sm-offset-3 col-sm-6">
							<hr>
						</div>
						</div>
						<form id="login" class="form-horizontal" method="GET">
							<div class="form-group">
								<label class="control-label col-sm-3">Email:</label>
								<div class="col-sm-8">
									<input name="Email" class="form-control" id="l_email" placeholder="Email" type="email" / required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Password:</label>
								<div class="col-sm-8">
									<input name="Password" class="form-control" id="l_password" placeholder="Password" type="Password" / required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-8">
									<button type="submit" class="btn btn-danger">
									Sign In
									</button>
					    </form>
<script>
$('#login').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/login.php",
        data: {email: " "+$('#l_email').val(), password: " "+$('#l_password').val()},
        success: function(data){
            if(data === 'loged_in'){
                document.location.href = 'index.php?success=You are successfully logged in.';
            }
			else {
				document.location.href = data;
			}
        }
    });
});
</script>
									<a href="#" data-toggle="modal" class="park-link" data-target="#LostPasswordModal" style="margin-left: 150px;">Lost password?</a>
								</div>
							</div>	
					</div>
					<div class="box-login" style="border-radius: 5px;">
						<center><strong>Sign up to like, follow or to create your own park page...</strong><br>
						<a href="sign-up.php" class="btn btn-danger" style="margin-top: 5px;">Sign Up ></a></center>
					</div>
				</div>
				<div class="col-sm-3">
					
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>