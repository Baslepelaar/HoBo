<?php
	session_start();
	include('functions.php');
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$data = $_GET['data'];
 
	if(canManageSettings($_SESSION['id'])) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `settings` WHERE `variable`='maintenance'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "UPDATE `settings` SET `data`='".$data."' WHERE `variable`='maintenance';";
             connection()->query($sql);
			
			header('Location: ../staff-panel.php?success=The maintenance mode is switched.');
		}
		else {
			header('Location: ../staff-panel.php?danger=Something went wrong.');
		}
	}
	else {
		header('Location: ../staff-panel.php');
	}
?>