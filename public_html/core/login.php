<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $email = substr($_POST['email'],1);
        $password = substr($_POST['password'],1);

        echo login($email, $password);
    }
    else
    {
        header('Location: index.php');
    }
?>