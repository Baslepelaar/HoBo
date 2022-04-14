<?php
require_once 'partial/header.php';
session_start();
include('backend/alert.php');

require_once 'backend/class/Online.php';
require_once 'backend/class/IP.php';

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

//die(var_dump($getip));
$ip->addIPtoList($getip, $_SESSION['klantnr']);
if($ip->isIPBanned($getip)) {
    header('Location: https://google.com');
}

?>

<body>
    <main>
    <article class="bg-image" style="background-image: url('img/SW-banner.png');height: 100vh; background-size: cover; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));
      mask-image: linear-gradient(to bottom, rgba), rgba(0,0,0,0));"></article>
    <section class="row w-100 h-100 card-img-overlay">
        <article class="container mt-5">
            <article class="col-md-4 logo"><img src="img/SW-logo.png" alt="Star Wars logo" style="height: 10vw; justify-content-end; margin-left: 5vw; margin-top: 5vh;"></article>
            <article class="col-md-5 col-sm-2 filmtekst" style="margin-left: 5vw; margin-top: 5vh;">
                <p class="filmtext" style="font-size: 1.5rem; color: white;">Star Wars is een Amerikaanse epische space-opera-filmserie bedacht door George Lucas
                en ontwikkeld door zijn bedrijf Lucasfilm. Het epos bestaat uit drie afgeronde trilogieën,
                twee losstaande films, twee live-actionseries, meerdere animatieseries en meerdere stripreeksen.
                </p>
            </article>
        <article class="carousel" style="margin-left: 5vw; margin-top: 5vh;">
            <div id="carouselExampleControls" class="carousel slide col-md-3" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="d-block w-100" src="img/infinity-war-bg.jpg" alt="First slide" style="border-radius: 1vw;">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="img/SW-logo.png" alt="First slide" style="border-radius: 1vw;">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="img/infinity-war-bg.jpg" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only"></span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only"></span>
                </a>
              </div>
        </article>
    </section>
  </main>
</body>
<?php
require_once 'partial/footer.php';
?>  