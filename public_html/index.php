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
		include('core/feed-api.php');
		include('core/Mobile_Detect.php');
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
		
		$phone = false;
		$detect = new Mobile_Detect();
		if ($detect->isMobile()) {
			$phone = true;
		} 
		else {
			$phone = false;
		}	
		
		$user_ip = get_client_ip();
		
		addIPtoList($user_ip);
		if(isIPBanned($user_ip)){
			header('Location: https://google.com');
		}
		if($online) {
			UpdateUserIP($_SESSION['id'], $user_ip);
		}
?>
<!DOCTYPE html>
<html>
	<head>
		
		<?php include('inc/header.php'); ?>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<title>MineThemepark | Home</title>
		<style type="text/css">
		body {
			background: url(inc/img/background/<?php echo $selectedBg; ?>);
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
					<?php include('inc/sidebar-left.php'); ?>
				</div> <img src="" alt="">
<?php
	if(!$online) {
		echo '<div class="col-sm-6">';
	}
	else{
		echo '<div class="col-sm-6" id="feed">';
	}
?>
				<?php include('inc/alert.php'); ?>
				
				<div class="w3-content w3-display-container" style="margin-top: 5px; margin-bottom: 10px;">				
<?php
                require_once('core/ini.php');
					$sql 	= "SELECT * FROM `minethemepark_posts` WHERE `deleted`='0' ORDER BY id DESC LIMIT 4";
					$result = connection()->query($sql);
	
				while($row = $result->fetch_assoc())
				{

					echo'<div class="w3-display-container mySlides">
							<a href="minethemepark.php?id='.$row['id'].'">
								<img src="'.$row['post_poster'].'" style="width:100%">
								<div class="w3-display-middle w3-large w3-container w3-padding-16" style="background-color: rgba(255,255,255,0.6);">
									<center>'.$row['post_title'].'
									<p style="font-size: 13px;">'.$row['posted_on'].'</p></center>
								</div>
							</a>
						</div>';
				}
?>				
					<button class="w3-button w3-display-left w3-black" onclick="plusDivs(-1)">&#10094;</button>
					<button class="w3-button w3-display-right w3-black" onclick="plusDivs(1)">&#10095;</button>
				</div>
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>

<?php
	if(!$online) {
		echo '<div class="box-login">
				<h5><strong>Here are the newest post of the parks...</strong></h5>
			  </div>';
	}
	else {
		echo '<div class="box-login">
				<h5><strong>Your feed, follow more parks to get all their articles in your feed.</strong></h5>
			  </div>';
	}

	if(!$online) {

		require_once('core/ini.php');
		$sql 	= "SELECT * FROM `posts` WHERE `deleted`='0' AND `reviewed`='1' ORDER BY ID DESC LIMIT 15";
		$result = connection()->query($sql);
	
		while($row = $result->fetch_assoc())
		{
			
		echo'			<div class="box">
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
		
	echo '			<center><h5>...</h5></center><div class="box-login"><h5>To read more you need to be logged in.</h5></div>';
	}
	else {
		loadArticles(0, $_SESSION['id']);
	}
?>			
					
				</div>
				<div class="col-sm-3">
					<?php include('inc/sidebar.php'); ?>
				</div>
			</div>
		</div>
<?php
    if(!$phone) {
?>
        <script>
            var loadid = 1;
            $(document).ready(function () {
                $(document).scroll(function () {
                    if (($(window).scrollTop() + $(window).height() > ($(document).height() - 2))) {
                        $.get("http://minethemepark.com/loadarticle.php?feed=" + loadid, function (data) {
                            $("#feed").append(data);
                        });
                        loadid++;
                    }
                });
            });
        </script>
<?php
    } 
	else {
?>
        <script>
            var loadid = 1;
            $(document).ready(function () {
                $(document).scroll(function () {
                    console.log("window scrolltop: " + $(window).scrollTop());
                    console.log("window height: " + $(window).height());
                    console.log("document height: " + $(document).height());
                    console.log(Math.trunc($(window).scrollTop() + $(window).height()) + " = " + $(document).height())
                    if ((Math.trunc($(window).scrollTop() + $(window).height()) == ($(document).height() - 1)) || (Math.trunc($(window).scrollTop() + $(window).height()) == ($(document).height()))) {
                        $.get("http://minethemepark.com/loadarticle.php?feed=" + loadid, function (data) {
                            $("#feed").append(data);
                        });
                        loadid++;
                    }
                });
            });
        </script>
<?php
	}
?>
		<script src="js/live-chat.js"></script>
	</body>
</html>