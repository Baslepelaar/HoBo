<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['email'])){
        $email = substr($_POST['email'],1);

        echo reset_password_mail($email);
    }
    else
    {
        header('Location: login.php?warning=Not all fields are filled in!');
    }
?>