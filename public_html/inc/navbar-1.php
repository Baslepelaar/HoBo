<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid" style="background: #b90303; color: #fff; border-color: #960101;">
	<div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" style="color: #fff;" href="../">MineThemepark</a>
    </div>

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li><a href="index.php" style="color: #fff;"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> Home</a></li>
			<li><a href="minethemepark.php" style="color: #fff;">Our Page</a></li>
			<li><a href="park-list.php" style="color: #fff;">Park List</a></li>
			<li><a href="applys.php" style="color: #fff;">Apply List</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
				  <?php 
        if(!$online) {
			echo '<li><a href="login.php" style="color: #fff;">Sign In</a></li>';
		}
		else {
			
			if(isParkStaff($_SESSION['id'])) {
				
				require_once('core/ini.php');
				
				$sql 	= "SELECT * FROM `parks_staff` WHERE `user_id`='".$_SESSION['id']."' ORDER BY id";
				$result = connection()->query($sql);
				if($result->num_rows > 0){
					
					echo '<li class="dropdown">
							<a href="#" class="dropdown-toggle" style="color: #fff;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Your parks<span class="caret"></span></a>
							<ul class="dropdown-menu">';
					
					while($row = $result->fetch_assoc())
					{
						echo '<li><a href="park.php?id='.$row['park_id'].'"><img alt="User" class="user-icon img-rounded" src="'.getParklogo($row['park_id']).'" height="18px"></img> '.getParkname($row['park_id']).'</a></li>';
					}
					
					echo '	</ul>
						  </li>';
				}
			}

			echo '<li class="dropdown">
					<a href="#" class="dropdown-toggle" style="color: #fff;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img alt="User" class="user-icon img-rounded" src="https://minotar.net/avatar/'.getMinecraft($_SESSION['id']).'" height="27px"></img><strong> '.getFirstname($_SESSION['id']).' '.getFamilyname($_SESSION['id']).'</strong><span class="caret"></span></a>
					<ul class="dropdown-menu">
					<li><a href="profile.php"><img alt="User" class="user-icon img-rounded" src="https://minotar.net/avatar/'.getMinecraft($_SESSION['id']).'" height="18px"></img> Profile</a>';
					
				if(canUseStaffPanel($_SESSION['id'])){
					echo '<li role="separator" class="divider"></li>
						<li><a href="staff-panel.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Staff Panel</a></li>';
				}	
			
			echo '		<li role="separator" class="divider"></li>
					<li><a href="core/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li></ul>
				  </li>';
		}
		?>
		</ul>
		</ul>
		</div><!-- /.navbar-collapse -->
	</div>
  </div><!-- /.container-fluid -->
</nav>