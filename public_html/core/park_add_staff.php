<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['email']) && !empty($_POST['rank']) && !empty($_POST['park'])){
        $email = substr($_POST['email'],1);
		$rank = substr($_POST['rank'],1);
		$park_id = substr($_POST['park'],1);
		
        echo addParkstaff($email, $rank, $park_id);
    }
    else
    {
        header('Location: index.php');
    }
?>