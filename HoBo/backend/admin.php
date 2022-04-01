<?php
    require_once 'partial/header.php';

    session_start();
    require_once 'class/UserRight.php';

    $is_online = new Online();
    $userright = new UserRight();

    $id = $_SESSION['klantnr'];

    $online = $is_online->getIs_online();
    $banned = false;
    if($online) {
        $banned = true;
    }
    if(!$banned) {
        header('Location: index.php');
    } else {
        if (!$userright->canUseStaffPanel($id)) {
            header('Location: index.php');
        }
    }

    $ip = new IP();

    $getip = $ip->get_client_ip();

    $ip->addIPtoList($getip);
    if($ip->isIPBanned($getip)) {
        header('Location: https://google.com');
    }

?>

	<main>

	</main>

<?php require_once 'partial/footer.php'; ?>
