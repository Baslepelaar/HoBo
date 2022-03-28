\<?php
  $bg = array('bg-01.png', 'bg-02.png', 'bg-03.png', 'bg-04.png', ); // array of filenames

  $i = rand(0, count($bg)-1); // generate random number size of the array
  $selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
  
	include('core/functions.php');
	if(getMaintenance() != '1') {
		header('Location: index.php');
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
		<!-- Made by MineThemepark -->

		<!-- Meta -->
		<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
		<meta name="description" content="Follow and explore the newest facts about Minecraft Theme Park server's now." />
		<meta name="keywords" content="MineThempark, Theme Park, Minecraft, Server, News, pretpark, parkcraft, online, attracties, attractions, follow, login, connect" />
		<meta name="author" content="MineThemepark">
		<meta name="robots" content="index" />
		<meta name="revisit-after" content="1 month" />

		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="css/maintenance.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Script -->
		<script src="https://use.fontawesome.com/213a34779b.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<!-- Icon -->
		<link rel="icon" href="inc/img/favicon.png" />
		
		<title>MineThemepark | Maintenance</title>
		
		<style type="text/css">
		body.maintenance {
			background: url(inc/img/background/<?php echo $selectedBg; ?>);
			background-attachment: fixed;
			background-size: cover;
			background-repeat: no-repeat;
			position: relative;
			background-size: cover;
		}
		</style>	
	</head>
	<body class="maintenance">
	    <div class="content">
		    <div class="maintenance-center">
		        <div class="maintenance-content">
		            <h2 style="padding-top: 1rem; text-transform: uppercase;"><strong>Maintenance</strong></h2>
		            <h1 style="font-size: 50px;"><strong>MineThemepark</strong></h1>
		            <h4 style="padding-top: 1rem; padding-bottom: 1rem; text-transform: uppercase;"><strong><i class="fa fa-clock-o" aria-hidden="true"></i> We will be back soon</strong></h4>
		        </div>
		    </div>
        </div>
        <div class="maintenance-footer"><div class="row"><div class="col-sm-6 col-sm-offset-3">Copyright &copy; <?php echo date("Y"); ?> <a href="https://netixydev.com" style="color: #fff; text-decoration: none;">Netiyx Development</a></div><div class="col-sm-3"><div class="pull-right">Backgrounds by <a href="https://magiecraft.net" style="color: #fff; text-decoration: none;">MagieCraft</a></div></div></div></div>
		<script src="js/live-chat.js"></script>
	</body>
</html>