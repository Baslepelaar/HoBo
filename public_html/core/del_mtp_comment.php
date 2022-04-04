<?php
	session_start();
	include('functions.php');
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$post = $_GET['post'];
	$id = $_GET['id'];
 
	if(canManageComments($_SESSION['id'])) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `minethemepark_comments` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "UPDATE `minethemepark_comments` SET `deleted`='1' WHERE `id`='".$id."';";
             connection()->query($sql);
			
			header('Location: ../minethemepark.php?id='.$post.'&success=The comment is successfully deleted.');
		}
		else {
			header('Location: ../minethemepark.php?id='.$post.'&danger=We cant find that commend.');
		}
	}
?>