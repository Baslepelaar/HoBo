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
		
		if(!$online) {
				header('Location: index.php');
		}
		else {
			if(!canManageUsers($_SESSION['id'])) {
					header('Location: staff-panel.php?success=You are not allowed to manage users. If this is wrong you can contact a site administrator.');
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
						<center><h4><strong>Stats</strong></h4></center>
						<center><hr style="width: 90%;"></center>
						
						<center><h1><i class="fa fa-user" aria-hidden="true"></i></h1>
						<h5>Active Users</h5>
						<h4><strong><?php echo countUsers(); ?></strong></h4></center>
						<center><hr style="width: 60%;"></center>
						
						<center><h1><i class="fa fa-user-times" aria-hidden="true"></i></h1>
						<h5>Banned Users</h5>
						<h4><strong><?php echo countBannedUsers(); ?></strong></h4></center>
						<center><hr style="width: 60%;"></center>
						
						<center><h1><i class="fa fa-ticket" aria-hidden="true"></i></h1>
						<h5>Active Parks</h5>
						<h4><strong><?php echo countActiveParks(); ?></strong></h4></center>
						<center><hr style="width: 60%;"></center>
						
						<center><h1><i class="fa fa-plus-circle" aria-hidden="true"></i></h1>
						<h5>Park Request</h5>
						<h4><strong><?php echo countRequestParks(); ?></strong></h4></center>
						<center><hr style="width: 60%;"></center>
						
						<center><h1><i class="fa fa-square-o" aria-hidden="true"></i></h1>
						<h5>Active Park Posts</h5>
						<h4><strong><?php echo countPostParks(); ?></strong></h4></center>
						<center><hr style="width: 60%;"></center>
						
						<center><h1><i class="fa fa-plus-circle" aria-hidden="true"></i></h1>
						<h5>Park Post Resuests</h5>
						<h4><strong><?php echo countRequestPostParks(); ?></strong></h4></center>
						<center><hr style="width: 60%;"></center>
					</div>
				</div>
				<div class="col-sm-9">
				<?php include('inc/alert.php'); ?>
					<div class="box-login" >
						<h5 style="margin-left: 5%;"><a href="staff-panel.php" class="park-link"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</strong></a></h5>
					</div>
				
					<div class="box-login" >
						<h4 style="margin-left: 5%;"><strong>Users</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
<?php
						if(canManageUsers($_SESSION['id'])) {
							
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `users` ORDER BY id";
							$result = connection()->query($sql);
							if($result->num_rows > 0){
								
								echo '<table class="table table-striped">
										<thead>
											<tr>
												<th>Name</th>
												<th>Email</th>
												<th>Minecraft</th>
												<th>Active</th>
												<th>Date</th>
												<th>Ban</th>
											</tr>
										</thead>
										<tbody>';	
								while($row = $result->fetch_assoc())
								{
									echo '<tr>
											<td><a href="users.php?id='.$row['id'].'" class="park-link">'.getFirstname($row['id']).' '.getFamilyname($row['id']).'</a>';
										if(isStaff($row['id'])){
											echo ' <span class="label label-danger">Staff</span>';
										}
									echo '	</td>
											<td>'.$row['email'].'</td>
											<td><img src="https://minotar.net/avatar/'.getMinecraft($row['id']).'" height="20px" /> '.getMinecraft($row['id']).'</td>
											<td>';
											if($row['active'] == '1'){
												echo '<span class="label label-success">Active</span>';
											}
											else {
												echo '<span class="label label-danger">Inactive</span>';
											}
									echo ' 	</td>
											<td>'.$row['datum'].'</td>
											<td>';
											if($row['banned'] == '1'){
												echo '<a href="core/users-ban.php?id='.$row['id'].'&ban=0"><span class="label label-danger">Unban</span></a>';
											}
											else {
												echo '<a href="core/users-ban.php?id='.$row['id'].'&ban=1"><span class="label label-danger">Ban</span></a>';
											}
									echo '	</td>
										  </tr>';
								}
								echo '	</tbody>
									  </table>';
							}
							else{
								echo '<h5>There is nog staff to manage...</h5>';
							}
						}
						else{
							echo '<h5>You are not allowed to manage MineThemepark staff. If this is wrong you can contact a site administrator.</h5>';
						}
?>	
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>