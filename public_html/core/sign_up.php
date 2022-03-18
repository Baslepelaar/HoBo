<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['email']) && !empty($_POST['firstname']) && !empty($_POST['familyname']) && !empty($_POST['minecraft']) && !empty($_POST['password']) && !empty($_POST['re_password']) && !empty($_POST['ip'])){
        $email = substr($_POST['email'],1);
		$firstname = substr($_POST['firstname'],1);
		$familyname = substr($_POST['familyname'],1);
		$minecraft = substr($_POST['minecraft'],1);
        $password = substr($_POST['password'],1);
        $repassword = substr($_POST['re_password'],1);
		$ip = substr($_POST['ip'],1);

        echo sign_up($email, $firstname, $familyname, $minecraft, $password, $repassword, $ip);
    }
    else
    {
        header('Location: sign-up.php?warning=Not all fields are filled in.');
    }
?>