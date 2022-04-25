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
<?php
include('backend/alert.php'); 
?>
<main>
  <div class="row w-100 h-100 justify-content-center mt-5">
  <form id="contact-form" name="contact-form" method="POST">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card card-registration my-4" style="border-radius: 2vh; border: black solid 0px;">
          <div class="row g-0">
            <div class="col-xl-6 d-none d-xl-block">
              <img
                src="img/logo full 2.png"
                alt="star wars achtergrond"
                class="img-fluid"
                style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem; height: 80vh; border-top-left-radius: 2vh; border-bottom-left-radius: 2vh; background-color: black;"/>
            </div>
            <div class="col-xl-6">
              <div class="card-body p-md-5 text-black">
                <h3 class="mb-5 text-center">Registreren</h3>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                    <input class="text-center mb-1" type="text" name="voornaam" style="height: 5vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Voornaam" required>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                    <input class="text-center mb-1" type="text" name="tussenvoegsel" class="text-center" style="height: 5vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Tussenvoegsel">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                    <input class="text-center mb-1" type="text" name="achternaam" class="text-center" style="height: 5vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Achternaam" required>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                <div class="form-outline">
                <input class="text-center mb-1" type="email" name="email" class="text-center"style="height: 5vh; border-radius: 1vh; border: 2px solid grey;"  placeholder="Email" required>
                </div>
              </div>
              </div>
              
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                      <input class="text-center mb-1" type="text" name="password" style="height: 5vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Wachtwoord" required>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                      <input class="text-center mb-1" type="text" name="password-conf" class="text-center" style="height: 5vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Wachtwoord bevestigen">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 mb-4">
                    <input type="checkbox" id="voorwaarden" name="voorwaarden" value="ja" required> Ik ga akkoord met de privacy voorwaarden</input>
                  </div>

                <div class="row">
                  <div class="col-md-12 mb-4">
                    <p>Heb je al een account? Klik dan <a class="text-decoration-none" href="login.php" style="color: black;"><b>Hier</a></p>
                  </div>
                  <div class="submit">
                    <input type="submit" class="btn btn-primary btn-lg" style="background-color: #02ee5a; border-color: #02ee5a; height: 5vh;" name="register" value="Register">
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
    </form> 
  </div>
</main>

<?php
    require_once 'partial/footer.php';
?>