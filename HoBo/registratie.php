<?php
    require_once 'partial/header.php';
    require_once 'backend/class/User.php';

    $user = new User();

    $users = $user->getUsers();
    var_dump($users);
    if(isset($_POST['register'])) {
        $user->create($_POST);
    }

?>

    <main>
    	<section class="form">
	    	<form method="post">
	    		<label for="username" id="username">Gebruikersnaam: </label>
	    		<input type="text" name="username" required>
	    		<label for="password">Wachtwoord: </label>
	    		<input type="password" name="password" required>
	    		<label for="conf-password">Wachtwoord bevestigen: </label>
	    		<input type="password" name="conf-password" required>
	    		<input type="submit" name="register" value="Register">
	    	</form>
    	</section>
    </main>


<?php
    require_once 'partial/footer.php';
?>