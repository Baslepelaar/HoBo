<?php
require_once '../class/DelSerie.php';
if($_GET['change'] == 'delete'){
    $change = new DelSerie();
    $change->delSerie($_GET['user'], $_GET['serie']);
}

if($_GET['change'] == 'restore'){
    $change = new DelSerie();
    $change->restoreSerie($_GET['user'], $_GET['serie']);
}


?>