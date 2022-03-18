<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['post']))
    {
        $post = $_POST['post'];
            if(hasMTPLiked($_SESSION['id'], $post))
            {
                MTPunlike($_SESSION['id'], $post);
            }
            else
            {
				MTPlike($_SESSION['id'], $post);
            }
	}
?>