<?php
require_once 'partial/header.php';

include('backend/alert.php');

?>

<?php 
    if(isset($_SESSION['loggedin'])){ ?> 
    <!-- dit stukje code hierboven controleert of je wel of niet bent ingelogd, zo ja, laat de index zien als je bent ingelogd, zo niet, laat dan de introductie pagina zien -->
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
    <?php } else{ ?>
      <!-- als je niet bent ingelogd dan krijg je de introductie pagina te zien hier beneden -->
      <main>
        <div class="megaBox bg-image" style="background-image: url('img/FvF.png'); height: 100vh; background-size: cover;">
            <div class="mt-5 flex-row justify-content-center introMain">
                <div class="mt-1 IntroBoxBody text-center" >
                    <h1><b>Onbeperkt series, films en meer kijken.<b></h1>
                    <br>
                    <h2>Kijk waar je wilt. Altijd opzegbaar.</h2>
                    <br><br><br>
                    <a href="registratie.php" type="button" class="btn-lg text-decoration-none" style="color:#fff; background-color: #02ee5a; border-color: #02ee5a; height: 5vh;">registreren</a>
                    <br><br><br>
                </div>
                <div class="text-end IntroBoxBody">
                    <h1><b>Kijk op je tv.</b></h1>
                    <br>
                    <h2>Kijk op smart-tv's, PlayStation, Xbox, Chromecast, Apple TV, blu-rayspelers en meer.</h2>
                </div>
                <div class="text-start IntroBoxBody">
                    <h1><b>Download series die je offline wilt kijken.</b></h1>
                    <br>
                    <h2>Sla je favorieten eenvoudig op zodat je altijd wat kunt kijken.</h2>
                </div>
                <div class="text-end IntroBoxBody">
                    <h1><b>Kijk overal.</b></h1>
                    <br>
                    <h2>Stream onbeperkt series en films op je telefoon, tablet, laptop en tv, zonder meer te betalen.</h2>
                </div>

            </div>
        </div>
    </main>
    <?php }
  ?>


<?php
require_once 'partial/footer.php';
?>  