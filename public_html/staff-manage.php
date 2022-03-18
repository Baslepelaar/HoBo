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
			$id = $_GET['id'];
		
			if(!empty($_GET['id'])) {
				if(!canManageStaff($_SESSION['id'])) {
					header('Location: staff-panel.php?warning=You are not allowed to manage the MineThemepark staff. If this is wrong you can contact a site administrator.');
				}
				else{
					$rank = getStaffRank($id);
				}
			}
			else {
				header('Location: staff-panel.php');
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
		<title>MineThemepark | Manage Staff</title>
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
						<div style="margin-left: 5%; margin-right: 5%;">
							<div class="media">
								<div class="media-left">
									<a href="users.php?id=<?php echo $id; ?>"><img src="https://minotar.net/avatar/<?php echo getMinecraft($id); ?>" class="media-object img-circle" style="width: 60px"></a>
								</div>
								<div class="media-body">
									<h5 class="media-heading"><a href="users.php?id=<?php echo $id; ?>" class="park-link"><strong><?php echo getFirstname($id); ?> <?php echo getFamilyname($id); ?></strong></a> <?php echo getRank($rank); ?></h5>
									<h4 style="margin-top: 30px;"><strong>Permission Management</strong></h4>
									<center><hr style="width: 100%;"></center>
									<div class="row" style="margin-top: 15px;">
<?php 
						if(canManageStaff($_SESSION['id'])) {
							
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."'";
							$result = connection()->query($sql);
							if($result->num_rows > 0){
								while($row = $result->fetch_assoc())
								{
									/* Staff Panel */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Use Staff Panel</strong>
												<h4>';
										if($row['can_use_staffpanel'] == '1'){
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_use_staffpanel&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_use_staffpanel&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
										  
									/* Manage Staff */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Manage Staff</strong>
												<h4>';
										if($row['can_manage_staff'] == '1'){
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_staff&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_staff&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
										  
									/* Manage Park Requests */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Manage Park Requests</strong>
												<h4>';
										if($row['can_manage_parkrequests'] == '1'){
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_parkrequests&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_parkrequests&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
										  
									/* Manage Users */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Manage Users</strong>
												<h4>';
										if($row['can_manage_users'] == '1'){
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_users&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_users&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
										  
									/* Manage Parks */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Manage Parks</strong>
												<h4>';
										if($row['can_manage_parks'] == '1'){
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_parks&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_parks&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
										  
									/* Manage Comments */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Manage Comments</strong>
												<h4>';
										if($row['can_manage_comments'] == '1'){
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_comments&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_comments&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
										  
									/* Manage Settings */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Manage Settings</strong>
												<h4>';
										if($row['can_manage_settings'] == '1'){
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_settings&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_settings&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
										  
									/* Manage Posts */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Manage Posts</strong>
												<h4>';
										if($row['can_manage_posts'] == '1'){
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_posts&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_manage_posts&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
										  
									/* Write Posts */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Write Posts</strong>
												<h4>';
										if($row['can_write_post'] == '1'){
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_write_post&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/staff-perms.php?id='.$id.'&perm=can_write_post&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
								}
							}
						}
?>			
									</div>
									<h4><strong>Rank Management</strong></h4>
									<center><hr style="width: 100%;"></center>
									<h5>Current rank: <?php echo getRank($rank); ?></h5>
									<div class="row" style="margin-top: 15px;">
<?php					
						if(canManageStaff($_SESSION['id'])) {
							
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `ranks`";
							$result = connection()->query($sql);
							if($result->num_rows > 0){
								while($row = $result->fetch_assoc())
								{
									echo '<div class="col-sm-4">
											<a href="core/staff-rank.php?id='.$id.'&rank='.$row['id'].'">
												<div class="well">
													<center>
														<h4>
															<span class="label label-'.$row['color'].'">'.$row['name'].'</span>
														</h4>
													</center>
												</div>
											</a>
										  </div>';
								}
							}
							else{
								echo 'There are no ranks to load in.';
							}
						}

?>									</div>
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