<?php
/**
* Copyright (c) 2017 Netixy Development
*/

		/* Background */
		
		$bg = array('bg-01.png', 'bg-02.png', 'bg-03.png', 'bg-04.png', );

		$i = rand(0, count($bg)-1);
		$selectedBg = "$bg[$i]";
		
		$id = $_GET['id'];
		
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
		<title>MineThemepark | User</title>
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
					<div class="box-login">
						<center><img src="https://minotar.net/avatar/<?php echo getMinecraft($id) ?>" width="40%" class="img-circle" style="max-height: 100%;" /></center>
						<center><h4><strong><?php echo getFirstname($id) ?> <?php echo getFamilyname($id) ?></strong></h4>
<?php
						if(isBanned($id)){
							echo '<h4><span class="label label-danger">Banned</span></a></h4>';
						}
?>
						</center>
						<ul class="fa-ul">
							 <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo getMinecraft($id) ?></li>
							 <li>
<?php						if(isPlayerFollowingAnyPark($_SESSION['id'])) {
								echo '<i class="fa fa-square" aria-hidden="true"></i> Following '.CountFollowing($id).' parks';
							}
							else {
								echo '<i class="fa fa-square" aria-hidden="true"></i> You aren&rsquo;t following any park.';
							}

?>							</li>
							<li><i class="fa fa-calendar" aria-hidden="true"></i> Registered on <?php echo getDatum($id) ?></li>
						</ul>
						<center><hr style="width: 80%;"></center>
<?php
	if(isStaff($_SESSION['id'])) {
		
		require_once('core/ini.php');
		$sql 	= "SELECT * FROM `ranks` WHERE `id`='".getStaffRank($id)."'";
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
	$sql 	= "SELECT * FROM `parks_staff` WHERE `user_id`='".$id."' ORDER BY id DESC";
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
				<div class="col-sm-6">
					<div class="box-login">
						<h4 style="margin-left: 5%;"><strong>Comments</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
<?php
						require_once('core/ini.php');
	
		$sql 	= "SELECT * FROM `comments` WHERE `user_id`='".$id."' AND `deleted`='0' ORDER BY id DESC";
		$result = connection()->query($sql);
		
		if($result->num_rows > 0){
		
			while($row = $result->fetch_assoc())
			{
				
				$park_id = getParkidFromArticle($row['post_id']);
				
				echo '<div class="media">
						<div class="media-left">
							<a href="park.php?id='.$park_id.'"><img src="'.getParklogo($park_id).'" class="media-object img-circle" style="width:50px"></a>
						</div>
						<div class="media-body">
							<h5 class="media-heading"><a href="article.php?id='.$row['post_id'].'" class="park-link">'.getArticleTitle($row['post_id']).'</a> - '.$row['datum'].'</h5>
							<p><strong>'.$row['data'].'</strong></p>
						</div>
					</div>';
			}
		}
		else {
			echo '<h5>This user has no comments posted.</h5>';
		}

?>
						</div>
					</div>
					<div class="box-login">
						<h4 style="margin-left: 5%;"><strong>Followed Parks</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
							<div class="row">
<?php

	require_once('core/ini.php');
	
	$email = getEmail($id);
	
	$sql 	= "SELECT * FROM `parks` WHERE `deleted`='0' AND `reviewed`='1' AND `followers` LIKE '%{$email}%' ORDER BY ID";
    $result = connection()->query($sql);
	if($result->num_rows > 0){
	
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
	}
	else {
			echo '<h5>This user follows no parks.</h5>';
	}

?>



							</div>
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