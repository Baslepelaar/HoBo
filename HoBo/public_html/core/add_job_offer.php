<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['title']) && !empty($_POST['body']) && !empty($_POST['park'])){
		$title = substr($_POST['title'],1);
        $body = substr($_POST['body'],1);
        $park_id = substr($_POST['park'],1);

        echo addJobOffer($title, $body, $park_id);
    }
    else
    {
        header('Location: index.php');
    }
?>