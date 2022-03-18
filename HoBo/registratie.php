<?php
    require_once 'partial/header.php';
    require_once 'backend/class/Register.php';

    $Register = new Register();

    $User = $Register->getUsers();
    var_dump($User);
    if(isset($_POST['register'])) {
        $Register->create($_POST);
    }

?>

    <main>
    	<section class="form">
	    	<form method="post">
                <label for="voornaam" id="voornaam">Voornaam: </label>
                <input type="text" name="voornaam" required>
                <label for="tussenvoegsel" id="tussenvoegsel">Tussenvoegsel: </label>
                <input type="text" name="tussenvoegsel">
                <label for="achternaam" id="achternaam">Achternaam: </label>
                <input type="text" name="achternaam" required>
                <label for="email" id="email">Email: </label>
                <input type="email" name="email" required>
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