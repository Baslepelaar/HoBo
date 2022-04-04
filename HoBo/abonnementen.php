<?php
require_once 'partial/header.php';
?>
<body>
    <main>
        <section class="row w-100 h-100 justify-content-center">
        <article class="col-md-3 forum mt-5 p-4 ">
            <div class="card" style="width: 18rem; background-color: grey; border-radius: 1vw;" >
                <img class="card-img-top" src="img/logo.png" alt="Basis abonnement" style="background-color: white; border-top-left-radius: 1vw; border-top-right-radius: 1vw;">
                <div class="card-body">
                    <h5 class="card-title text-center">Basis</h5>
                    <p class="card-text" style="margin-top: 3vh;"><i class="bi bi-dot"></i>Maximun devices: 1</p>
                    <p class="card-text"><i class="bi bi-dot"></i>Stream kwaliteit: 10</p>
                    <div class="text-center mt-5 mb-3">
                        <input type="submit" class="btn btn-primary" style="background-color: #02ee5a; border-color: #02ee5a; height: 5vh;" name="abonnement" value="€5.00 p/m">
                    </div>
        </article>
        <article class="col-md-3 forum mt-5 p-4">
            <div class="card" style="width: 18rem; background-color: gold; border-radius: 1vw;">
                <img class="card-img-top" src="img/logo.png" alt="Extra abonnement" style="background-color: white; border-top-left-radius: 1vw; border-top-right-radius: 1vw;">
                <div class="card-body">
                <h5 class="card-title text-center">Extra</h5>
                <p class="card-text" style="margin-top: 3vh;"><i class="bi bi-dot"></i>Maximun devices: 2</p>
                <p class="card-text"><i class="bi bi-dot"></i>Stream kwaliteit: 20</p>
                <div class="text-center mt-5 mb-3">
                    <input type="submit" class="btn btn-primary" style="background-color: #02ee5a; border-color: #02ee5a; height: 5vh;" name="abonnement" value="€7.50 p/m">
                </div>
                <div class="card" style="width: 18rem; background-color: #00aeff; border-radius: 1vw; border: 0px solid #00aeff;">
                </div>
        </article>
        <article class="col-md-3 forum mt-5 p-4">
            <div class="card" style="width: 18rem; background-color: #00aeff; border-radius: 1vw; border: 0px solid #00aeff;">
                <img class="card-img-top" src="img/logo.png" alt="Platinum abonnement" style="background-color: green; border-top-left-radius: 1vw; border-top-right-radius: 1vw;">
                <div class="card-body">
                    <h5 class="card-title text-center">Platinum</h5>
                    <p class="card-text" style="margin-top: 3vh;"><i class="bi bi-dot"></i>Maximun devices: 5</p>
                    <p class="card-text"><i class="bi bi-dot"></i>Stream kwaliteit: 50</p>
                    <div class="text-center mt-5 mb-3">
                    <input type="submit" class="btn btn-primary" style="background-color: #02ee5a; border-color: #02ee5a; height: 5vh;" name="abonnement" value="€10.00 p/m">
                </div>
        </article>
        </section>
      </article>
    </main>
</body>
<?php
require_once 'partial/footer.php';
?>  