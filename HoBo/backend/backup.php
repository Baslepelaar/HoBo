<?php
//                            $sql 	= "SELECT * FROM userrights ORDER BY ID";
//                            $result = connection()->query($sql);
//                            if($result->num_rows > 0){
//
//                                echo '<table class="table table-striped">
//                                            <thead>
//                                                <tr>
//                                                    <th>Name</th>
//                                                    <th>Rank</th>
//                                                    <th>Manage</th>
//                                                </tr>
//                                            </thead>
//                                            <tbody>';
//                                while($row = $result->fetch_assoc())
//                                {
//                                    echo '<tr>
//                                                <td><a href="users.php?id='.$row['user_id'].'">'.getFirstname($row['user_id']).' '.getFamilyname($row['user_id']).'</a></td>
//                                                <td><img src="https://minotar.net/avatar/'.getMinecraft($row['user_id']).'" height="20px" /> '.getMinecraft($row['user_id']).'</td>
//                                                <td>'.getRank($row['rank']).'</td>
//                                                <td><a href="staff-manage.php?id='.$row['user_id'].'"><span class="label label-info">Manage Staff</span></a> <a href="core/staff-del-member.php?id='.$row['user_id'].'" style="margin-left: 10px;"><span class="label label-danger">Delete</span></a></td>
//                                              </tr>';
//                                }
//                                echo '	</tbody>
//                                          </table>';
//                            }
//                            else{
//                                echo '<h5>There is nog staff to manage...</h5>';
//                            }
//                        }
//                        else{
//                            echo '<h5>You are not allowed to manage MineThemepark staff. If this is wrong you can contact a site administrator.</h5>';
//                        }
//
//                        ?>
<!--                    </div>-->
