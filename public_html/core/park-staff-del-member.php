<?php
	session_start();
	include('functions.php');
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$id = $_GET['id'];
	$park_id = $_GET['park'];
	
	if(canManageParkStaff($_SESSION['id'], $park_id)) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `parks_staff` WHERE `user_id`='".$id."' AND `park_id`='".$park_id."'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "DELETE FROM `parks_staff` WHERE `user_id`='".$id."' AND `park_id`='".$park_id."';";
             connection()->query($sql);
			
			header('Location: ../park.php?id='.$park_id.'&success=You successfully deleted staff member.');
		}
		else {
			header('Location: ../park.php?id='.$park_id.'&danger=That user cant be fount as staff.');
		}
	}
	else {
		header('Location: ../park.php?id='.$park_id.'');
	}
?>