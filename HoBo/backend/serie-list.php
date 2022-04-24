<?php
require_once 'partial/header.php';

session_start();
require_once 'class/DelSerie.php';
require_once 'class/Admin.php';
require_once 'class/Maintenance.php';

$is_online = new Online();
$userright = new UserRight();
$dserie = new DelSerie();
$admin = new Admin();
$maintenance = new Maintenance();

$id = $_SESSION['klantnr'];

$online = $is_online->getIs_online($id);
$banned = false;
if($online) {
    $banned = true;
}
if(!$banned) {
    header('Location: ../index.php');
} else {
    if (!$userright->canUseStaffPanel($id)) {
        header('Location: ../index.php');
    }
}

//    add admins
if(isset($_POST['addadmin'])) {
    $admin->addAdmin($_POST);
}

//    IP
$ip = new IP();

$getip = $ip->get_client_ip();

$ip->addIPtoList($getip, $id);
if($ip->isIPBanned($getip)) {
    header('Location: https://google.com');
}

?>

<div class="container ctpadding" style="background-color: #efefef;">
    <div class="row">
        <div class="col-sm-3">
            <div class="box-login">
                <center><h4><strong>Stats</strong></h4></center>
                <center><hr style="width: 90%;"></center>

                <center><h1><i class="fa fa-user" aria-hidden="true"></i></h1>
                    <h5>Active Users</h5>
                    <h4><strong><?php echo $admin->countUsers(); ?></strong></h4></center>
                <center><hr style="width: 60%;"></center>

                <center><h1><i class="fa fa-user-times" aria-hidden="true"></i></h1>
                    <h5>Banned Users</h5>
                    <h4><strong><?php echo $admin->countBannedUsers(); ?></strong></h4></center>
                <center><hr style="width: 60%;"></center>

                <center><h1><i class="fa-solid fa-film"></i></h1>
                    <h5>Series</h5>
                    <h4><strong><?php echo $admin->countSeries(); ?></strong></h4></center>
                <center><hr style="width: 60%;"></center>
                <center><h1><i class="fa-solid fa-video"></i></h1>
                    <h5>Streams</h5>
                    <h4><strong><?php echo $admin->countStream(); ?></strong></h4></center>
                <center><hr style="width: 60%;"></center>
            </div>
        </div>
        <div class="col-sm-9">
            <!--                --><?php //include('inc/alert.php'); ?>
            <div class="box-login" >
                <h5 style="margin-left: 5%;"><a href="admin.php" class="park-link"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</strong></a></h5>
            </div>

            <div class="box-login" >
                <h4 style="margin-left: 5%;"><strong>Series</strong></h4>
                <center><hr style="width: 90%;"></center>
                <div style="margin-left: 5%; margin-right: 5%;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titel</th>
                                <th>IMD</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($admin->getSeries() as $singleSerie){ ?>
                            <tr>
                                <td><a href="serie.php?id="><?= $singleSerie->SerieTitel ?></a></td>
                                <td><a href="<?= $singleSerie->IMDBLink?>"><?= $singleSerie->IMDBLink ?></a></td>
                                <td>
                                    <?php
//                                    $dserie->delSerie();
                                    if($singleSerie->Actief == '1') {
                                        echo '<a href="delSerie.php?serie='.$singleSerie->SerieID.'&data=1" style="margin-left: 10px;"><span class="label label-danger">Delete</span></a>';
                                    }
                                    else {
                                        echo '<a href="DelSerie.php?serie='.$singleSerie->SerieID.'&data=0" style="margin-left: 10px;"><span class="label label-success">Post again</span></a>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table
                </div>
            </div>



    </div>
</div>

<?php require_once 'partial/footer.php'; ?>
