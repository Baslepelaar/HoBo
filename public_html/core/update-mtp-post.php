<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['post_id']) && !empty($_POST['title']) && !empty($_POST['body'])){
		$post_id = substr($_POST['post_id'],1);
        $title = substr($_POST['title'],1);
		$body = substr($_POST['body'],1);

        echo updateMTPpost($post_id, $title, $body);
    }
    else
    {
        header('Location: index.php');
    }
?>