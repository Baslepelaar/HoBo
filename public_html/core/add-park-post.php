<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['park_id']) && !empty($_POST['title']) && !empty($_POST['body']) && !empty($_POST['poster']) && !empty($_POST['header'])){
		$park_id = substr($_POST['park_id'],1);
        $title = substr($_POST['title'],1);
		$body = substr($_POST['body'],1);
		$poster = substr($_POST['poster'],1);
		$header = substr($_POST['header'],1);

        echo addPost($park_id, $title, $body, $poster, $header);
    }
    else
    {
        header('Location: index.php');
    }
?>