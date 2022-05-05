<?php

require_once 'partial/header.php';
require_once 'backend/class/series.php';

$getSeries = new Series();

$series = $getSeries->getSerie();

?>

<main>
    <?php 
      foreach($series as $serieRow){ ?>
      <section class="post">
        <article class="info">
          <a href="<?php echo 'summary.php?serie=' . $serieRow->SerieID; ?>">
          <?php
            echo "<h3>$serieRow->SerieTitel</h3></a>";
          ?>
        </article>
      </section>
      <?php } ?>
</main>
<?php
require_once 'partial/footer.php';
?>