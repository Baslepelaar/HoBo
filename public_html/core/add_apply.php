<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['apply_id']) && !empty($_POST['user_id']) && !empty($_POST['about']) && !empty($_POST['why'])){
		$apply_id = substr($_POST['apply_id'],1);
        $user_id = substr($_POST['user_id'],1);
        $about = substr($_POST['about'],1);
		$why = substr($_POST['why'],1);
		$discord = substr($_POST['discord'],1);
		$skype = substr($_POST['skype'],1);

        echo addApplyReply($apply_id, $user_id, $about, $why, $discord, $skype);
    }
    else
    {
        header('Location: applys.php?warning=Not all fields are filled in.');
    }
?>