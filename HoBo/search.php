<?php

require_once 'partial/header.php';
require_once 'backend/class/series.php';

$getSearch = new series();


if(isset($_POST['searchButton'])){
    $searchRequest = $getSearch->searchSerie($_POST['searchText']);
}

?>

<main>
    <section class="row w-100 h-100 justify-content-center">
        <article class="col-md-5 mt-5">
            <form id="searchForm" name="searchForm" method="POST">
                <input class="text-center mb-1" type="text" id="searchText" name="searchText" style="height: 5vh;" placeholder="Zoek serie" required>
                <input class="btn btn-primary btn-lg mt-2 col-md-12" type="submit" name="searchButton" value="zoek!" style="background-color: #02ee5a; border-color: #02ee5a; color:#000000; height: 5vh;">
            </form>
        </article>
    </section>
        <?php if(isset($_POST['searchButton'])){
            foreach($searchRequest as $searchHit){ ?>
            <section class="post mt-3">
                <article class="info">
                <a href="<?php echo 'summary.php?serie=' . $searchHit->SerieID; ?>">
                <?php
                    echo "<h3>$searchHit->SerieTitel</h3></a>";
                ?>
                </article>
            </section>
        <?php } } ?>
</main>

<?php
require_once 'partial/footer.php';
?>

