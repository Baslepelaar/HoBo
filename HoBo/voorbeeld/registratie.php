<?php
require_once 'partial/header.php';
require_once 'backend/class/User.php';

$userIns = new User();
if(isset($_POST['register'])){
	echo $userIns->register($_POST['username'], $_POST['password'], $_POST['password-conf']);
}

?>

    <main>
    	<section class="form">
	    	<form method="post">
	    		<label for="username" id="username">Gebruikersnaam: </label>
	    		<input type="text" name="username" required>
	    		<label for="password">Wachtwoord: </label>
	    		<input type="password" name="password" required>
	    		<label for="password-conf">Wachtwoord bevesteging: </label>
	    		<input type="password" name="password-conf" required>
	    		<input type="submit" name="register" value="Register">
	    	</form>
    	</section>
    </main>


<?php
require_once 'partial/footer.php';
?>