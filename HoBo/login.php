<?php
    require_once 'partial/header.php';
    require_once 'backend/class/Login.php';
    session_start();

    $id = $_SESSION['klantnr'];

//    $is_online = new Online();
//
//    $online = $is_online->getIs_online($id);
//    $banned = false;
//    if($online) {
//        $banned = true;
//    }
//    if($banned) {
//        header('Location: index.php');
//    }

    $ip = new IP();

    $getip = $ip->get_client_ip();

    $ip->addIPtoList($getip, $id);
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
      <div class="row w-100 h-100 justify-content-center mt-5">
        <form id="contact-form" name="contact-form" method="POST">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-4">
              <div class="card card-registration my-4" style="border-radius: 2vh; border: black solid 0px;">
              <div class="row g-0">
                <div class="col-xl-12">
                  <div class="card-body p-md-5 text-black">
                    <h3 class="mb-5 text-center">Inloggen</h3>
                    <div class="row">
                      <div class="col-md-12 mb-4">
                        <div class="form-outline">
                          <input class="text-center mb-1" type="email" id="email" name="email" class="text-center"style="height: 5vh; border-radius: 1vh; border: 2px solid grey;"  placeholder="Email" required>
                        </div>
                      </div>
                    </div>
                
                    <div class="row">
                      <div class="col-md-12 mb-4">
                        <div class="form-outline">
                          <input class="text-center mb-1" type="password" id="password" name="password" style="height: 5vh; border-radius: 1vh; border: 2px solid grey;" placeholder="Wachtwoord" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 mb-4">
                          <p>Heb je al nog geen account? Klik dan <a class="text-decoration-none" href="registratie.php" style="color: black;"><b>Hier</a></p>
                        </div>
                      </div>
                      
                      <div class="text-center text-md-left col-md-12 mt-3">
                        <input class="btn btn-primary btn-lg"type="submit" name="login" value="Login" style="background-color: #02ee5a; border-color: #02ee5a; height: 5vh;">
                      </div>
                      <div class="status"></div>
                    </div>
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