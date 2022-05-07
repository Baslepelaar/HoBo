<?php
require_once 'partial/header.php';

$_SESSION = array(); //hele sessie variable in een lege array stoppen

session_destroy(); //volledige sessie vernietigen
header( "refresh:2; url=index.php" ); 
?>

<main>
        <div class="megaBox bg-image" style="height: 100vh; background-size: cover;">
            <div class="mt-5 flex-row justify-content-center introMain">
                <div class="mt-1 IntroBoxBody text-center" >
                <br><br><br>
                    <h1><b>U bent uitgelogd! Tot de volgende keer!<b></h1>
                </div>
            </div>
        </div>
    </main>

<?php
require_once 'partial/footer.php';
header( "refresh:2; url=intro.php" ); 
?>
