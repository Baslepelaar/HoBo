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
		<section class="row w-100 h-100">
        <article class="col-md-5 forum mt-5 p-4" style="background-color: green; border-radius: 1vw;">
          <h2 class="h1-responsive font-weight-bold text-center my-4" style="color: white;">Inloggen</h2>
              <div class="row">
                <div class="col-md-9 mb-md-0 w-responsive mx-auto mb-5" style="margin-left: 5vw;">
                  <form id="contact-form" name="contact-form" method="POST">
                 <div class="row">
              <div class="col-md-12">
                <div class="md-form mt-3">
                  <input type="email" id="name" name="email" class="form-control mb-3" placeholder="Email" required>
                  <input type="password" id="email" name="password" class="form-control mb-3" placeholder="Password" required>
                </div>
              </div>
            </form>
              <div class="text-center text-md-left col-md-12">
			  <input class="btn btn-primary"type="submit"  name="login" value="Login" style="background-color: #02ee5a; border-color: #02ee5a;">
			  <a href="registratie.php" class="btn btn-primary" style="background-color: #02ee5a; border-color: #02ee5a;" onclick="">Registreren</a>
			</div>
			<div class="status"></div>
              </div>
            </div>
          </section>
      </article>
    </main>

<?php
require_once 'partial/footer.php';
?>