<?php
require_once 'partial/header.php';
require_once 'backend/class/Login.php';

$userIns = new Login();

if(isset($_POST['login'])){
    $userIns->login($_POST);
}
	
?>

    <main>
    	<section class="form">
	    	<form method="post">
	    		<label for="voornaam" id="voornaam">Voornaam: </label>
	    		<input type="text" name="voornaam" required>
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