<?php
require_once 'partial/header.php';
require_once 'backend/class/series.php';

$GrabHistory = new series();

$InsertHistory = $GrabHistory->setHistory($_GET['serie']);
//hierin word de serie ID gepakt uit de web balk en weggeschreven in de geschiedenis tabel in de database

?>
    <main>
        <!-- standaard youtube embed -->
        <div class="videostream ratio ratio-16x9">
            <iframe
              class="embed-responsive-item"
              src="https://www.youtube.com/embed/x0E39ug6t70" 
              title="YouTube video player" 
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
              allowfullscreen>
            </iframe>
        </div>
    </main>

<?php
require_once 'partial/footer.php';
?>