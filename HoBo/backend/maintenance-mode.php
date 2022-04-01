<?php
session_start();

require_once 'class/Online.php';
require_once 'class/UserRight.php';

$is_online = new Online();
$userright = new UserRight();

if(!$is_online->getIs_online()) {
    header('Location: ../index.php');
}

$data = $_GET['data'];

if($userright->canManageSettings($_SESSION['klantnr'])) {
    $sql = "SELECT * FROM settings WHERE variable = 'maintenance'";
    $result = $userright->connect()->prepare($sql);
    $result->execute();
//    die(var_dump($result->fetchAll(PDO::FETCH_OBJ)));

    if(sizeof($result->fetchAll()) > 0){
        $sql = "UPDATE settings SET data = :data WHERE variable = 'maintenance'";
        $stmt = $userright->connect()->prepare($sql);
        $stmt->bindParam(":data", $data);
        $stmt->execute();

        header('Location: admin.php?success=The maintenance mode is switched.');
    }
    else {
        header('Location: admin.php?danger=Something went wrong.');
    }
}
else {
    header('Location: admin.php');
}
?>