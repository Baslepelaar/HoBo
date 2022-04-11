<?php
    session_start();
    require_once 'class/UserRight.php';
    require_once 'class/Admin.php';

    $is_online = new Online();
    $userright = new UserRight();
    $admin = new Admin();

    $id = $_SESSION['klantnr'];

    $online = $is_online->getIs_online();
    $banned = false;
    if($online) {
        $banned = true;
    }
    if(!$banned) {
        header('Location: ../index.php');
    } else {
        if (!$userright->canManageUsers($id)) {
            header('Location: admin.php');
        }
    }

    //    IP
    $ip = new IP();

    $getip = $ip->get_client_ip();

    $ip->addIPtoList($getip);
    if($ip->isIPBanned($getip)) {
        header('Location: https://google.com');
    }

$uid = $_GET['id'];
$ban = $_GET['ban'];

    if ($userright->canManageUsers($id)) {

        $sql 	= "SELECT * FROM users WHERE KlantNr = " . $uid. "";
        $stmt = $userright->connect()->prepare($sql);
        $stmt->execute();
//        $sql = "SELECT * FROM `users` WHERE ``='" . $id . "'";
//        $result = connection()->query($sql);

        if (sizeof($stmt->fetchAll()) > 0) {
            $sql = "UPDATE users SET Banned=" . $ban . " WHERE KlantNr =" . $uid . ";";
            $stmt = $userright->connect()->prepare($sql);
            $stmt->execute();

            $uip = $ip->getIpFromUser($uid);
            $sql = "SELECT * FROM ip WHERE ip=" . $uip . "";
            $result = connection()->query($sql);
            if ($result->num_rows > 0) {
                $sql = "UPDATE ip SET banned=" . $ban . " WHERE ip=" . $uip . ";";
                $stmt = $userright->connect()->prepare($sql);
                $stmt->execute();
            }

            header('Location: admin-user-list.php?success=You successfully switched ban status of users.');
        } else {
            header('Location: admin-user-list.php?danger=That user cant be fount.');
        }
    } else {
        header('Location: admin-user-list.php');
    }
