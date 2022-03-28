<?php
	session_start();
	include('functions.php');
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$post = $_GET['post'];
	$data = $_GET['data'];
 
	if(canManageComments($_SESSION['id'])) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `minethemepark_posts` WHERE `id`='".$post."'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "UPDATE `minethemepark_posts` SET `deleted`='".$data."' WHERE `id`='".$post."';";
             connection()->query($sql);
			
			header('Location: ../minethemepark.php?id='.$post.'&success=The status of this post is successfully switched.');
		}
		else {
			header('Location: ../?danger=We cant find that post.');
		}
	}
?>