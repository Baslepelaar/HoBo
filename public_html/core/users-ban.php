<?php
	session_start();
	include('functions.php');
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$id = $_GET['id'];
	$ban = $_GET['ban'];
	
	if(canManageUsers($_SESSION['id'])) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `users` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "UPDATE `users` SET `banned`='".$ban."' WHERE `id`='".$id."';";
            connection()->query($sql);
			 
			$ip = getIpFromUser($id);
			$sql = "SELECT * FROM `ip` WHERE `ip`='".$ip."'";
			$result = connection()->query($sql);
			if($result->num_rows > 0){
				$sql = "UPDATE `ip` SET `banned`='".$ban."' WHERE `ip`='".$ip."';";
				connection()->query($sql);
			}
			
			header('Location: ../staff-users-list.php?success=You successfully switched ban status of users.');
		}
		else {
			header('Location: ../staff-users-list.php?danger=That user cant be fount.');
		}
	}
	else {
		header('Location: ../staff-panel.php');
	}
?>