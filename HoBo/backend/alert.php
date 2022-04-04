<?php
/* Alert */
//session_start();
if(isset($_GET['login']) && $_GET['login'] == 'success') {
    ?>
    <div class="alert alert-success alert-dismissable fade in">
        <a href="?" class="close" data-dismiss="alert" aria-label="close">&times;</a>U bent ingelogd
    </div>
<?php
}
if(isset($_GET["login"]) && $_GET['login'] == 'info') {
    ?>
    <div class="alert alert-info alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
<?php	}
if(isset($_GET["login"]) && $_GET['login'] == 'warning') {
    ?>
    <div class="alert alert-warning alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
<?php	}
if(isset($_GET["login"]) && $_GET['login'] == 'danger') {
    ?>
    <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Kon niet inloggen, gebruikersnaam of wachtwoord incorrect
    </div>
    <?php
}
?>