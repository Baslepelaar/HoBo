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
	
	if(canManageStaff($_SESSION['id'])) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "UPDATE `mtp_staff` SET `".$perm."`='".$data."' WHERE `user_id`='".$id."';";
             connection()->query($sql);
			
			header('Location: ../staff-manage.php?id='.$id.'&success=You successfully switched the perm "'.$perm.'"');
		}
		else {
			header('Location: ../staff-manage.php?id='.$id.'&danger=That user cant be fount as staff.');
		}
	}
	else {
		header('Location: ../index.php');
	}
?>