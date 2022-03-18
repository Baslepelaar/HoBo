<?php
    
    function connection()
    {
        $host = "localhost";
        $user = 'root';
        $pass = '';
        $db = 'ammineth_minethemepark';
        
        return $link = mysqli_connect($host, $user, $pass, $db);
    }
?>