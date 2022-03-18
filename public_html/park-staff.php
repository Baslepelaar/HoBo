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
		
		if(!$online) {
				header('Location: index.php');
		}
		else {
			
			$id = $_GET['id'];
			$park = $_GET['park'];
		
			if(!empty($_GET['id']) && !empty($_GET['park'])) {
				if(!canManageParkStaff($_SESSION['id'], $park)) {
					header('Location: park.php?id='.$park.'&warning=You are not allowed to manage the staff. If this is wrong you can contact your park owner.');
				}
				if(!existPark($park)) {
					header('Location: index.php');
				}
				if(getParkowner($park) == $id) {
					header('Location: park.php?id='.$park.'&warning=The settings of the park owner cant be changed for safety reasons.');
				}
			}
			else {
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
		<title>MineThemepark | Staff Manage</title>
		<style type="text/css">
		body {
			background: url(<?php echo getParkbackground($park); ?>);
			background-attachment: fixed;
			background-size: cover;
			background-repeat: no-repeat;
			position: relative;
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
				<div class="col-sm-9">
				<?php include('inc/alert.php'); ?>
					<div class="box-login" >
						<h5 style="margin-left: 5%;"><a href="park.php?id=<?php echo $park; ?>" class="park-link"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</strong></a></h5>
					</div>
				
					<div class="box-login" >
						<div style="margin-left: 5%; margin-right: 5%;">
							<div class="media">
								<div class="media-left">
									<a href="users.php?id=<?php echo $id; ?>"><img src="https://minotar.net/avatar/<?php echo getMinecraft($id); ?>" class="media-object img-circle" style="width: 60px"></a>
								</div>
								<div class="media-body">
									<h5 class="media-heading"><a href="users.php?id=<?php echo $id; ?>" class="park-link"><strong><?php echo getFirstname($id); ?> <?php echo getFamilyname($id); ?></strong></a> <?php echo getParkRank($id, $park); ?></h5>
									<h4 style="margin-top: 30px;"><strong>Permission Management</strong></h4>
									<center><hr style="width: 100%;"></center>
									<div class="row" style="margin-top: 15px;">
<?php 
						if(canManageParkStaff($_SESSION['id'], $park)) {
							
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `parks_staff` WHERE `user_id`='".$id."' AND `park_id`='".$park."'";
							$result = connection()->query($sql);
							if($result->num_rows > 0){
								while($row = $result->fetch_assoc())
								{
									/* Staff Panel */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Manage/Write Posts</strong>
												<h4>';
										if($row['can_write_post'] == '1'){
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_write_post&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_write_post&data=1"><span class="label label-success">Activate</span></a>';
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
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_manage_staff&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_manage_staff&data=1"><span class="label label-success">Activate</span></a>';
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
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_manage_comments&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_manage_comments&data=1"><span class="label label-success">Activate</span></a>';
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
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_manage_settings&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_manage_settings&data=1"><span class="label label-success">Activate</span></a>';
										}
									echo '		</h4></center>
											</div>
										  </div>';
									
									/* Manage Applys */
									echo '<div class="col-sm-4">
											<div class="well">
												<center><strong>Manage Applys</strong>
												<h4>';
										if($row['can_manage_applys'] == '1'){
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_manage_applys&data=0"><span class="label label-danger">Disable</span></a>';
										}
										else{
											echo '<a href="core/park-staff-perms.php?id='.$id.'&park='.$park.'&perm=can_manage_applys&data=1"><span class="label label-success">Activate</span></a>';
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
									<div class="row">
										<label class="control-label col-sm-3">Current rank:</label>
										<div class="col-sm-8">
											<?php echo getParkRank($id, $park); ?>
										</div>
									</div>
									<form id="parkrank" class="form-horizontal" method="GET">
									<div class="form-group">
										<div class="row">
											<label class="control-label col-sm-3">Rank:</label>
											<div class="col-sm-8">
												<input type="hidden" id="user_id" value="<?php echo $id; ?>">
												<input type="hidden" id="park_id" value="<?php echo $park; ?>">
												<input name="rank" class="form-control" value="<?php echo getParkRankText($id, $park); ?>" id="rank" placeholder="Rank" type="text" / required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<label class="control-label col-sm-3">Description:</label>
											<div class="col-sm-8">
												<textarea rows="4" cols="50" name="Description" class="form-control" id="description" placeholder="Apply body" type="text"><?php echo getStaffDescription($id, $park); ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-8">
												<button type="submit" class="btn btn-danger">Save</button>
											</div>
										</div>
									</div>
									</form>
<script>
$('#parkrank').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/change-park-rank.php",
        data: {user_id: " "+$('#user_id').val(), park_id: " "+$('#park_id').val(), rank: " "+$('#rank').val(), description: " "+$('#description').val()},
        success: function(data){
            if(data === 'change_rank_success'){
                document.location.href = 'park-staff.php?id=<?php echo $id; ?>&park=<?php echo $park; ?>&success=Rank successfully changed.';
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
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>