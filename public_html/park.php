<?php
/**
* Copyright (c) 2017 Netixy Development
*/

		/* Background */
		
		$bg = array('bg-01.png', 'bg-02.png', 'bg-03.png', 'bg-04.png', );

		$i = rand(0, count($bg)-1);
		$selectedBg = "$bg[$i]";
		
		$id = $_GET['id'];
		$apply = $_GET['apply'];
		
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
		if(!existPark($id)) {
			header('Location: index.php');
		}
		if(isset($_REQUEST['follow'])) {
			if(isset($_SESSION['id'])) {
				followPark($_SESSION['id'], $id);
				header('Location: ?id='.$id.'&success=You are now following this park.');
				exit;
			}
		}
		if(isset($_REQUEST['unfollow'])) {
			if(isset($_SESSION['id'])) {
				unfollowPark($_SESSION['id'], $id);
				header('Location: ?id='.$id.'&success=You unfollowed this park.');
				exit;
			}
		}
		
		$status = json_decode(file_get_contents('https://api.mcsrvstat.us/1/'.getParkip($id).''));
		$offline = $status->offline;
		if(!$offline){
			$online_players = $status->players->online;
			$max = $status->players->max;
		}
		
		if($online) {
			if(isset($_GET['apply'])) {
			
				$applypark = getParkidFromApply($apply);
			
				if(canManageParkApply($_SESSION['id'], $applypark)) {
					include('inc/openupdatemodal.php');
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
		<title>MineThemepark | Park</title>
		<style type="text/css">
		body {
			background: url(<?php echo getParkbackground($id); ?>);
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
			<div style="height: 300px; background-image: url(<?php echo getParkheader($id); ?>); background-repeat: no-repeat; background-size: cover; background-position: center center;">
			</div>

			<div class="row">
				<div class="col-sm-3">
					<div class="box-login">
						<center><img src="<?php echo getParklogo($id); ?>" class="img-circle" height="85p" width="85px">
						<h4 style="color: #b90303;"><strong><?php echo getParkname($id); ?></strong></h4>
						<p><?php echo countFollowers($id); ?> followers<p>
<?php					
						if($online) {
							if(isFollowing($_SESSION['id'], $id)){
								echo '<h4><a href="?id='.$id.'&unfollow"><span class="label label-danger">Unfollow</span></a></h4>';
							}
							else {
								echo '<h4><a href="?id='.$id.'&follow"><span class="label label-success">Follow</span></a></h4>';
							}
						}
?>
						</center>
						<p style="margin-left: 20px; margin-right: 20px;"><?php echo getParkdescription($id); ?></p>
						<div style="margin-left: 20px; margin-top: 25px; margin-right: 5px;">
							<h4><i class="fa fa-map-marker" aria-hidden="true"></i> <span style="font-size: 15px; color: #b90303;"><?php echo getParkip($id); ?>
<?php						if(!$offline){
								echo ' <span class="label label-success">'.$online_players.' / '.$max.'</span>';
							}
							else {
								echo ' <span class="label label-danger">Server Offline</span>';
							}
?>							</span></h4>
							<div class="row">
<?php
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `parks` WHERE `id`='".$id."'";
							$result = connection()->query($sql);
							
							while($row = $result->fetch_assoc())
							{
								echo '<div class="col-sm-12"><h4><i class="fa fa-user" aria-hidden="true"></i> <span style="font-size: 15px;">Owner: <a href="users.php?id='.$row['owner'].'" style="color: #b90303;">'.getFirstName($row['owner']).' '.getFamilyName($row['owner']).'</a></span></h4></div>';
									
									if($row['email'] != '') {
										echo '<div class="col-sm-12"><h4><i class="fa fa-envelope-o" aria-hidden="true"></i> <span style="font-size: 15px; color: #b90303;"> <a href="mailto:'.$row['email'].'?SUBJECT=Support" style="color: #b90303;">Email us for support</a></h4></div>';
									}
									
									if($row['website'] != '') {
										echo '<div class="col-sm-6"><h4><i class="fa fa-globe" aria-hidden="true"></i> <span style="font-size: 15px; color: #b90303;"> <a href="'.$row['website'].'" target="_blank" style="color: #b90303;">Website</a></h4></div>';
									}
								echo '<div class="col-sm-6"><h4><i class="fa fa-twitter" aria-hidden="true"></i> <span style="font-size: 15px; color: #b90303;"> <a href="'.$row['twitter'].'" target="_blank" style="color: #b90303;">Twitter</a></h4></div>';
								
									if($row['facebook'] != '') {
										echo '<div class="col-sm-6"><h4><i class="fa fa-facebook" aria-hidden="true"></i> <span style="font-size: 15px; color: #b90303;"> <a href="'.$row['facebook'].'" target="_blank" style="color: #b90303;">Facebook</a></h4></div>';
									}
									if($row['youtube'] != '') {
										echo '<div class="col-sm-6"><h4><i class="fa fa-youtube-play" aria-hidden="true"></i> <span style="font-size: 15px; color: #b90303;"> <a href="'.$row['youtube'].'" target="_blank" style="color: #b90303;">YouTube</a></h4></div>';
									}
									if($row['instagram'] != '') {
										echo '<div class="col-sm-6"><h4><i class="fa fa-instagram" aria-hidden="true"></i> <span style="font-size: 15px; color: #b90303;"> <a href="'.$row['instagram'].'" target="_blank" style="color: #b90303;">Instagram</a></h4></div>';
									}
									if($row['snapchat'] != '') {
										echo '<div class="col-sm-6"><h4><i class="fa fa-snapchat-ghost" aria-hidden="true"></i> <span style="font-size: 15px; color: #b90303;"> <a href="'.$row['snapchat'].'" target="_blank" style="color: #b90303;">Snapchat</a></h4></div>';
									}
							}
?>							</div>
						</div>
					</div>
					<div class="box-login">
						<ul class="nav nav-pills nav-stacked">
							<li class="active"><a data-toggle="tab" href="#home">Park Page</a></li>
							<li><a data-toggle="tab" href="#staff">Staff</a></li>
							<li><a data-toggle="tab" href="#apply">Apply</a></li>
<?php
							if(isParkStafffromID($_SESSION['id'], $id)) {
								echo '<li><a data-toggle="tab" href="#staff-panel">Staff Panel</a></li>';
							}
?>
						</ul>
					</div>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">	
<?php
				require_once('core/ini.php');
					
					$sql 	= "SELECT * FROM `posts` WHERE `park_id`='".$id."' AND `deleted`='0' AND `reviewed`='1' ORDER BY ID DESC";
					$result = connection()->query($sql);
					if($result->num_rows > 0){
	
						if($online) {
					
							while($row = $result->fetch_assoc())
							{
			
							$parkname = getParkname($row['park_id']);
							$logo = getParklogo($row['park_id']);
							echo '<div class="box">
									<div class="media">
										<div class="media-left">
											<a href="park.php?id='.$row['park_id'].'"><img src="'.$logo.'" class="media-object img-circle" style="width:60px"></a>
										</div>
										<div class="media-body">
											<h5 class="media-heading"><a href="park.php?id='.$row['park_id'].'" class="park-link"><strong>'.$parkname.'</strong></a><span> -  '.$row['posted_on'].'</span></h5>
											<a href="article.php?id='.$row['id'].'" class="article-link">
											<h4>'.$row['post_title'].'</h4>
											<img src="'.$row['post_poster'].'" class="img-rounded" width="100%">
											</a>
											<h4>';
								if(isLikingPost($_SESSION['id'], $row['id']))
								{
									echo '<a href="article.php?id='.$row['id'].'&unlike" class="like"><i class="fa fa-heart" aria-hidden="true"></i> <strong>'.countLikesPost($row['id']).'</strong></a>';
								}
								else {
									echo '<a href="article.php?id='.$row['id'].'&like" class="like"><i class="fa fa-heart-o" aria-hidden="true"></i> <strong>'.countLikesPost($row['id']).'</strong></a>';
								}
								if(hasCommentPost($_SESSION['id'], $row['id']))
								{
									echo '<a href="article.php?id='.$row['id'].'" class="comment"><i class="fa fa-comment" aria-hidden="true"></i> <strong>'.countCommentsPost($row['id']).'</strong></a>';
								}
								else {
									echo '<a href="article.php?id='.$row['id'].'" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> <strong>'.countCommentsPost($row['id']).'</strong></a>';
								}
							echo '			</h4>
										</div>
									</div>
								</div>';
							}
						}
						else {
							
							while($row = $result->fetch_assoc())
							{
								echo'<div class="box">
										<div class="media">
											<div class="media-left">
												<a href="park.php?id='.$row['park_id'].'"><img src="'.getParklogo($row['park_id']).'" class="media-object img-circle" style="width:60px"></a>
											</div>
											<div class="media-body">
												<h5 class="media-heading"><a href="park.php?id='.$row['park_id'].'" class="park-link"><strong>'.getParkname($row['park_id']).'</strong></a><span> -  '.$row['posted_on'].'</span></h5>
												<a href="article.php?id='.$row['id'].'" class="article-link">
												<h4>'.$row['post_title'].'</h4>
												<img src="'.$row['post_poster'].'" class="img-rounded" width="100%">
												</a>
												<h4><a href="?warning=You can only like a post if you are logged in." class="like"><i class="fa fa-heart-o" aria-hidden="true"></i> <strong>'.countLikesPost($row['id']).'</strong></a>
												<a href="?warning=You can only comment at a post if you are logged in." class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> <strong>'.countCommentsPost($row['id']).'</strong></a></h4>
											</div>
										</div>
									</div>';
							}
						}
					}
					else {
						echo '<div class="box-login">
								<h5>This park has no posts uploaded.</h5>
							  </div>';
					}
?>						
						</div>
						<div id="staff" class="tab-pane fade">
							<div class="box-login">
								<p>Here you can find our park staff...</p>
							</div>
							<div class="row" style="margin-top: 5px;">
<?php
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `parks_staff` WHERE `park_id`='".$id."' ORDER BY ID";
							$result = connection()->query($sql);
	
							while($row = $result->fetch_assoc())
							{	
								echo'<div class="col-sm-6">
										<a href="users.php?id='.$row['user_id'].'" class="park-link">
											<div class="thumbnail text-center">
												<div style="max-height: 100px; background-size: contain; background: url('.getParkheader($id).');">
													<img src="https://minotar.net/avatar/'.getMinecraft($row['user_id']).'" class="img-circle" height="75p" width="75" style="margin-top: 60px; border-radius: 90%; border: 3px solid white;">
												</div>
												<p style="margin-top: 40px;"><strong class="park-link">'.getFirstname($row['user_id']).' '.getFamilyname($row['user_id']).'</strong></p>
												<p>';
								if($row['rank'] == 'Park Owner') {
									echo '<span class="label label-danger">Owner</span></p>';
								}
								else {
									echo '<span class="label label-info">'.$row['rank'].'</span></p>';
								}
								if($row['description'] != '') {
									echo '<p style="margin-left: 10px; margin-right: 10px;">'.$row['description'].'</p>';
								}
								echo '		</div>
										</a>
									</div>';
							}
?>							</div>
						</div>
						<div id="apply" class="tab-pane fade">
							<div class="box-login" style="margin-bottom: 5px;">
								<p>You're looking for applications for this park? You can find them below.</p>
							</div>
							<div class="row">
<?php
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `applys` WHERE `park_id`='".$id."' ORDER BY ID DESC";
							$result = connection()->query($sql);
							if($result->num_rows > 0) {
								while($row = $result->fetch_assoc())
								{	
									echo'<div class="col-sm-12">
											<a href="applys.php?id='.$row['id'].'" style="color: #5b5b5b; text-decoration: none;">
											<div class="box">
												<h4 style="margin-left: 5%;"><strong>'.$row['apply_title'].'</strong> - '.$row['posted_on'].'</h4>
												<center><hr style="width: 90%;"></center>
												<p style="margin-left: 5%;">'.$row['apply_body'].'</p>
												<h4><a href="applys.php?id='.$row['id'].'" class="comment"><i class="fa fa-comments" aria-hidden="true"></i> <strong>'.countApplyReplys($row['id']).'</strong></a></h4>
											</div>
											</a>
										</div>';
								}
							}
							else {
								echo '<div class="col-sm-12">
										<div class="box-login">
											<p>This park hasn&rsquo;t any applications registered, you can look for others <a href="applys.php" class="park-link">here</a></p>
										</div>
									  </div>';
							}			
?>							</div>
						</div>
<?php				if($online) {
						if(isParkStafffromID($_SESSION['id'], $id)) {
?>
		<!-- Add Staff Modal -->
		<div class="modal fade" id="staffModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><strong>Add Staff</strong></h4>
					</div>
					<form id="addstaff" class="form-horizontal" method="GET">
					<div class="modal-body">
						<div style="margin-left: 5%; margin-right: 5%;">
							<div class="form-group">
								<div class="row">
									<label class="control-label col-sm-3">Email:</label>
									<div class="col-sm-8">
										<input type="hidden" id="staff_park_id" value="<?php echo $id; ?>">
										<input name="Email" class="form-control" id="staff_email" placeholder="Email" type="email" / required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="control-label col-sm-3">Rank:</label>
									<div class="col-sm-8">
										<input name="rank" class="form-control" id="staff_rank" placeholder="Rank" type="text" / required>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger">Add</button>
					</div>
					</form>
				</div>
			</div>
		</div>
		
<script>
$('#addstaff').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/park_add_staff.php",
        data: {email: " "+$('#staff_email').val(), rank: " "+$('#staff_rank').val(), park: " "+$('#staff_park_id').val()},
        success: function(data){
            if(data === 'park_add_staff_success'){
                document.location.href = 'park.php?id=<?php echo $id; ?>&success=Staff member added, you can now give him permissions.';
            }
			else {
				document.location.href = data;
			}
        }
    });
});
</script>
		<!-- Add Staff Modal End -->
		
		<!-- Add Apply Modal -->
		<div class="modal fade" id="applyModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><strong>Add Job offer</strong></h4>
					</div>
					<form id="addapply" class="form-horizontal" method="GET">
					<div class="modal-body">
						<div style="margin-left: 5%; margin-right: 5%;">
							<div class="form-group">
								<div class="row">
									<label class="control-label col-sm-3">Type:</label>
									<div class="col-sm-8">
										<input type="hidden" id="apply_park_id" value="<?php echo $id; ?>">
										<input name="Title" class="form-control" id="apply_title" placeholder="Apply type" type="text" / required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="control-label col-sm-3">Body:</label>
									<div class="col-sm-8">
										<textarea rows="4" cols="50" name="Body" class="form-control" id="apply_body" placeholder="Apply body" type="text" required></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger">Add</button>
					</div>
					</form>
				</div>
			</div>
		</div>
		
<script>
$('#addapply').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/add_job_offer.php",
        data: {title: " "+$('#apply_title').val(), body: " "+$('#apply_body').val(), park: " "+$('#apply_park_id').val()},
        success: function(data){
            if(data === 'add_apply_success'){
                document.location.href = 'park.php?id=<?php echo $id; ?>&success=Job offer successfully added.';
            }
			else {
				document.location.href = data;
			}
        }
    });
});
</script>
		<!-- Add Apply Modal End -->
		
		<!-- Edit Apply Modal -->
		<div class="modal fade" id="EditapplyModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><strong>Edit Job offer</strong></h4>
					</div>
					<form id="updateapply" class="form-horizontal" method="GET">
					<div class="modal-body">
						<div style="margin-left: 5%; margin-right: 5%;">
							<div class="form-group">
								<div class="row">
									<label class="control-label col-sm-3">Type:</label>
									<div class="col-sm-8">
										<input type="hidden" id="uapply_id" value="<?php echo $apply; ?>">
										<input name="Title" class="form-control" id="uapply_title" value="<?php echo getApplyTitle($apply); ?>" placeholder="Apply type" type="text" / required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<label class="control-label col-sm-3">Body:</label>
									<div class="col-sm-8">
										<textarea rows="4" cols="50" name="Body" class="form-control" id="uapply_body" placeholder="Apply body" type="text" required><?php echo getApplyBody($apply); ?></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-danger">Save</button>
					</div>
					</form>
				</div>
			</div>
		</div>
		
