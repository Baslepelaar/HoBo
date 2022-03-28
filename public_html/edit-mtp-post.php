<?php
/**
* Copyright (c) 2017 MineThemepark
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
			if(!canWritePost($_SESSION['id'])) {
				header('Location: index.php');
			}
		}
		
		$user_ip = get_client_ip();
		addIPtoList($user_ip);
		if(isIPBanned($user_ip)){
			header('Location: https://google.com');
		}
		
		$post = $_GET['post'];
		
?>
<!DOCTYPE html>
<html>
	<head>
		
		<?php include('inc/header.php'); ?>
		<title>MineThemepark | Edit Post</title>
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
						<center><h4><strong>Live Chat</strong></h4></center>
						<center><hr style="width: 90%;"></center>
						
						<center><h4><a href="https://dashboard.tawk.to" target="_blank" <span class="label label-info">Dashboard</span></a></h4></center>
					</div>
						
						
				
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
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					<div class="box-login" >
						<h5 style="margin-left: 5%;"><a href="staff-panel.php" class="park-link"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</strong></a></h5>
					</div>
					<div class="box-login" >
						<h4 style="margin-left: 5%;"><strong>Edit Post</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
						
							<form id="updatemtp" class="form-horizontal" method="GET">
								<div class="form-group">
									<div class="row">
										<label class="control-label col-sm-3">Title:</label>
										<div class="col-sm-8">
											<input type="hidden" id="post_id" value="<?php echo $post; ?>">
											<input name="Title" class="form-control" id="title" value="<?php echo getMTPtitle($post); ?>" placeholder="Post title" type="text" / required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<label class="control-label col-sm-3">Body:</label>
										<div class="col-sm-8">
											<textarea rows="25" cols="50" name="Body" class="form-control" id="article" placeholder="Article..." type="text" required><?php echo getMTPbody($post); ?></textarea>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-8">
										<button type="submit" class="btn btn-danger">Save</button>
									</div>
								</div>
							</form>
<script>
$('#updatemtp').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/update-mtp-post.php",
        data: {post_id: " "+$('#post_id').val(), title: " "+$('#title').val(), body: " "+$('#article').val()},
        success: function(data){
            if(data === 'update-mtp-post-success'){
                document.location.href = 'staff-panel.php?success=You successfully edited the post.';
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
					<div class="box-login" >
					<h4 style="margin-left: 5%;"><strong>Text design</strong></h4>
					<center><hr style="width: 90%;"></center>
					<div style="margin-left: 5%; margin-right: 5%;">
						<p>&lt;i&gt;<i>Italic text...</i>&lt;/i&gt;</p>
						<p>&lt;strong&gt;<strong>Bold text...</strong>&lt;/strong&gt;</p>
						<p>&lt;del&gt;<del>Deleted text</del>...&lt;/del&gt;</p>
						<p>&lt;u&gt;<u>Underlined text...</u>&lt;/u&gt;</p>
						<p>&lt;a href="URL"&gt;This will change in a link&lt;/a&gt;</p>
						<p>&lt;img src="URL"&gt;This will display an image.</p>
						<p>&lt;hr&gt;This will display a horizontal line.</p>
						<p>&lt;h1&gt;Heading text size 1 to 5&lt;/h1&gt;</p>
						
					</div>
				</div>
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>