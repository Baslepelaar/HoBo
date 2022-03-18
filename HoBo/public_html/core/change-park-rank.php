<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['user_id']) && !empty($_POST['park_id']) && !empty($_POST['rank'])){
		$user_id = substr($_POST['user_id'],1);
        $park_id = substr($_POST['park_id'],1);
        $rank = substr($_POST['rank'],1);
		$description = substr($_POST['description'],1);

        echo changeParkRank($user_id, $park_id, $rank, $description);
    }
    else
    {
        header('Location: park-staff.php?id='.$user_id.'&park='.$park_id.'&warning=Not all fields are filled in.');
    }
?>