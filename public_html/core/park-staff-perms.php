<?php
	session_start();
	include('functions.php');
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$id = $_GET['id'];
	$perm = $_GET['perm'];
	$data = $_GET['data'];
	$park = $_GET['park'];
	
	if(canManageParkStaff($_SESSION['id'], $park)) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `parks_staff` WHERE `user_id`='".$id."' AND `park_id`='".$park."'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "UPDATE `parks_staff` SET `".$perm."`='".$data."' WHERE `user_id`='".$id."' AND `park_id`='".$park."';";
             connection()->query($sql);
			
			header('Location: ../park-staff.php?id='.$id.'&park='.$park.'&success=You successfully switched the perm "'.$perm.'"');
		}
		else {
			header('Location: ../park.php?id='.$park.'&danger=That user cant be fount as staff.');
		}
	}
	else {
		header('Location: ../index.php');
	}
?>