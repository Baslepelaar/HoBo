<?php
/**
* Copyright (c) 2017 MineThemepark
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
		
		if(!$online) {
				header('Location: index.php');
		}
		else {
			if(!empty($_GET['id'])) {
				if(!canManageParkPosts($_SESSION['id'], $id)) {
					header('Location: park.php?id='.$id.'&warning=You are not allowed to write a post. If this is wrong you can contact your park owner.');
				}
				if(!existPark($id)) {
					header('Location: index.php');
				}
			}
			else {
				header('Location: index.php');
			}
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
				<div class="box-login" >
					<h4 style="margin-left: 5%;"><strong>Text design</strong></h4>
					<center><hr style="width: 90%;"></center>
					<div style="margin-left: 5%; margin-right: 5%;">
						<p>&lt;i&gt;<i>Italic text...</i>&lt;/i&gt;</p>
						<p>&lt;strong&gt;<strong>Bold text...</strong>&lt;/strong&gt;</p>
						<p>&lt;del&gt;<del>Deleted text</del>...&lt;/del&gt;</p>
						<p>&lt;u&gt;<u>Underlined text...</u>&lt;/u&gt;</p>
						<p>&lt;h1&gt;Heading text size 1 to 5&lt;/h1&gt;</p>
						
					</div>
				</div>
					<?php include('inc/sidebar-left.php'); ?>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					<div class="box-login" >
						<h5 style="margin-left: 5%;"><a href="park.php?id=<?php echo $id; ?>" class="park-link"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</strong></a></h5>
					</div>
					<div class="box-login" >
						<h4 style="margin-left: 5%;"><strong>Write Post</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
							<form id="addpost" class="form-horizontal" method="GET">
							<div class="form-group">
								<label class="control-label col-sm-3">Post Title:</label>
								<div class="col-sm-8">
									<input type="hidden" id="ap_park_id" value="<?php echo $id; ?>">
									<input name="Title" class="form-control" placeholder="Post Title" id="ad_title" type="text" / required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Post Title:</label>
								<div class="col-sm-8">
									<textarea rows="16" cols="50" name="Body" class="form-control" id="ap_body" placeholder="Post body..." type="text" required></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Post banner URL:</label>
								<div class="col-sm-8">
									<input name="Banner" class="form-control" placeholder="Banner image URL" id="ap_poster" type="text" / required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3">Post header URL:</label>
								<div class="col-sm-8">
									<input name="Header" class="form-control" placeholder="Header image URL" id="ap_header" type="text" / required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-8">
									<button type="submit" class="btn btn-danger">Post</button>
								</div>
							</div>
							</form>
<script>
$('#addpost').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/app-park-post.php",
        data: {park_id: " "+$('#ap_park_id').val(), title: " "+$('#ap_title').val(), body: " "+$('#ap_body').val(), poster: " "+$('#ap_poster').val(), header: " "+$('#ap_header').val()},
        success: function(data){
            if(data === 'add-park-post-success'){
                document.location.href = '?id=<?php echo $id; ?>&success=You successfully upload a new post.';
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