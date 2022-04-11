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

    $User = $Register->getUser();
//    var_dump($User);
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

    <?php include('backend/alert.php'); ?>

    <main>
		<section class="row w-100 h-100 justify-content-center">
        <article class="col-md-5 forum mt-5 p-4">
          <h2 class="h1-responsive font-weight-bold text-center my-4" style="color: white;">Registreren</h2>
              <div class="row">
                <div class="col-md-9 mb-md-0 w-responsive mx-auto" style="margin-left: 5vw;">
                  <form id="contact-form" name="contact-form" method="POST">
                 <div class="row">
              <div class="col-md-12">
                <div class="md-form mt-3">
                 <input class="text-center mb-1" type="text" name="voornaam" style="height: 5vh;" placeholder="Voornaam" required>
                 <input class="text-center mb-1" type="text" name="tussenvoegsel" class="text-center" style="height: 5vh;" placeholder="Tussenvoegsel">
                 <input class="text-center mb-1" type="text" name="achternaam" class="text-center" style="height: 5vh;" placeholder="Achternaam" required>
                 <input class="text-center mb-1" type="email" name="email" class="text-center"style="height: 5vh;"  placeholder="Email" required>
                 <input class="text-center mb-1" type="password" name="password" class="text-center" style="height: 5vh;" placeholder="Wachtwoord" required>
                 <input class="text-center mb-1" type="password" name="conf-password" class="text-center" style="height: 5vh;" placeholder="Wachtwoord bevestigen" required>
                 <div class="text-center mt-3">
                    <input type="submit" class="btn btn-primary btn-lg" style="background-color: #02ee5a; border-color: #02ee5a; height: 5vh;" name="register" value="Register">
                </div>
                </div>
              </div>
            </form>
            </div>
        </article>
      </section>
    </main>


<?php
    require_once 'partial/footer.php';
?>