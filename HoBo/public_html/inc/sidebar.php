<iframe src="https://discordapp.com/widget?id=726473265010442280&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
<div class="box-login">
	<center>
		<h4>
			<a href="https://twitter.com/MineThemepark" target="_blank" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<a href="https://www.facebook.com/MineThemepark-146847972717661/" target="_blank" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			<a href="https://www.instagram.com/minethemepark/" target="_blank" class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
			<a href="https://www.youtube.com/channel/UCDpfwlgel29L23tZ8qi9Wog" target="_blank" class="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
		</h4>
	</center>
</div>

<div class="box-login">
	<div class="media">
		<div class="media-left">
			<a href="park.php?id=1"><img src="inc/img/parks/logo/1.png" class="media-object img-circle" style="width:60px"></a>
		</div>
		<div class="media-body">
			<h4 class="media-heading"><a href="park.php?id=1" class="park-link"><strong>MagieCraft</strong></a></h4>
			<p>IP: play.magiecraft.net</p>
		</div>
	</div>
</div>

<?php
	require_once('core/ini.php');
	$sql 	= "SELECT * FROM `ads` WHERE `type`='sidebar' AND `active`='1' ORDER BY RAND() LIMIT 1";
    $result = connection()->query($sql);
	
	while($row = $result->fetch_assoc())
	{
	echo'<div class="box-login">
			<div class="media">
				<div class="media-left">
					<a href="park.php?id='.$row['park_id'].'"><img src="'.getParklogo($row['park_id']).'" class="media-object img-circle" style="width:60px"></a>
				</div>
				<div class="media-body">
					<h4 class="media-heading"><a href="park.php?id='.$row['park_id'].'" class="park-link"><strong>'.getParkname($row['park_id']).'</strong></a></h4>
					<p>IP: '.getParkip($row['park_id']).'</p>
				</div>
			</div>
		</div>';
	}
?>

<div class="box-login">
	<p>&copy; <?php echo date("Y"); ?> MineThemepark<br>
	<a href="http://bas.depauwhosting.nl/documents/terms-and-conditions.pdf" class="footer-link">Terms and Conditions</a> <a href="#" class="footer-link" style="margin-left: 10px;">Privacy policy</a></p>
	<hr>
	<a href="https://bas.depauwhosting.nl" class="made-by">Made by MineThemepark</a>
</div>