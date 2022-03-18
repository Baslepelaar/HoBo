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
		<title>MineThemepark | Profile</title>
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
					<div class="box-login">
						<center><img src="https://minotar.net/avatar/<?php echo getMinecraft($_SESSION['id']) ?>" width="40%" class="img-circle" style="max-height: 100%;" /></center>
						<center><h4><strong><?php echo getFirstname($_SESSION['id']) ?> <?php echo getFamilyname($_SESSION['id']) ?></strong></h4></center>
						<ul class="fa-ul">
							 <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo getMinecraft($_SESSION['id']) ?></li>
							 <li>
<?php						if(isPlayerFollowingAnyPark($_SESSION['id'])) {
								echo '<i class="fa fa-square" aria-hidden="true"></i> Following '.CountFollowing($_SESSION['id']).' parks';
							}
							else {
								echo '<i class="fa fa-square" aria-hidden="true"></i> You aren&rsquo;t following any park.';
							}

?>							</li>
							<li><i class="fa fa-calendar" aria-hidden="true"></i> Registered on <?php echo getDatum($_SESSION['id']) ?></li>
						</ul>
						<center><hr style="width: 80%;"></center>
<?php
	if(isStaff($_SESSION['id'])) {
		
		require_once('core/ini.php');
		$sql 	= "SELECT * FROM `ranks` WHERE `id`='".getStaffRank($_SESSION['id'])."'";
		$result = connection()->query($sql);
		$count = mysqli_num_rows($result);
		if($count > 0) {
			while($row = $result->fetch_assoc())
			{
				echo '<h5 style="margin-left: 30px;">MineThemepark <span class="label label-'.$row['color'].'">'.$row['name'].'</span></h5><center><hr style="width: 80%;"></center>';
			}
		}
	}



	require_once('core/ini.php');
	$sql 	= "SELECT * FROM `parks_staff` WHERE `user_id`='".$_SESSION['id']."' ORDER BY id DESC";
    $result = connection()->query($sql);
	$count = mysqli_num_rows($result);
	if($count > 0) {
		while($row = $result->fetch_assoc())
		{
			echo '<h5 style="margin-left: 30px;"><span class="label label-primary">'.$row['rank'].'</span> by <a href="park.php?id='.$row['park_id'].'" class="park-link">'.getParkname($row['park_id']).'</a></h5>';
		}
	}
	else {
		echo '';
	}
?>
					</div>
				</div>
				<div class="col-sm-9">
					<div class="row">
					
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-5">
									<div class="box-login" style="border-left: 4px solid #b90303; border-radius: 5px;">
										<p style="font-size: 175%;"><i class="fa fa-lock" aria-hidden="true"></i> Change Password</p>
										<p>Change your password, make sure your choose a <span style="color: #b90303;">strong</span> password.</p>
									</div>	
								</div>
								<div class="col-sm-7">
									<div class="box-login" style="border-radius: 5px;">
										<form id="password" class="form-horizontal" method="GET">
											<div class="form-group">
												<label class="control-label col-sm-3">Old:</label>
												<div class="col-sm-8">
													<input name="Old" class="form-control" id="pr_old" placeholder="Old password" type="password" / disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-3">New:</label>
												<div class="col-sm-8">
													<input name="New" class="form-control" id="pr_new" placeholder="New password" type="password" / disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-3">Repeat:</label>
												<div class="col-sm-8">
													<input name="Repeat New" class="form-control" id="pr_re_new" placeholder="Repeat new password" type="password" / disabled>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-8">
													<button type="submit" class="btn btn-danger">
													Save
													</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						
						
					</div>
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>