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
		<section class="row w-100 h-100 justify-content-center">
        <article class="col-md-5 forum mt-5 p-4">
          <h2 class="h1-responsive font-weight-bold text-center my-4" style="color: white;">Inloggen</h2>
              <div class="row">
                <div class="col-md-9 mb-md-0 w-responsive mx-auto" style="margin-left: 5vw;">
                  <form id="contact-form" name="contact-form" method="POST">
                 <div class="row">
              <div class="col-md-12">
                <div class="md-form mt-3">
                  <input class="text-center mb-1" type="email" id="name" name="email" style="height: 5vh;" placeholder="Email" required>
                  <input class="text-center mb-1" type="password" id="email" name="password" style="height: 5vh;" placeholder="Wachtwoord" required>
                </div>
              </div>
            </form>
              <div class="text-center text-md-left col-md-12 mt-3">
			          <input class="btn btn-primary btn-lg"type="submit" name="login" value="Login" style="background-color: #02ee5a; border-color: #02ee5a; height: 5vh;">
			          <a href="registratie.php" class="btn btn-primary btn-lg" style="background-color: #02ee5a; border-color: #02ee5a;">Registreren</a>
			        </div>
			          <div class="status"></div>
              </div>
            </div>
        </article>
      </section>
    </main>

<?php
require_once 'partial/footer.php';
?>