<?php
require_once 'partial/header.php';
require_once 'backend/class/Series.php';
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
$serie = New Serie();

?>

<body>
    <main>
    <article class="bg-image" style="background-image: url('img/SW-banner.png');height: 100vh; background-size: cover; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));
      mask-image: linear-gradient(to bottom, rgba), rgba(0,0,0,0));"></article>
    <section class="row w-100 h-100 card-img-overlay">
        <article class="container mt-5">
            <article class="col-md-4 logo" style="margin-left: 5vw; margin-top: 5vh; color: white;"><h1>Star Wars: The Rise of Skywalker</h1></article>
            <article class="col-md-5 col-sm-2 filmtekst" style="margin-left: 5vw; margin-top: 5vh;">
                <p class="filmtext" style="font-size: 1.5rem; color: white;">Star Wars is een Amerikaanse epische space-opera-filmserie bedacht door George Lucas
                en ontwikkeld door zijn bedrijf Lucasfilm. Het epos bestaat uit drie afgeronde trilogieën,
                twee losstaande films, twee live-actionseries, meerdere animatieseries en meerdere stripreeksen.
                </p>
            </article>
            <article class="col-md-5 col-sm-2 descriptie" style="margin-left: 5vw; margin-top: 5vh;">
                <p class="filmtext" style="font-size: 1.5rem; color: white;"><i class="bi bi-star-fill" style="color: green;"></i><i class="bi bi-star-fill" style="color: green;"></i><i class="bi bi-star-fill" style="color: green;"></i><i class="bi bi-star-fill" style="color: green;"></i><i class="bi bi-star-half" style="color: green;"></i></i> 97 recenties
              | 2019 | Sci-fi/Actie | 2 u 22 m</p>
            </article>
            <article class="col-md-5 col-sm-2 filmtekst" style="margin-left: 5vw; margin-top: 5vh;">
            <input type="submit" class="btn btn-primary btn-lg" style="background-color: #02ee5a; border-color: #02ee5a; height: 5vh;" name="abonnement" value="Begin met kijken">
    </article>
    <article class="col-md-10 justify-content-center" style="margin-left: 5vw; margin-top: 5vh; color: white;"><h2>Series</h2>
    <?php foreach($post->getSeries() as $serie){ ?>
          <article class="info" style="margin-top: 3vw; background-color: lightblue;">
          <h1><?php echo $serie->SerieTitel; ?></h1>
          <?php } ?>
    </article>
  </section>
  </main>
</body>
<?php
require_once 'partial/footer.php';
?>