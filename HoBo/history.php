<?php

require_once 'partial/header.php';
require_once 'backend/class/series.php';

$getHistory = new series();

$getUserHistory = $getHistory->getHistory();
?>


<main>
    <section class="row w-100 h-100 justify-content-center">
        <article class="col-md-5 mt-5">
            <?php 
            foreach($getUserHistory as $historyRow){ ?>
            <section class="post">
                <article class="info">
                <a href="<?php echo 'summary.php?serie=' . $historyRow->SerieID; ?>">
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