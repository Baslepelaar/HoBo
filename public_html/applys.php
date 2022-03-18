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
		
		$id = $_GET['id'];
		
		if(!empty($_GET['id'])) {
			if(!$online) {
				header('Location: applys.php?warning=You need to be logged in to apply for this job offer.');
			}
			if(!existApply($id)) {
				header('Location: index.php');
				exit;
			}
			if(isdeletedApply($id)) {
				header('Location: index.php');
			}
		}
		$park_id = getParkidFromApply($id);
		
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include('inc/header.php'); ?>
		<title>MineThemepark | Applys</title>
		<style type="text/css">
		body {
			background: url(inc/img/background/<?php echo $selectedBg; ?>);
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
<?php	if(empty($_GET['id'])) {
		/* Main Page */
?>			<div class="row">
				<div class="col-sm-3">
					<?php include('inc/sidebar-left.php'); ?>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					<div class="box-login">
							<p>Here you can find the newest vacancies of the parks...</p>
					</div>
					<div class="row">
						
<?php
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `applys` WHERE `deleted`='0' ORDER BY ID DESC LIMIT 30";
							$result = connection()->query($sql);
							if($result->num_rows > 0) {
								while($row = $result->fetch_assoc())
								{	
									echo'<div class="col-sm-12">
											
											<div class="box">
												<div class="media">
													<div class="media-left">
														<a href="park.php?id='.$row['park_id'].'"><img src="'.getParklogo($row['park_id']).'" class="media-object img-circle" style="width:60px"></a>
													</div>
													<div class="media-body">
														<h5 class="media-heading"><a href="park.php?id='.$row['park_id'].'" class="park-link"><strong>'.getParkname($row['park_id']).'</strong></a></h5>
														<a href="applys.php?id='.$row['id'].'" style="color: #5b5b5b; text-decoration: none;">
															<h5 style="margin-left: 5%;"><strong>'.$row['apply_title'].'</strong> - '.$row['posted_on'].'</h5>
															<p style="margin-left: 5%;">'.$row['apply_body'].'</p>
															<h4><a href="applys.php?id='.$row['id'].'" class="comment"><i class="fa fa-comments" aria-hidden="true"></i> <strong>'.countApplyReplys($row['id']).'</strong></a></h4>
														</a>
													</div>
												</div>
											</div>
										</div>';
								}
							}
							else {
								echo '<div class="col-sm-12">
										<div class="box-login">
											<p>There are currently no applys...</p>
										</div>
									  </div>';
							}			
?>					</div>
				</div>
				<div class="col-sm-3">
					<?php include('inc/sidebar.php'); ?>
				</div>
			</div>

<?php 	/* Main Page End */
		}
		else {
		/* Article */
?>
			<div class="row">
				<div class="col-sm-3">
					<div class="box-login">
						<center><img src="<?php echo getParklogo($park_id); ?>" class="img-circle" height="85p" width="85px">
						<h4 style="color: #b90303;"><strong><?php echo getParkname($park_id); ?></strong></h4></center>
					</div>
					<?php include('inc/sidebar-left.php'); ?>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
						<div class="row">
<?php
							require_once('core/ini.php');
							
							$sql 	= "SELECT * FROM `applys` WHERE `id`='".$id."'";
							$result = connection()->query($sql);
								while($row = $result->fetch_assoc())
								{	
									echo'<div class="col-sm-12" style="color: #5b5b5b;">
											<div class="box-login">
												<h4 style="margin-left: 5%;"><strong>'.$row['apply_title'].'</strong> - '.$row['posted_on'].'</h4>
												<center><hr style="width: 90%;"></center>
												<p style="margin-left: 5%;">'.$row['apply_body'].'</p>
												<h4 class="comment" style="margin-left: 5%;"><i class="fa fa-comments" aria-hidden="true"></i> <strong>'.countApplyReplys($row['id']).'</strong></h4>
											</div>
										</div>';
								}			
?>						</div>
						<div class="box-login">
							<h5 style="margin-left: 5%;"><strong>Apply for this vacancie</strong></h5>
							<center><hr style="width: 90%;"></center>
							<div style="margin-left: 5%; margin-right: 5%;">
								<form id="apply" class="form-horizontal" method="GET">
									<div class="form-group">
										<div class="row">
											<div class="form-group">
												<label class="control-label col-sm-3">About you*:</label>
												<div class="col-sm-8">
													<input type="hidden" id="apply_id" value="<?php echo $id; ?>">
													<input type="hidden" id="user_id" value="<?php echo $_SESSION['id']; ?>">
													<textarea rows="4" cols="50" name="About" class="form-control" id="ar_about" placeholder="About you..." type="text" required></textarea >
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-3">Why us*:</label>
												<div class="col-sm-8">
													<textarea rows="4" cols="50" name="Why" class="form-control" id="ar_why" placeholder="Why us..." type="text" required></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-3">Contact:</label>
												<div class="col-sm-4">
													<input name="Discord" class="form-control" id="ar_discord" placeholder="Discord" type="text" />
												</div>
												<div class="col-sm-4">
													<input name="Skype" class="form-control" id="ar_skype" placeholder="Skype" type="text" />
												</div>
											</div>
											<div class="col-sm-offset-3 col-sm-9">
												<button type="submit" class="btn btn-danger">
												Apply
												</button>
											</div>
										</div>
									</div>
								</form>
<script>
$('#apply').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/add_apply.php",
        data: {apply_id: " "+$('#apply_id').val(), user_id: " "+$('#user_id').val(), about: " "+$('#ar_about').val(), why: " "+$('#ar_why').val(), discord: " "+$('#ar_discord').val(), skype: " "+$('#ar_skype').val()},
        success: function(data){
            if(data === 'apply_reply_success'){
                document.location.href = '?id=<?php echo $id ?>&success=You successfully applyed for this vacancie.';
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

<?php
/* Article End */
		}
?>		
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>