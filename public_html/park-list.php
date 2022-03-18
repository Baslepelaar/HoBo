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
		<title>MineThemepark | Park list</title>
		<style type="text/css">
		body {
			background: url(https://minethemepark.com/inc/img/background/<?php echo $selectedBg; ?>);
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
<?php
				if($online) {
					echo '<div class="box-login" style="margin-bottom: 10px;">
							<h5>You are owner of a theme park server? Request your park page here. <a href="park-apply.php"><span class="label label-info">Park Request</span></a></h5>
						  </div>';
				}
?>
				<div class="row">
<?php
	require_once('core/ini.php');
	$sql 	= "SELECT * FROM `parks` WHERE `deleted`='0' AND `reviewed`='1' ORDER BY ID";
    $result = connection()->query($sql);
	
	while($row = $result->fetch_assoc())
	{	
	echo'			<div class="col-sm-6">
						<a href="park.php?id='.$row['id'].'" class="park-link">
							<div class="thumbnail text-center">
								<div style="max-height: 100px; background-repeat: no-repeat; background-size: cover; background-position: center top; background: url('.$row['header'].');">
									<img src="'.$row['logo'].'" class="img-circle" height="75p" width="75" style="margin-top: 60px; border-radius: 90%; border: 3px solid white;">
								</div>
								<p style="margin-top: 40px;"><strong class="park-link">'.$row['name'].'</strong></p>
								<p>'.countFollowers($row['id']).' Followers</p>
							</div>
						</a>
					</div>';
	}
?>					</div>

				</div>
				<div class="col-sm-3">
					<?php include('inc/sidebar.php'); ?>
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>