<?php
    require_once 'partial/header.php';
    require_once 'backend/class/Register.php';

    session_start();
    $is_online = new Online();

    $online = $is_online->getIs_online();
    $banned = false;
    if($online) {
        $banned = true;
    }
    if($banned) {
        header('Location: index.php');
    }

    $Register = new Register();

    $User = $Register->getUsers();
    var_dump($User);
    if(isset($_POST['register'])) {
        $Register->create($_POST);
    }

    $ip = new IP();

    $getip = $ip->get_client_ip();

    $ip->addIPtoList($getip);
    if($ip->isIPBanned($getip)) {
        header('Location: https://google.com');
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