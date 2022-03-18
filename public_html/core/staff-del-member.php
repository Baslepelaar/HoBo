<?php
	session_start();
	include('functions.php');
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$id = $_GET['id'];
	
	if(canManageStaff($_SESSION['id'])) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "DELETE FROM `mtp_staff` WHERE `user_id`='".$id."';";
             connection()->query($sql);
			
			header('Location: ../staff-panel.php?success=You successfully deleted staff member.');
		}
		else {
			header('Location: ../staff-panel.php?danger=That user cant be fount as staff.');
		}
	}
	else {
		header('Location: ../staff-panel.php');
	}
?>