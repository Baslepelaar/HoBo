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
		
		if(!$online) {
				header('Location: index.php');
		}
		else {
			if(!empty($_GET['id'])) {
				if(!canManageParkSettings($_SESSION['id'], $id)) {
					header('Location: park.php?id='.$id.'&warning=You are not allowed to manage the park settings. If this is wrong you can contact your park owner.');
				}
				if(!existPark($id)) {
					header('Location: index.php');
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
			<div class="row">
				<div class="col-sm-3">
					<?php include('inc/sidebar-left.php'); ?>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					<div class="box-login" >
						<h5 style="margin-left: 5%;"><a href="park.php?id=<?php echo $id; ?>" class="park-link"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</strong></a></h5>
					</div>
					<div class="box-login" >
						<h4 style="margin-left: 5%;"><strong>General settings</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
							<form id="generalsettings" class="form-horizontal" method="GET">
							<div class="form-group">
								<label class="control-label col-sm-3">Park name:</label>
								<div class="col-sm-8">
									<input type="hidden" id="gps_park_id" value="<?php echo $id; ?>">
									<input name="Name" class="form-control" value="<?php echo getParkname($id); ?>" placeholder="Park name" type="text" / disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Ip adress:</label>
								<div class="col-sm-8">
									<input name="Ip" class="form-control" id="gps_ip" value="<?php echo getParkip($id); ?>" placeholder="Ip adress" type="text" / required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Park description:</label>
								<div class="col-sm-8">
<?php		
								if(getParkdescription($id) != '') {
									echo '<textarea rows="4" cols="50" name="Description" class="form-control" id="gps_description" placeholder="Description..." type="text">'.getParkdescription($id).'</textarea>';
								}
								else {
									echo '<textarea rows="4" cols="50" name="Description" class="form-control" id="gps_description" placeholder="Description..." type="text"></textarea>';
								}
?>								
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Support email:</label>
								<div class="col-sm-8">
<?php		
								if(getParkemail($id) != '') {
									echo '<input name="Email" class="form-control" id="gps_email" value="'.getParkemail($id).'" placeholder="Support email" type="text" / >';
								}
								else {
									echo '<input name="Email" class="form-control" id="gps_email" placeholder="Support email" type="text" / >';
								}
?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Twitter:</label>
								<div class="col-sm-8">
									<input name="Twitter" class="form-control" id="gps_twitter" value="<?php echo getParktwitter($id); ?>" placeholder="Twitter" type="text" / required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Website:</label>
								<div class="col-sm-8">
<?php		
								if(getParkwebsite($id) != '') {
									echo '<input name="Website" class="form-control" id="gps_website" value="'.getParkwebsite($id).'" placeholder="Website" type="text" / >';
								}
								else {
									echo '<input name="Website" class="form-control" id="gps_website" placeholder="Website" type="text" / >';
								}
?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Facebook:</label>
								<div class="col-sm-8">
<?php		
								if(getParkfacebook($id) != '') {
									echo '<input name="Facebook" class="form-control" id="gps_facebook" value="'.getParkfacebook($id).'" placeholder="Facebook" type="text" / >';
								}
								else {
									echo '<input name="Facebook" class="form-control" id="gps_facebook" placeholder="Facebook" type="text" / >';
								}
?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Instagram:</label>
								<div class="col-sm-8">
<?php		
								if(getParkinstagram($id) != '') {
									echo '<input name="Instagram" class="form-control" id="gps_instagram" value="'.getParkinstagram($id).'" placeholder="Instagram" type="text" / >';
								}
								else {
									echo '<input name="Instagram" class="form-control" id="gps_instagram" placeholder="Instagram" type="text" / >';
								}
?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">YouTube:</label>
								<div class="col-sm-8">
<?php		
								if(getParkyoutube($id) != '') {
									echo '<input name="YouTube" class="form-control" id="gps_youtube" value="'.getParkyoutube($id).'" placeholder="YouTube" type="text" / >';
								}
								else {
									echo '<input name="YouTube" class="form-control" id="gps_youtube" placeholder="YouTube" type="text" / >';
								}
?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Snapchat:</label>
								<div class="col-sm-8">
<?php		
								if(getParksnapchat($id) != '') {
									echo '<input name="Snapchat" class="form-control" id="gps_snapchat" value="'.getParksnapchat($id).'" placeholder="Snapchat" type="text" / >';
								}
								else {
									echo '<input name="Snapchat" class="form-control" id="gps_snapchat" placeholder="Snapchat" type="text" / >';
								}
?>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-8">
									<button type="submit" class="btn btn-danger">Save</button>
								</div>
							</div>
							</form>
<script>
$('#generalsettings').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/update-park-settings.php",
        data: {park_id: " "+$('#gps_park_id').val(), ip: " "+$('#gps_ip').val(), description: " "+$('#gps_description').val(), email: " "+$('#gps_email').val(), twitter: " "+$('#gps_twitter').val(), website: " "+$('#gps_website').val(), facebook: " "+$('#gps_facebook').val(), instagram: " "+$('#gps_instagram').val(), youtube: " "+$('#gps_youtube').val(), snapchat: " "+$('#gps_snapchat').val()},
        success: function(data){
            if(data === 'update-park-settings-success'){
                document.location.href = '?id=<?php echo $id; ?>&success=You successfully changed the settings of your park.';
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
				<div class="col-sm-3" style="margin-top: 5px;">
					<?php include('inc/sidebar.php'); ?>
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>