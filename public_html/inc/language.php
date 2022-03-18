<?php
	if($online) {
		
		if(getLang($_SESSION['id']) == 'NL') {
			include('inc/language/nl.php');
		}
		else
		{
			if(getLang($_SESSION['id']) == 'EN') {
				include('inc/language/en.php');
			}
			else
			{
				include('inc/language/en.php');
			}
		}
	}
    else
	{
		$lang = ($_GET['lang']);
		
        if(empty($_GET['lang'])) {
			include('inc/language/en.php');
		}
		else {
			if($lang == NL) {
				include('inc/language/nl.php');
			}
			else
			{
				include('inc/language/en.php');
			}
		}
	}
?>