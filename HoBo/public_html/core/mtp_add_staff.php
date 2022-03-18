<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['email'])){
        $email = substr($_POST['email'],1);

        echo addMTPstaff($email);
    }
    else
    {
        header('Location: index.php');
    }
?>