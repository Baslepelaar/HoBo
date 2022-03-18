<?php
/**
* Copyright (c) 2017 Netixy Development
*/

		/* Background */
		
		$bg = array('bg-01.png', 'bg-02.png', 'bg-03.png', 'bg-04.png', );

		$i = rand(0, count($bg)-1);
		$selectedBg = "$bg[$i]";
		
		session_start();
		include('core/functions.php');
		include('core/feed-api.php');
		include('core/Mobile_Detect.php');
		$online = false;
			if(is_online())
		{
			$online = true;
		}
		
		if(getMaintenance() == '1') {
			if(!$online) {
				header('Location: maintenance.php');
			}
			else {
				if(!isStaff($_SESSION['id'])) {
					header('Location: maintenance.php');
				}
			}
		}
		else {
			if(!$online) {
				header('Location: index.php');
			}
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
		<title>MineThemepark | Home</title>
		<style type="text/css">
		body {
			background: url(http://minethemepark.com/inc/img/background/<?php echo $selectedBg; ?>);
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
		<div class="container ctpadding" style="background-color: #efefef;">	
			<div class="row">
				<div class="col-sm-3">
					<?php include('inc/sidebar-left.php'); ?>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					
					<div class="box-login">
						<h4>Request your park...</h4>
						<p>Fill in every field end you will be notified if your request is accepted.<br>
						   We request some info about your park before we accept it.</p>
						<center><hr style="width: 90%;"></center>
						<div style="margin-right: 5%;">
							<form id="parkapply" class="form-horizontal" method="GET">
								<div class="form-group">
									<div class="row">
										<label class="control-label col-sm-3">Park name*:</label>
										<div class="col-sm-8">
											<input type="hidden" id="park_owner" value="<?php echo $_SESSION['id'] ?>">
											<input name="name" class="form-control" id="park_name" placeholder="Park name*" type="text" / required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="control-label col-sm-3">IP adress*:</label>
										<div class="col-sm-8">
											<input name="name" class="form-control" id="park_ip" placeholder="IP adress*" type="text" / required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="control-label col-sm-3">Website:</label>
										<div class="col-sm-8">
											<input name="name" class="form-control" id="park_website" placeholder="Website" type="text" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="control-label col-sm-3">Social media:</label>
										<div class="col-sm-4">
											<input name="name" class="form-control" id="park_twitter" placeholder="Twitter*" type="text" / required>
										</div>
										<div class="col-sm-4">
											<input name="name" class="form-control" id="park_facebook" placeholder="Facebook" type="text" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-3 col-sm-4">
											<input name="name" class="form-control" id="park_youtube" placeholder="YouTube" type="text" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-3 col-sm-2">
											<button type="submit" class="btn btn-danger">
											Send
											</button>
										</div>
									</div>
								</div>
							</form>
<script>
$('#parkapply').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/park_apply.php",
        data: {park_owner: " "+$('#park_owner').val(), park_name: " "+$('#park_name').val(), park_ip: " "+$('#park_ip').val(), park_website: " "+$('#park_website').val(), park_twitter: " "+$('#park_twitter').val(), park_facebook: " "+$('#park_facebook').val(), park_youtube: " "+$('#park_youtube').val()},
        success: function(data){
            if(data === 'park_apply_success'){
                document.location.href = '?success=Your request is successfully send.';
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
				<div class="col-sm-3">
					<?php include('inc/sidebar.php'); ?>
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>