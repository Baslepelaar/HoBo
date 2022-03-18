<?php
	session_start();
	include('functions.php');
	
	if(!is_online())
	{
		header('Location: ../index.php');
	}
	
	$post = $_GET['post'];
	$data = $_GET['data'];
 
	if(canManagePosts($_SESSION['id'])) {
		
		require_once('ini.php');
		
		$sql = "SELECT * FROM `posts` WHERE `id`='".$post."'";
        $result = connection()->query($sql);
		
		if($result->num_rows > 0){
			$sql = "UPDATE `posts` SET `reviewed`='".$data."' WHERE `id`='".$post."';";
             connection()->query($sql);
			
			header('Location: ../article.php?id='.$post.'&success=You successfully reviewed this post.');
		}
		else {
			header('Location: ../index.php?danger=We cant find that commend.');
		}
	}
?>