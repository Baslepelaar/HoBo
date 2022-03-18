<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['code']) && !empty($_POST['id']) && !empty($_POST['password']) && !empty($_POST['re_password'])){
        $rcode = substr($_POST['code'],1);
		$rid = substr($_POST['id'],1);
        $new = substr($_POST['password'],1);
        $rnew = substr($_POST['re_password'],1);

        echo reset_password($rcode, $rid, $new, $rnew);
    }
    else
    {
        header('Location: login.php?danger=Something went wrong, try again.');
    }
?>