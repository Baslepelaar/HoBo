<?php
require_once 'partial/header.php';
session_start();
include('backend/alert.php');

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
    <article class="col-md-10 col-sm-2 row" style="margin-left: 5vw; margin-top: 5vh; color: white;"><h2>Gallery</h2>
      <article class="col-md-3 col-sm-2 img1"><img src="img/image 1.jpg" style="height: 30vh; border-radius: 1vw;"></article>
      <article class="col-md-3 col-sm-2 img2"><img src="img/image 2.jpg" style="height: 30vh; border-radius: 1vw;"></article>
      <article class="col-md-3 col-sm-2 img3"><img src="img/image 3.jpg" style="height: 30vh; border-radius: 1vw;"></article>
      <article class="col-md-3 col-sm-2 img5"><img src="img/image 5.jpg" style="height: 30vh; border-radius: 1vw;"></article>
    </article>
  </section>
  </main>
</body>
<?php
require_once 'partial/footer.php';
?>  