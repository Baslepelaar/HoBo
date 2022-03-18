<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['park_owner']) && !empty($_POST['park_name']) && !empty($_POST['park_ip']) && !empty($_POST['park_twitter'])){
		$owner = substr($_POST['park_owner'],1);
        $park_name = substr($_POST['park_name'],1);
        $park_ip = substr($_POST['park_ip'],1);
		$park_website = substr($_POST['park_website'],1);
		$park_twitter = substr($_POST['park_twitter'],1);
		$park_facebook = substr($_POST['park_facebook'],1);
		$park_youtube = substr($_POST['park_youtube'],1);

        echo requestPark($owner, $park_name, $park_ip, $park_website, $park_twitter, $park_facebook, $park_youtube);
    }
    else
    {
        header('Location: index.php');
    }
?>