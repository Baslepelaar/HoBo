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
			if(!existMTP($id)) {
				header('Location: index.php');
				exit;
			}
			if(isset($_REQUEST['like'])) {
				if(isset($_SESSION['id'])) {
					likeMTp($_SESSION['id'], $id);
					header('Location: minethemepark.php?id='.$id.'&success=You liked this post.');
					exit;
				}
			}
			if(isset($_REQUEST['unlike'])) {
				if(isset($_SESSION['id'])) {
					unlikeMTP($_SESSION['id'], $id);
					header('Location: minethemepark.php?id='.$id.'&success=You unliked this post.');
					exit;
				}
			}
			if(isdeletedMTP($id)) {
				if(!canManagePosts($_SESSION['id'])) {
					header('Location: index.php');
				}
			}
		}
?>
<!DOCTYPE html>
<html>
	<head>
		
		<?php include('inc/header.php'); ?>
		<title>MineThemepark | Our Page</title>
		<style type="text/css">
		body {
			background: url(https://minethemepark.com/inc/img/background/<?php echo $selectedBg; ?>);
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
?>
			<div class="row">
				<div class="col-sm-3">
					<?php include('inc/sidebar-left.php'); ?>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					
<?php 
					require_once('core/ini.php');
					
						$sql 	= "SELECT * FROM `minethemepark_posts` WHERE `deleted`='0' ORDER BY ID DESC";
						$result = connection()->query($sql);
	
					while($row = $result->fetch_assoc())
					{
			
					echo'			<div class="box">
										<div class="media">
											<div class="media-left">
												<img src="https://minethemepark.com/inc/img/favicon.png" class="media-object img-circle" style="width:60px">
											</div>
											<div class="media-body">
												<h5 class="media-heading"><strong>MineThemepark</strong><span> -  '.$row['posted_on'].'</span></h5>
												<a href="minethemepark.php?id='.$row['id'].'" class="article-link">
													<h4>'.$row['post_title'].'</h4>
													<img src="'.$row['post_poster'].'" class="img-rounded" width="100%">
												</a>
												<h4>';
									if(!$online) {
										echo '<a href="?warning=You can only like a post if you are logged in." class="like"><i class="fa fa-heart-o" aria-hidden="true"></i> <strong>'.countLikesMTP($row['id']).'</strong></a>
											  <a href="#" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> <strong>'.countCommentsMTP($row['id']).'</strong></a>';
									}
									else {
										if(isLikingMTP($_SESSION['id'], $row['id']))
										{
											echo '<a href="minethemepark.php?id='.$row['id'].'&unlike" class="like"><i class="fa fa-heart" aria-hidden="true"></i> <strong>'.countLikesMTP($row['id']).'</strong></a>';
										}
										else {
											echo '<a href="minethemepark.php?id='.$row['id'].'&like" class="like"><i class="fa fa-heart-o" aria-hidden="true"></i> <strong>'.countLikesMTP($row['id']).'</strong></a>';
										}
			
										if(hasCommentMTP($_SESSION['id'], $row['id']))
										{
											echo '<a href="minethemepark.php?id='.$row['id'].'" class="comment"><i class="fa fa-comment" aria-hidden="true"></i> <strong>'.countCommentsMTP($row['id']).'</strong></a>';
										}
										else {
											echo '<a href="minethemepark.php?id='.$row['id'].'" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> <strong>'.countCommentsMTP($row['id']).'</strong></a>';
										}
									}
					echo '						</h4>
											</div>
										</div>
									</div>';
		}


?>
					
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
			<img style="display: none;" src="<?php echo getMTPpostImage($id); ?>" />
			<div class="row">
				<div class="col-sm-3">
					<?php include('inc/sidebar-left.php'); ?>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
<?php
				if(isdeletedMTP($id)) {
					if(canManagePosts($_SESSION['id'])) {
						echo '<div class="alert alert-warning alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>This post is deleted.
							  </div>';
					}
				}
?>				
<?php 

	require_once('core/ini.php');
	$sql 	= "SELECT * FROM `minethemepark_posts` WHERE `id`='".$id."'";
    $result = connection()->query($sql);
	
	while($row = $result->fetch_assoc())
	{
		echo '<img id="myImg" src="'.$row['post_header'].'" alt="'.$row['post_title'].'" width="100%">
				<div class="box-login" style="margin-top: -10px;">
					<h4 style="margin-left: 5%"><strong>'.$row['post_title'].'</strong> - '.$row['posted_on'].' <span class="label label-danger">MineThemepark</span></h4>
					<center><hr style="width: 90%;"></center>
					<div class="article-body">
						'.$row['post_body'].'
					</div>
					<center><hr style="width: 90%;"></center>
					<h4 style="margin-left: 5%">';
		if(!$online) {
			echo '<a href="?id='.$id.'&warning=You can only like a post if you are logged in." class="like"><i class="fa fa-heart-o" aria-hidden="true"></i> <strong>'.countLikesMTP($row['id']).'</strong></a>
					<a href="#" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> <strong>'.countCommentsMTP($row['id']).'</strong></a>';
		}
		else {
			if(isLikingMTP($_SESSION['id'], $row['id']))
			{
				echo '<a href="?id='.$row['id'].'&unlike" class="like"><i class="fa fa-heart" aria-hidden="true"></i> <strong>'.countLikesMTP($row['id']).'</strong></a>';
			}
			else {
				echo '<a href="?id='.$row['id'].'&like" class="like"><i class="fa fa-heart-o" aria-hidden="true"></i> <strong>'.countLikesMTP($row['id']).'</strong></a>';
			}
			
			if(hasCommentMTP($_SESSION['id'], $row['id']))
			{
				echo '<a href="#" class="comment"><i class="fa fa-comment" aria-hidden="true"></i> <strong>'.countCommentsMTP($row['id']).'</strong></a>';
			}
			else {
				echo '<a href="#" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> <strong>'.countCommentsMTP($row['id']).'</strong></a>';
			}
		}			
					
		echo	'	</h4>
				</div>';
	}
	
	if(!$online) {
		
		echo '<div class="box-login">
				<h5 style="margin-left: 5%"></strong>You can only read comments when you are logged in.</strong></h5>
			  </div>';
		
	}
	else {	
		
		echo '<div class="box-login">
				<h4 style="margin-left: 5%;"><strong>Comments</strong></h4>
				<center><hr style="width: 90%;"></center>
				<div style="margin-left: 5%;">';
	
		require_once('core/ini.php');
	
		$sql 	= "SELECT * FROM `minethemepark_comments` WHERE `post_id`='".$id."' AND `deleted`='0' ORDER BY id DESC";
		$result = connection()->query($sql);
		
		if($result->num_rows > 0){
		
			while($row = $result->fetch_assoc())
			{
				if(!canManageComments($_SESSION['id'])) {
				
				echo '<div class="media">
						<div class="media-left">
							<a href="users.php?id='.$row['user_id'].'"><img src="https://minotar.net/avatar/'.getMinecraft($row['user_id']).'" class="media-object img-circle" style="width:50px"></a>
						</div>
						<div class="media-body">
							<h5 class="media-heading"><a href="users.php?id='.$row['user_id'].'" class="park-link">'.getFirstname($row['user_id']).' '.getFamilyname($row['user_id']).'</a>';
				if(isStaff($row['user_id'])){
					echo ' '.getRank($row['user_id']).'';
				}

				echo ' - '.$row['datum'].'</h5>
							<p>'.$row['data'].'</p>
						</div>
					</div>';
				}
				else {
				echo '<div class="media">
						<div class="media-left">
							<a href="users.php?id='.$row['user_id'].'"><img src="https://minotar.net/avatar/'.getMinecraft($row['user_id']).'" class="media-object img-circle" style="width:50px"></a>
						</div>
						<div class="media-body">
							<h5 class="media-heading"><a href="users.php?id='.$row['user_id'].'" class="park-link">'.getFirstname($row['user_id']).' '.getFamilyname($row['user_id']).'</a>';
				if(isStaff($row['user_id'])){
					echo ' '.getRank($row['user_id']).'';
				}			
							
				echo ' - '.$row['datum'].' <a href="core/del_mtp_comment.php?id='.$row['id'].'&post='.$row['post_id'].'"><span class="label label-danger">Delete</span></a></h5>
							<p>'.$row['data'].'</p>
						</div>
					</div>';	
				}
			}
		}
		else {
			echo '<h5>There are no comments for this post, write one as first.</h5>';
		}
		
		echo '	</div>
				<center><hr style="width: 90%;"></center>
				<div style="margin-left: 5%; margin-right: 5%;">
					<form id="comment" class="form-horizontal" method="GET">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-10">
									<input name="Comment" class="form-control" id="mtp_comment" placeholder="Write comment" type="text" / required>
									<input type="hidden" id="mtp_post_id" value="'.$id.'">
									<input type="hidden" id="mtp_user_id" value="'.$_SESSION['id'].'">
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-danger">
									Publish
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>';
				
		echo '</div>';
	}
	
	if(canManagePosts($_SESSION['id'])) {
		if(!isdeletedMTP($id)) {
			echo '<div class="box-login">
					<h4><a href="core/del_mtp_post.php?post='.$id.'&data=1"><span class="label label-danger">Delete Post</span></a></h4>
				  </div>';
		}
		else {
			echo '<div class="box-login">
					<h4><a href="core/del_mtp_post.php?post='.$id.'&data=0"><span class="label label-success">Post again</span></a></h4>
				  </div>';
		}
	}


	
?>

<script>
$('#comment').on('submit', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "core/mtp_post_comment.php",
        data: {comment: " "+$('#mtp_comment').val(), post_id: " "+$('#mtp_post_id').val(), user_id: " "+$('#mtp_user_id').val()},
        success: function(data){
            if(data === 'mtp_comment_success'){
                document.location.href = '?id=<?php echo $id ?>&success=Comment successfully posted.';
            }
        }
    });
});
</script>


					<!-- The Modal -->
					<div id="myModal" class="modal">
						<span class="close" style="color: #f1f1f1; font-size: 40px;">&times;</span>
						<img class="modal-content" id="img01">
						<div id="caption"></div>
					</div>
					<script>
var modal = document.getElementById('myModal');

var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

var span = document.getElementsByClassName("close")[0];

span.onclick = function() { 
    modal.style.display = "none";
}
</script>
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