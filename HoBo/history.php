<?php

require_once 'partial/header.php';
require_once 'backend/class/series.php';

$getHistory = new series();

$getUserHistory = $getHistory->getHistory(); //hiermee word de geschiedenis opgehaalt van de gebruiker
?>


<main>
    <section class="row w-100 h-100 justify-content-center">
        <article class="col-md-5 mt-5">
        <h1 style="color:#02ee5a"><b>Uw kijkgeschiedenis:</b></h1><br>
        <!-- ik heb hier handmatig de regel hierboven een kleur gegeven omdat het geen zin heeft om hiervor een klas aan te maken -->
            <?php 
            foreach($getUserHistory as $historyRow){ ?> <!-- een loop waarin elke rij aan gegevens worden geplaatst op de pagina -->
            <section class="post">
                <article class="info">
                <a href="<?php echo 'summary.php?serie=' . $historyRow->SerieID; ?>"> <!-- serieid word als variabele in de webadres balk geplaatst -->
                <?php
                    echo "<h3>$historyRow->SerieTitel</h3></a>
                        <h4>$historyRow->datum</h4>";
                ?>
                </article>
            </section>
            <?php } ?>
        </article>
    </section>
</main>

<?php
require_once 'partial/footer.php';
?>