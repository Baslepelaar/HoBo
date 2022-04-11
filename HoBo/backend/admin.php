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

    $online = $is_online->getIs_online();
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

    $ip->addIPtoList($getip);
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
                    <h4 style="margin-left: 5%;"><strong>Settings</strong></h4>
                    <center><hr style="width: 90%;"></center>
                    <div style="margin-left: 5%; margin-right: 5%;">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th>Manage</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <p>Maintenance mode is now
                                        <?php
                                        if($maintenance->getMaintenance() == '1') {
                                            echo ' <span class="label label-danger">Active</span>';
                                        }
                                        else {
                                            echo ' <span class="label label-success">Unactive</span>';
                                        }
                                        ?>										</p>
                                </td>
                                <td>
                                    <?php
                                    if($userright->canManageSettings($id)) {
                                        if($maintenance->getMaintenance() == '1') {
                                            echo '<a href="maintenance-mode.php?data=0"><span class="label label-success">Deactivate</span><a>';
                                        }
                                        else {
                                            echo '<a href="maintenance-mode.php?data=1"><span class="label label-danger">Activate</span><a>';
                                        }
                                    }
                                    else {
                                        echo '<p>You dont have permission to manage settings.</p>';
                                    }

                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-login" >
                    <h4 style="margin-left: 5%;"><strong>Hobo Admin</strong>
                        <?php
                        if($userright->canManageStaff($id)) {
                            echo '<h4 class="modal-title"><strong>Add Admin</strong></h4>
                                <form id="addstaff" class="form-horizontal" method="post">
                                    <div class="modal-body">
                                        <div style="margin-left: 5%; margin-right: 5%;">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input name="Email" class="form-control" id="staff_email" placeholder="Email" type="email" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger" name="addadmin">Add</button>
                                    </div>
                                </form>';
                        }
                        ?>						</h4>
                    <center><hr style="width: 90%;"></center>
                    <div style="margin-left: 5%; margin-right: 5%;">
                        <?php
                        if($userright->canManageStaff($id)) {
//                            require_once('core/ini.php');
                            ;
                            ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Rank</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($admin->getAdmin() as $singleAdmin){ ?>
                                <tr>
                                    <td><a href="users.php?id="><?= $singleAdmin->Voornaam . " " .  $singleAdmin->Achternaam . ", " . $singleAdmin->Tussenvoegsel  ?></a></td>
                                    <td><?= $singleAdmin->Rank ?></td>
                                    <td><a href="staff-manage.php?id=<?= $singleAdmin->User_ID ?>"><span class="label label-info">Manage Staff</span></a> <a href="core/staff-del-member.php?id=<?= $singleAdmin->User_ID ?>" style="margin-left: 10px;"><span class="label label-danger">Delete</span></a></td>
                                </tr>
                            <?php } }?>
                            </tbody>
                        </table>

                </div>
                <div class="box-login" >
                    <h4 style="margin-left: 5%;"><strong>Users</strong></h4>
                    <center><hr style="width: 90%;"></center>
                    <div style="margin-left: 5%; margin-right: 5%;">
                        <?php
                        if($userright->canManageUsers($id)) {
                            echo '<h5>Go to the users list... <a href="admin-user-list.php"><span class="label label-info">Click here</span></a></h5>';
                        }
                        else {
                            echo '<h5>You are not allowed to manage users. If this is wrong you can contact a site administrator.</h5>';
                        }

                        ?>
                    </div>
                </div>
<!--                <div class="box-login" >-->
<!--                    <h4 style="margin-left: 5%;"><strong>MineThemepark Posts</strong>-->
<!--                        --><?php
//                        if(canWritePost($_SESSION['id'])) {
//                            echo '<a href="add-mtp-post.php" style="margin-left: 20px;"><span class="btn btn-success btn-sm" >Write Post</span></a>';
//                        }
//                        ?><!--						</h4>-->
<!--                    <center><hr style="width: 90%;"></center>-->
<!--                    <div style="margin-left: 5%; margin-right: 5%;">-->
<!--                        --><?php
//                        if(canManagePosts($_SESSION['id'])) {
//                            $sql 	= "SELECT * FROM `minethemepark_posts` ORDER BY id DESC";
//                            $result = connection()->query($sql);
//                            if($result->num_rows > 0){
//                                echo '<table class="table table-striped">
//                                            <thead>
//                                                <tr>
//                                                    <th>Title</th>
//                                                    <th>Date</th>
//                                                    <th>Likes</th>
//                                                    <th>Comments</th>
//                                                    <th>Manage</th>
//                                                </tr>
//                                            </thead>
//                                            <tbody>';
//                                while($row = $result->fetch_assoc())
//                                {
//                                    echo '<tr>
//                                                <td><a href="minethemepark.php?id='.$row['id'].'" class="park-link">'.$row['post_title'].'</a>';
//                                    if($row['deleted'] == '1'){
//                                        echo ' <span class="label label-danger">Deleted</span>';
//                                    }
//                                    echo '	</td>
//                                                <td>'.$row['posted_on'].'</td>
//                                                <td>'.countLikesMTP($row['id']).'</td>
//                                                <td>'.countCommentsMTP($row['id']).'</td>
//                                                <td><a href="edit-mtp-post.php?post='.$row['id'].'"><span class="label label-info">Edit</span></a>';
//                                    if($row['deleted'] == '1'){
//                                        echo '<a href="core/del_mtp_post.php?post='.$row['id'].'&data=0" style="margin-left: 10px;"><span class="label label-success">Post again</span></a>';
//                                    }
//                                    else {
//                                        echo '<a href="core/del_mtp_post.php?post='.$row['id'].'&data=1" style="margin-left: 10px;"><span class="label label-danger">Delete</span></a>';
//                                    }
//                                    echo '	</td>
//                                              </tr>';
//                                }
//                                echo '	</tbody>
//                                          </table>';
//                            }
//                            else {
//                                echo '<h5>There are currently no posts uploaded.</h5>';
//                            }
//                        }
//                        else {
//                            echo '<h5>You are not allowed to manage posts. If this is wrong you can contact a site administrator.</h5>';
//                        }
//                        ?>
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>

<?php require_once 'partial/footer.php'; ?>