<script>
$('#updateapply').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/update-park-apply.php",
        data: {id: " "+$('#uapply_id').val(), title: " "+$('#uapply_title').val(), body: " "+$('#uapply_body').val()},
        success: function(data){
            if(data === 'update_apply_success'){
                document.location.href = 'park.php?id=<?php echo $id; ?>&success=Job offer successfully updated.';
            }
			else {
				document.location.href = data;
			}
        }
    });
});
</script>
		<!-- Edit Apply Modal End -->


						<div id="staff-panel" class="tab-pane fade">
							<div class="box-login" >
								<h4 style="margin-left: 5%;"><strong>Staff Managing</strong>
<?php
						if(canManageParkStaff($_SESSION['id'], $id)) {
							echo '<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#staffModal" style="margin-left: 20px;">Add staff</button>';
						}
?>								</h4>
								<center><hr style="width: 90%;"></center>
								<div style="margin-left: 5%; margin-right: 5%;">
<?php
						if(canManageParkStaff($_SESSION['id'], $id)) {
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `parks_staff` WHERE `park_id`='".$id."' ORDER BY id";
							$result = connection()->query($sql);
							if($result->num_rows > 0){
								
								echo '<table class="table table-striped">
										<thead>
											<tr>
												<th>Name</th>
												<th>Minecraft</th>
												<th>Rank</th>
												<th>Manage</th>
											</tr>
										</thead>
										<tbody>';	
								while($row = $result->fetch_assoc())
								{
									echo '<tr>
											<td><a href="users.php?id='.$row['user_id'].'">'.getFirstname($row['user_id']).' '.getFamilyname($row['user_id']).'</a></td>
											<td><img src="https://minotar.net/avatar/'.getMinecraft($row['user_id']).'" height="20px" /> '.getMinecraft($row['user_id']).'</td>
											<td>';
									if($row['rank'] == 'Park Owner') {
										echo '<span class="label label-danger">Owner</span>';
									}
									else {
										echo '<span class="label label-info">'.$row['rank'].'</span>';
									}		
									echo '	</td>
											<td><a href="park-staff.php?id='.$row['user_id'].'&park='.$row['park_id'].'"><span class="label label-info">Manage Staff</span></a>';
											
									if($row['rank'] != 'Park Owner') {
										echo '<a href="core/park-staff-del-member.php?id='.$row['user_id'].'&park='.$row['park_id'].'" style="margin-left: 10px;"><span class="label label-danger">Delete</span></a>';
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
							echo '<h5>You are not allowed to manage staff. If this is wrong you can contact a site administrator.</h5>';
						}
?>						
								</div>
							</div>

							<div class="box-login" >
								<h4 style="margin-left: 5%;"><strong>Apply Managing</strong>
<?php
						if(canManageParkApply($_SESSION['id'], $id)) {
							echo '<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#applyModal" style="margin-left: 20px;">Add Job offer</button>';
						}
?>								</h4>
								<center><hr style="width: 90%;"></center>
								<div style="margin-left: 5%; margin-right: 5%;">
<?php
						if(canManageParkApply($_SESSION['id'], $id)) {
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `applys` WHERE `park_id`='".$id."' ORDER BY id";
							$result = connection()->query($sql);
							if($result->num_rows > 0){
								
								echo '<table class="table table-striped">
										<thead>
											<tr>
												<th>Title</th>
												<th>Reactions</th>
												<th>Posted On</th>
												<th>Manage</th>
											</tr>
										</thead>
										<tbody>';	
								while($row = $result->fetch_assoc())
								{
									echo '<tr>
											<td>'.$row['apply_title'].'';
									if($row['deleted'] == '1') {	
										echo ' <span class="label label-danger">Deleted</span>';
									}									
											
									echo '	</td>
											<td><p class="comment" style="margin-left: 5%;"><i class="fa fa-comments" aria-hidden="true"></i> <strong>'.countApplyReplys($row['id']).'</strong></p>';
									if(countApplyReplys($row['id']) != '0') {
										echo ' <a href=""><span class="label label-info">Read</span></a>';
									}
											
									echo '	</td>
											<td>'.$row['posted_on'].'</td>
											<td>';
									if($row['deleted'] == '1') {
										echo '<a href="core/apply-del-park.php?id='.$row['id'].'&data=0&park='.$id.'"><span class="label label-success">Post again</span></a>';
									}
									else {
										echo '<a href="park.php?id='.$id.'&apply='.$row['id'].'"><span class="label label-info">Edit</span></a> <a href="core/apply-del-park.php?id='.$row['id'].'&data=1&park='.$id.'"><span class="label label-danger">Delete</span></a>';
									}		
									echo '	</td>
										  </tr>';
								}
								echo '	</tbody>
									  </table>';
							}
							else{
								echo '<h5>There are no applys posted.</h5>';
							}
						}
						else{
							echo '<h5>You are not allowed to manage applys. If this is wrong you can contact a site administrator.</h5>';
						}
?>						
								</div>
							</div>
							<div class="box-login" >
								<h4 style="margin-left: 5%;"><strong>Park Settings</strong></h4>
								<center><hr style="width: 90%;"></center>
								<div style="margin-left: 5%; margin-right: 5%;">
<?php
								if(canManageParkSettings($_SESSION['id'], $id)) {
									echo '<h5>Manage the park settings... <a href="park-settings.php?id='.$id.'"><span class="label label-info">Click here</span></a></h5>
										  <h5>Manage park images... <a href="park-images.php?id='.$id.'"><span class="label label-info">Click here</span></a></h5>';
								}
								else{
									echo '<h5>You are not allowed to manage the park settings. If this is wrong you can contact your park owner.</h5>';
								}

?>
								</div>
							</div>
							<div class="box-login" >
						<h4 style="margin-left: 5%;"><strong>Posts</strong>
<?php
						if(canManageParkPosts($_SESSION['id'], $id)) {
							echo '<a href="add-post.php?id='.$id.'" style="margin-left: 20px;"><span class="btn btn-success btn-sm" >Write Post</span></a>';
						}
?>						</h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
<?php
						if(canManagePosts($_SESSION['id'])) {
							$sql 	= "SELECT * FROM `posts` WHERE `park_id`='".$id."' ORDER BY id DESC";
							$result = connection()->query($sql);
							if($result->num_rows > 0){
								echo '<table class="table table-striped">
										<thead>
											<tr>
												<th>Title</th>
												<th>Date</th>
												<th>Likes</th>
												<th>Comments</th>
												<th>Manage</th>
											</tr>
										</thead>
										<tbody>';
								while($row = $result->fetch_assoc())
								{
									echo '<tr>
											<td><a href="article.php?id='.$row['id'].'" class="park-link">'.$row['post_title'].'</a>';
										if($row['deleted'] == '1'){
											echo ' <span class="label label-danger">Deleted</span>';
										}
										if($row['reviewed'] == '0'){
											echo ' <span class="label label-warning">Not reviewed</span>';
										}
										if($row['reviewed'] == '2'){
											echo ' <span class="label label-danger">Rejected</span>';
										}
									echo '	</td>
											<td>'.$row['posted_on'].'</td>
											<td>'.countLikesPost($row['id']).'</td>
											<td>'.countCommentsPost($row['id']).'</td>
											<td>';
									if($row['deleted'] == '1'){
										echo '<a href="core/del-park-post.php?post='.$row['id'].'&park='.$id.'&data=0"><span class="label label-success">Post again</span></a>';
									}
									else {
										echo '<a href="core/del-park-post.php?post='.$row['id'].'&park='.$id.'&data=1"><span class="label label-danger">Delete</span></a>';
									}
									echo '	</td>
										  </tr>';
								}
								echo '	</tbody>
									  </table>';
							}
							else {
								echo '<h5>There are currently no posts uploaded.</h5>';
							}
						}
						else {
							echo '<h5>You are not allowed to manage posts. If this is wrong you can contact your park owner.</h5>';
						}
?>
						</div>
					</div>
					<div class="box-login" >
						<h4 style="margin-left: 5%;"><strong>Park API</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
							<h5>We offer parks to use our API. Show how many followers you have or get your uploaded background and more.<br>
								You can get almost all the info of your park in a JSON return.</h5>
							<div class="well">
								<h5>You can find your API file <a href="api.php?park=<?php echo $id; ?>"><span class="label label-info">here</span></a></h5>
							</div>
							<h5><strong>Usage:</strong></h5>
							<p>Your URL looks like <strong>http://minethemepark.com/api.php?id=<?php echo $id; ?></strong></p>
							If you do<strong> http://minethemepark.com/api.php?id=<?php echo $id; ?>&followers </strong>it will return only the followers count.</p>
							<ul>
								<li>&Name </li>
								<li>&IP </li>
								<li>&Description </li>
								<li>&Followers </li>
								<li>&Header </li>
								<li>&Background </li>
								<li>&Logo </li>
							</ul>
						</div>
					</div>
							
							
							
							
						</div>
<?php					}
					}
?>
					</div>
				</div>
				<div class="col-sm-3" style="margin-top: 5px;">
					<?php include('inc/sidebar.php'); ?>
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>