<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['body'])){
		$apply_id = substr($_POST['id'],1);
        $title = substr($_POST['title'],1);
		$body = substr($_POST['body'],1);

        echo updateParkApply($apply_id, $title, $body);
    }
    else
    {
        header('Location: index.php');
    }
?>