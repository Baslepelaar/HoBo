<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['park_id']) && !empty($_POST['ip']) && !empty($_POST['twitter'])){
		$park_id = substr($_POST['park_id'],1);
        $ip = substr($_POST['ip'],1);
		$description = substr($_POST['description'],1);
		$email = substr($_POST['email'],1);
		$twitter = substr($_POST['twitter'],1);
		$website = substr($_POST['website'],1);
		$facebook = substr($_POST['facebook'],1);
		$instagram = substr($_POST['instagram'],1);
		$youtube = substr($_POST['youtube'],1);
		$snapchat = substr($_POST['snapchat'],1);

        echo updateParkSettings($park_id, $ip, $description, $email, $twitter, $website, $facebook, $instagram, $youtube, $snapchat);
    }
    else
    {
        header('Location: index.php');
    }
?>