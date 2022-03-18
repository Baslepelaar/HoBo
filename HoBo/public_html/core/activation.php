<?php
    if(!empty($_GET['type']))
    {
        include('functions.php');
        
        $type = $_GET['type'];
        
        if($type == "verifyAccount")
        {
            if(!empty($_GET['id']) && !empty($_GET['email']))
            {
                active($_GET['id'], $_GET['email']);

                header('Location: ../login.php?success=Your account is successfully activated.');
            }
        }
    }
?>
