<?php
session_start();
//maintenance check
require_once 'backend/class/Maintenance.php';

$maintenance = new Maintenance();
if($maintenance->getMaintenance() == '1') {
    header('Location: maintenance.php');
}
require_once 'backend/class/UserRight.php';
require_once 'backend/class/Online.php';
require_once 'backend/class/IP.php';

$userright = new UserRight();

$id = '';

if(isset($_SESSION['klantnr'])){
    $id = $_SESSION['klantnr'];
}
//die(var_dump($id));

//$is_online = new Online();
//
//$online = $is_online->getIs_online($id);
//$banned = false;
//if($online) {
//    $banned = true;
//}
//if($banned) {
//    header('Location: index.php');
//}

$ip = new IP();

$getip = $ip->get_client_ip();

//die(var_dump($getip));
$ip->addIPtoList($getip, $id);
if($ip->isIPBanned($getip)) {
    header('Location: https://google.com');
}
//$serie = New Serie();?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset= "utf-8">
      <meta http-equiv="language" content="NL">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="author" content="Bas, William, Mathieu">
      <meta name="keywords" content="Hobo, streaming website, streaming">
      <title>Hobo</title>
      <link rel="icon" type="image/png" href="img/Logo.png" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <script src="https://kit.fontawesome.com/82fbcd35e0.js" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="css/global.css">
      <script src="https://kit.fontawesome.com/e7db147a51.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
      <link rel="stylesheet" href="index.css">
  </head>
  <body>
  <img src="img/logo.png" class="logoHeader">
    <header>
      <div class="d-flex flex-shrink-0 align-items-center" >
          <ul class="nav nav-pills mb-auto text-center">
            <li class="nav-item btn-sm">
              <a href="index.php" class="nav-link" style="background-color:#02ee5a" aria-current="page" title="" data-bs-toggle="tooltip" data-bs-placement="right">
              <div class="align-items-center"><img src="img/home.png" style="height: 2rem;"></div>
              </a>
            </li>
            <li class="btn-sm">
              <?php 
                if(isset($_SESSION['loggedin'])){ ?>
                  <a href="profile.php" class="nav-link bg-secondary" title="" data-bs-toggle="tooltip" data-bs-placement="right">
                  <div><img src="img/pop512.png" style="height: 2rem;"></div>
                  </a>
                <?php } else{ ?>
              <a href="login.php" class="nav-link bg-secondary" title="" data-bs-toggle="tooltip" data-bs-placement="right">
              <div><img src="img/pop512.png" style="height: 2rem;"></div>
              </a>
                <?php }
              ?>
            </li>
            <li class="btn-sm">
              <?php 
                if(isset($_SESSION['loggedin'])){ ?>
                  <a href="search.php" class="nav-link bg-secondary" title="" data-bs-toggle="tooltip" data-bs-placement="right">
                    <div><img src="img/vergroot512.png" style="height: 2rem;"></div>
                  </a>
              <?php } ?>
            </li>
            <li class="btn-sm">
              <?php 
                if(isset($_SESSION['loggedin'])){ ?>
                  <a href="history.php" class="nav-link bg-secondary" title="" data-bs-toggle="tooltip" data-bs-placement="right">
                    <div><img src="img/tijd512.png" style="height: 2rem; justify-content: center;"></div>
                  </a>
              <?php } ?>  
            </li>
            <li class="btn-sm">
            <?php 
                if(isset($_SESSION['loggedin'])){ ?>
                  <a href="destroy.php" class="nav-link bg-secondary" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
                  <div><img src="img/logout.png" style="height: 2rem;"></div>
                  </a>
                <?php } ?>
            </li>
            <li class="btn-sm">
              <?php 
                if($userright->canUseStaffPanel($id)){ ?>
                  <a href="backend/admin.php" class="nav-link bg-secondary" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
                  <div><img src="img/shield.png" style="height: 2rem;"></div>
                  </a>
                <?php }?>
            </li>
          </ul>
        </div>

    </header>