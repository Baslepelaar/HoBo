<?php
    session_start();
    include('functions.php');

    if(!empty($_POST['comment']) && !empty($_POST['post_id']) && !empty($_POST['user_id'])){
        $comment = substr($_POST['comment'],1);
        $post_id = substr($_POST['post_id'],1);
		$user_id = substr($_POST['user_id'],1);

        echo postCommentPost($comment, $post_id, $user_id);
    }
    else
    {
        header('Location: index.php');
    }
?>