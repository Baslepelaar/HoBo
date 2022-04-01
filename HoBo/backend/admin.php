<?php
    require_once 'partial/header.php';

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
        header('Location: index.php');
    } else {
        if (!$userright->canUseStaffPanel($id)) {
            header('Location: ../index.php');
        }
    }

    $ip = new IP();

    $getip = $ip->get_client_ip();

    $ip->addIPtoList($getip);
    if($ip->isIPBanned($getip)) {
        header('Location: https://google.com');
    }

?>

    <div class="container ctpadding" style="background-color: #efefef;">
        <!-- Add Admins Modal -->
        <div class="modal fade" id="staffModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><strong>Add Staff</strong></h4>
                    </div>
                    <form id="addstaff" class="form-horizontal" method="GET">
                        <div class="modal-body">
                            <div style="margin-left: 5%; margin-right: 5%;">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input name="Email" class="form-control" id="staff_email" placeholder="Email" type="email" / required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $('#addstaff').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "core/mtp_add_staff.php",
                    data: {email: " "+$('#staff_email').val()},
                    success: function(data){
                        if(data === 'mtp_add_staff_success'){
                            document.location.href = '?success=Staff member added, you can now give him a rank and permissions.';
                        }
                        else {
                            document.location.href = data;
                        }
                    }
                });
            });
        </script>
        <!-- Add Staff Modal End -->




        <div class="row">
            <div class="col-sm-3">
                <div class="box-login">
                    <center><h4><strong>Live Chat</strong></h4></center>
                    <center><hr style="width: 90%;"></center>

                    <center><h4><a href="https://dashboard.tawk.to" target="_blank" <span class="label label-info">Dashboard</span></a></h4></center>
                </div>



                <div class="box-login">
                    <center><h4><strong>Stats</strong></h4></center>
                    <center><hr style="width: 90%;"></center>

                    <center><h1><i class="fa fa-user" aria-hidden="true"></i></h1>
                        <h5>Active Users</h5>
                        <h4><strong><?php echo countUsers(); ?></strong></h4></center>
                    <center><hr style="width: 60%;"></center>

                    <center><h1><i class="fa fa-user-times" aria-hidden="true"></i></h1>
                        <h5>Banned Users</h5>
                        <h4><strong><?php echo countBannedUsers(); ?></strong></h4></center>
                    <center><hr style="width: 60%;"></center>

                    <center><h1><i class="fa fa-ticket" aria-hidden="true"></i></h1>
                        <h5>Active Parks</h5>
                        <h4><strong><?php echo countActiveParks(); ?></strong></h4></center>
                    <center><hr style="width: 60%;"></center>

                    <center><h1><i class="fa fa-plus-circle" aria-hidden="true"></i></h1>
                        <h5>Park Request</h5>
                        <h4><strong><?php echo countRequestParks(); ?></strong></h4></center>
                    <center><hr style="width: 60%;"></center>

                    <center><h1><i class="fa fa-square-o" aria-hidden="true"></i></h1>
                        <h5>Active Park Posts</h5>
                        <h4><strong><?php echo countPostParks(); ?></strong></h4></center>
                    <center><hr style="width: 60%;"></center>

                    <center><h1><i class="fa fa-plus-circle" aria-hidden="true"></i></h1>
                        <h5>Park Post Resuests</h5>
                        <h4><strong><?php echo countRequestPostParks(); ?></strong></h4></center>
                    <center><hr style="width: 60%;"></center>
                </div>
            </div>
            <div class="col-sm-9">
                <?php include('inc/alert.php'); ?>
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
                                        if(getMaintenance() == '1') {
                                            echo ' <span class="label label-danger">Active</span>';
                                        }
                                        else {
                                            echo ' <span class="label label-success">Unactive</span>';
                                        }
                                        ?>										</p>
                                </td>
                                <td>
                                    <?php
                                    if(canManageSettings($_SESSION['id'])) {
                                        if(getMaintenance() == '1') {
                                            echo '<a href="core/maintenance-mode.php?data=0"><span class="label label-success">Deactivate</span><a>';
                                        }
                                        else {
                                            echo '<a href="core/maintenance-mode.php?data=1"><span class="label label-danger">Activate</span><a>';
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
                    <h4 style="margin-left: 5%;"><strong>Park Requests</strong></h4>
                    <center><hr style="width: 90%;"></center>
                    <div style="margin-left: 5%; margin-right: 5%;">
                        <?php
                        if(canManageparkRequests($_SESSION['id'])) {
                            require_once('core/ini.php');

                            $sql 	= "SELECT * FROM `parks` WHERE `deleted`='0' AND `reviewed`='0' ORDER BY id DESC";
                            $result = connection()->query($sql);
                            if($result->num_rows > 0){

                                echo '<table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Park Name</th>
                                                    <th>Park IP</th>
                                                    <th>Owner</th>
                                                    <th>Social Media</th>
                                                    <th>Date</th>
                                                    <th>Reaction</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                                while($row = $result->fetch_assoc())
                                {
                                    $status = json_decode(file_get_contents('https://api.mcsrvstat.us/1/'.$row['ip'].''));
                                    $offline = $status->offline;
                                    if(!$offline){
                                        $online = $status->players->online;
                                        $max = $status->players->max;
                                    }
                                    echo '<tr>
                                                <td>'.$row['name'].'</td>
                                                <td>'.$row['ip'].' ';
                                    if(!$offline){
                                        echo '<span class="label label-success">'.$online.' / '.$max.'</span>';
                                    }
                                    else {
                                        echo '<span class="label label-danger">Server Offline</span>';
                                    }
                                    echo '	</td>
                                                <td><a href="users.php?'.$row['owner'].'">'.getFirstname($row['owner']).' '.getFamilyname($row['owner']).'</a></td>
                                                <td>';

                                    if(!empty($row['twitter'])){
                                        echo '<a href="'.$row['twitter'].'"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
                                    }
                                    if(!empty($row['facebook'])){
                                        echo ' <a href="'.$row['facebook'].'"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
                                    }
                                    if(!empty($row['youtube'])){
                                        echo ' <a href="'.$row['youtube'].'"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>';
                                    }
                                    if(!empty($row['website'])){
                                        echo ' <a href="'.$row['website'].'"><i class="fa fa-globe" aria-hidden="true"></i></a>';
                                    }

                                    echo '	</td>
                                                <td>'.$row['datum'].'</td>
                                                <td><a href="?park_id='.$row['id'].'&accept"><span class="label label-success">Accept</span></a> <a href="?park_id='.$row['id'].'&reject"><span class="label label-danger">Reject</span></a></td>
                                              </tr>';
                                }
                                echo '	</tbody>
                                          </table>';
                            }
                            else{
                                echo '<h5>There are currently no park requests...</h5>';
                            }
                        }
                        else{
                            echo '<h5>You are not allowed to manage the park requests. If this is wrong you can contact a site administrator.</h5>';
                        }
                        ?>						</div>
                </div>
                <div class="box-login" >
                    <h4 style="margin-left: 5%;"><strong>Post Requests</strong></h4>
                    <center><hr style="width: 90%;"></center>
                    <div style="margin-left: 5%; margin-right: 5%;">
                        <?php
                        if(canManagePosts($_SESSION['id'])) {
                            require_once('core/ini.php');

                            $sql 	= "SELECT * FROM `posts` WHERE `deleted`='0' AND `reviewed`='0' ORDER BY id DESC";
                            $result = connection()->query($sql);
                            if($result->num_rows > 0){

                                echo '<table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Park</th>
                                                    <th>Title</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                while($row = $result->fetch_assoc())
                                {
                                    echo '<tr>
                                                <td><a href="park.php?id='.$row['park_id'].'"><img src="'.getParklogo($row['park_id']).'" height="20px" /> '.getParkname($row['park_id']).'</a>';
                                    if (isParkDelted($row['park_id'])) {
                                        echo ' <span class="label label-danger">Park Deleted</span>';
                                    }
                                    echo '	</td>
                                                <td>'.$row['post_title'].'</td>
                                                <td>'.$row['posted_on'].'</td>
                                                <td><a href="article.php?id='.$row['id'].'"><span class="label label-info">Read post</span></a></td>
                                              </tr>';
                                }
                                echo '	</tbody>
                                          </table>';
                            }
                            else{
                                echo '<h5>There are currently no post requests...</h5>';
                            }
                        }
                        else{
                            echo '<h5>You are not allowed to manage the post requests. If this is wrong you can contact a site administrator.</h5>';
                        }

                        ?>						</div>
                </div>
                <div class="box-login" >
                    <h4 style="margin-left: 5%;"><strong>MineThemepark Staff</strong>
                        <?php
                        if(canManageStaff($_SESSION['id'])) {
                            echo '<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#staffModal" style="margin-left: 20px;">Add staff</button>';
                        }
                        ?>						</h4>
                    <center><hr style="width: 90%;"></center>
                    <div style="margin-left: 5%; margin-right: 5%;">
                        <?php
                        if(canManageStaff($_SESSION['id'])) {
                            require_once('core/ini.php');

                            $sql 	= "SELECT * FROM `mtp_staff` ORDER BY id";
                            $result = connection()->query($sql);
                            if($result->num_rows > 0){

                                echo '<table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Minecraft</th>
                                                    <th>Rank</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                while($row = $result->fetch_assoc())
                                {
                                    echo '<tr>
                                                <td><a href="users.php?id='.$row['user_id'].'">'.getFirstname($row['user_id']).' '.getFamilyname($row['user_id']).'</a></td>
                                                <td><img src="https://minotar.net/avatar/'.getMinecraft($row['user_id']).'" height="20px" /> '.getMinecraft($row['user_id']).'</td>
                                                <td>'.getRank($row['rank']).'</td>
                                                <td><a href="staff-manage.php?id='.$row['user_id'].'"><span class="label label-info">Manage Staff</span></a> <a href="core/staff-del-member.php?id='.$row['user_id'].'" style="margin-left: 10px;"><span class="label label-danger">Delete</span></a></td>
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
                <div class="box-login" >
                    <h4 style="margin-left: 5%;"><strong>Users</strong></h4>
                    <center><hr style="width: 90%;"></center>
                    <div style="margin-left: 5%; margin-right: 5%;">
                        <?php
                        if(canManageUsers($_SESSION['id'])) {
                            echo '<h5>Go to the users list... <a href="staff-users-list.php"><span class="label label-info">Click here</span></a></h5>';
                        }
                        else {
                            echo '<h5>You are not allowed to manage users. If this is wrong you can contact a site administrator.</h5>';
                        }

                        ?>
                    </div>
                </div>
                <div class="box-login" >
                    <h4 style="margin-left: 5%;"><strong>MineThemepark Posts</strong>
                        <?php
                        if(canWritePost($_SESSION['id'])) {
                            echo '<a href="add-mtp-post.php" style="margin-left: 20px;"><span class="btn btn-success btn-sm" >Write Post</span></a>';
                        }
                        ?>						</h4>
                    <center><hr style="width: 90%;"></center>
                    <div style="margin-left: 5%; margin-right: 5%;">
                        <?php
                        if(canManagePosts($_SESSION['id'])) {
                            $sql 	= "SELECT * FROM `minethemepark_posts` ORDER BY id DESC";
                            $result = connection()->query($sql);
                            if($result->num_rows > 0){
                                echo '<table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Date</th>
                                                    <th>Likes</th>
                                                    <th>Comments</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                while($row = $result->fetch_assoc())
                                {
                                    echo '<tr>
                                                <td><a href="minethemepark.php?id='.$row['id'].'" class="park-link">'.$row['post_title'].'</a>';
                                    if($row['deleted'] == '1'){
                                        echo ' <span class="label label-danger">Deleted</span>';
                                    }
                                    echo '	</td>
                                                <td>'.$row['posted_on'].'</td>
                                                <td>'.countLikesMTP($row['id']).'</td>
                                                <td>'.countCommentsMTP($row['id']).'</td>
                                                <td><a href="edit-mtp-post.php?post='.$row['id'].'"><span class="label label-info">Edit</span></a>';
                                    if($row['deleted'] == '1'){
                                        echo '<a href="core/del_mtp_post.php?post='.$row['id'].'&data=0" style="margin-left: 10px;"><span class="label label-success">Post again</span></a>';
                                    }
                                    else {
                                        echo '<a href="core/del_mtp_post.php?post='.$row['id'].'&data=1" style="margin-left: 10px;"><span class="label label-danger">Delete</span></a>';
                                    }
                                    echo '	</td>
                                              </tr>';
                                }
                                echo '	</tbody>
                                          </table>';
                            }
                            else {
                                echo '<h5>There are currently no posts uploaded.</h5>';
                            }
                        }
                        else {
                            echo '<h5>You are not allowed to manage posts. If this is wrong you can contact a site administrator.</h5>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once 'partial/footer.php'; ?>
