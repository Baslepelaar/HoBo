<?php
    require_once 'partial/header.php';
    require_once 'backend/class/Login.php';

    $is_online = new Online();

    $online = $is_online->getIs_online();
    $banned = false;
    if($online) {
        $banned = true;
    }
    if($banned) {
        header('Location: index.php');
    }

    $ip = new IP();

    $getip = $ip->get_client_ip();

    $ip->addIPtoList($getip);
    if($ip->isIPBanned($getip)) {
        header('Location: https://google.com');
    }

    $userIns = new Login();

    if(isset($_POST['login'])){
        $userIns->login($_POST);
    }

	
?>

    <?php include('backend/alert.php'); ?>
    <main>
    	<section class="form">
	    	<form method="post">
	    		<label for="email" id="email">Email: </label>
	    		<input type="email" name="email" required>
	    		<label for="password">Wachtwoord: </label>
	    		<input type="password" name="password" required>
	    		<input type="submit" name="login" value="Login">
	    	</form>
	    	<a href="registratie.php">Registreren</a>
    	</section>
    </main>


<?php
require_once 'partial/footer.php';
?>