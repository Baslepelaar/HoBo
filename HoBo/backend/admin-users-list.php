<?php
require_once 'partial/header.php';

session_start();
require_once 'class/UserRight.php';
require_once 'class/Admin.php';
require_once 'class/Maintenance.php';

$is_online = new Online();
$userright = new UserRight();
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

                    <center><h1><i class="fa fa-ticket" aria-hidden="true"></i></h1>
                        <h5>Series</h5>
                        <h4><strong><?php echo $admin->countSeries(); ?></strong></h4></center>
                    <center><hr style="width: 60%;"></center>
                    <center><h1><i class="fa fa-ticket" aria-hidden="true"></i></h1>
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
                    <h4 style="margin-left: 5%;"><strong>Users</strong></h4>
                    <center><hr style="width: 90%;"></center>
                    <div style="margin-left: 5%; margin-right: 5%;">
                        <?php
                        if($userright->canManageUsers($id)) {

                            $sql 	= "SELECT * FROM users ORDER BY KlantNr";
                            $stmt = $this->connect()->prepare($sql);
                            $stmt->execute();
                            $stmt->fetchAll(PDO::FETCH_OBJ);
                            if($stmt->num_rows > 0){

                                echo '<table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Active</th>
                                                    <th>Date</th>
                                                    <th>Ban</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                while($row = $result->fetch_assoc())
                                {
                                    echo '<tr>
                                                <td><a href="users.php?id='.$row['id'].'" class="park-link">'.getFirstname($row['id']).' '.getFamilyname($row['id']).'</a>';
                                    if(isStaff($row['id'])){
                                        echo ' <span class="label label-danger">Staff</span>';
                                    }
                                    echo '	</td>
                                                <td>'.$row['email'].'</td>
                                                <td><img src="https://minotar.net/avatar/'.getMinecraft($row['id']).'" height="20px" /> '.getMinecraft($row['id']).'</td>
                                                <td>';
                                    if($row['active'] == '1'){
                                        echo '<span class="label label-success">Active</span>';
                                    }
                                    else {
                                        echo '<span class="label label-danger">Inactive</span>';
                                    }
                                    echo ' 	</td>
                                                <td>'.$row['datum'].'</td>
                                                <td>';
                                    if($row['banned'] == '1'){
                                        echo '<a href="core/users-ban.php?id='.$row['id'].'&ban=0"><span class="label label-danger">Unban</span></a>';
                                    }
                                    else {
                                        echo '<a href="core/users-ban.php?id='.$row['id'].'&ban=1"><span class="label label-danger">Ban</span></a>';
                                    }
                                    echo '	</td>
                                              </tr>';
                                }
                                echo '	</tbody>
                                          </table>';
                            }
                            else{
                                echo '<h5>There is nog staff to manage...</h5>';
                            }
                        }
                        else{
                            echo '<h5>You are not allowed to manage MineThemepark staff. If this is wrong you can contact a site administrator.</h5>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'partial/footer.php'; ?>
