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
		<title>MineThemepark | Sign Up</title>
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
			<div class="row">
				<div class="col-sm-3">
					
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
<?php 					if(getMaintenance() == '1') { ?>
						<div class="alert alert-warning alert-dismissable fade in">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Maintenance mode is active, you cant make an account now.
						</div>
<?php					}
?>
					<div class="box-login" style="border-radius: 5px;">
						<center><img src="inc/img/favicon.png" height="125px" class="login-logo">
						<h4><strong>Sign Up</strong></h4></center>
						<div class="row">
						<div class="col-sm-offset-3 col-sm-6">
							<hr>
						</div>
						</div>
						<form id="signup" class="form-horizontal" method="GET">
							<div class="form-group">
								<label class="control-label col-sm-3">Email:</label>
								<div class="col-sm-8">
									<input type="hidden" id="su_ip" value="<?php echo $user_ip; ?>">
									<input name="Email" class="form-control" id="su_email" placeholder="Email" type="email" / required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Your name:</label>
								<div class="col-sm-4">
									<input name="FirstName" class="form-control" id="su_fi_name" placeholder="First Name" type="text" / required>
								</div>
								<div class="col-sm-4">
									<input name="FamilyName" class="form-control" id="su_fa_name" placeholder="Family Name" type="text" / required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Minecraft:</label>
								<div class="col-sm-8">
									<input name="Minecraft" class="form-control" id="su_minecraft" placeholder="Minecraft username" type="text" / required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Password:</label>
								<div class="col-sm-8">
									<input name="Password" class="form-control" id="su_password" placeholder="Password" type="Password" / required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-8">
									<input name="PasswordRE" class="form-control" id="su_re_password" placeholder="Repeat Password" type="Password" / required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-8">
								<button type="submit" class="btn btn-danger">Sign Up</button>
						</form>
<script>
$('#signup').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/sign_up.php",
        data: {email: " "+$('#su_email').val(), firstname: " "+$('#su_fi_name').val(), familyname: " "+$('#su_fa_name').val(), minecraft: " "+$('#su_minecraft').val(), password: " "+$('#su_password').val(), re_password: " "+$('#su_re_password').val(), ip: " "+$('#su_ip').val()},
        success: function(data){
            if(data === 'signed_up'){
                document.location.href = '?success=You successfully signed up, please check your mail for activation.';
            }
			else {
				document.location.href = data;
			}
        }
    });
});
</script>
									<a href="login.php" class="park-link" style="margin-left: 150px;">Back to Sign In</a>
								</div>
							</div>	
					</div>
				</div>
				<div class="col-sm-3">
					
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>