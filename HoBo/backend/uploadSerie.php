<?php
require_once 'partial/header.php';

session_start();
require_once 'class/DelSerie.php';
require_once 'class/Admin.php';
require_once 'class/Maintenance.php';
require_once 'class/upload.php';

$is_online = new Online();
$userright = new UserRight();
$dserie = new DelSerie();
$admin = new Admin();
$maintenance = new Maintenance();
$uploadVid = new uploadVideo();

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

if(isset($_POST['upload_video'])){
	$uploadVid->uploadVideo($_POST, $id);
	
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
                    <section class="form">
                        <form method="POST" enctype="multipart/form-data">
                            <label for="title" id="title">Serie Title: </label>
                            <input type="text" name="title" required><br>
                            <label for="title" id="imdb">imdb link: </label>
                            <input type="text" name="imdb" required><br>
                            <label for="film" id="film">Upload file (mp4, mov or mkv):</label>
                            <input type="file" name="video" id="video">
                            <input type="submit" name="upload_video" value="upload!">
                        </form>
    	            </section>
                </div>

<?php require_once 'partial/footer.php'; ?>