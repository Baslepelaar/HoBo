<?php
require_once '../class/Admin.php';
if($_GET['change'] == 'delete'){
    $change = new Admin();
    $change->deleteAdmin($_GET['user'], $_GET['admin']);
}


?>