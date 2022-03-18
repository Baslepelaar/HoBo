<?php
    session_start();
    include('functions.php');

    if(!empty($_FILES['header']) && !empty($_POST['park'])){
		
		$imgh = $_FILES['header'];
		$headerimg = '';
		if(!$_FILES['header']['size'] == 0) {
			$headerimg = uploadimage($imgh);
		}	
		
		$park_id = substr($_POST['park'],1);
		
        echo updateParkSettings($headerimg, $park_id);
    }
    else
    {
        header('Location: index.php');
    }
?>