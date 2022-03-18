<?php
    session_start();
    include('functions.php');
    if(!is_online())
    {
        header("Location: ../index.php");
    }
    else
    {
        logout();
    }
?>
<html>
<head>
<meta http-equiv="refresh" content="0; url=https://beta.magiecraft.nl/">
</head>
</html>