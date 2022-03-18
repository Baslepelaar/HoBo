<?php
	session_start();
	include('functions.php');
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$apply = $_GET['id'];
	$data = $_GET['data'];
	$park = $_GET['park'];
 
	if(canManageParkApply($_SESSION['id'], $park)) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `applys` WHERE `id`='".$apply."'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "UPDATE `applys` SET `deleted`='".$data."' WHERE `id`='".$apply."';";
             connection()->query($sql);
			
			header('Location: ../park.php?id='.$park.'&success=The status of this job offer is successfully switched.');
		}
		else {
			header('Location: ../?danger=We cant find that post.');
		}
	}
?>