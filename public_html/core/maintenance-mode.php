<?php
	session_start();

    require_once 'class/Maintenance.php';

    $maintenance = new Maintenance();
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$data = $_GET['data'];
 
	if($maintenance->canManageSettings($_SESSION['id'])) {
		
		$sql = "SELECT * FROM `settings` WHERE `variable`='maintenance'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "UPDATE `settings` SET `data`='".$data."' WHERE `variable`='maintenance';";
             connection()->query($sql);
			
			header('Location: admin.php?success=The maintenance mode is switched.');
		}
		else {
			header('Location: admin.php?danger=Something went wrong.');
		}
	}
	else {
		header('Location: admin.php');
	}
?>