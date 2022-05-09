<?php
    require_once 'partial/header.php';
    require_once 'backend/class/User.php';

    $users = new User();

    $user = $users->getUser($id);

//    if(isset($_POST['verander'])) {
//        $users->verander($_POST);
//    }


?>
<!DOCTYPE html>
<html>
<head>
    <title>Hobo | Profiel</title>
    <link rel="stylesheet" href="css/back.css">
</head>
<body>
<div class="container ctpadding" style="background-color: #efefef;">
    <div class="row">
        <div class="col-sm-3">
            <div class="box-login">
                <?php foreach($user as $userdata){ ?>
                    <center><i class="fa-solid fa-circle-user" width="40%" class="img-circle" style="max-height: 100%;"></i></center>
                    <center><h4><strong><?php echo $userdata->Voornaam . ' ' . $userdata->Tussenvoegsel . ' ' . $userdata->Achternaam?> </strong></h4></center>
                    <ul class="fa-ul">

                        <li><i class="fa fa-calendar" aria-hidden="true"></i> Registered on <?php echo $userdata->Datum ?></li>
                    </ul>

                    <center><hr style="width: 80%;"></center>
                    <?php
                    if($userright->isAdmin($id)) {
                        $rank = $userright->getAdminRank($id);

                        if ($rank->Rank == '1') {
                            echo '<h5 style="margin-left: 30px;">HoBo <span class="label label-green">Eigenaar</span></h5><center><hr style="width: 80%;"></center>';
                        } elseif ($rank->Rank == '2') {
                            echo '<h5 style="margin-left: 30px;">HoBo <span class="label label-red">Admin</span></h5><center><hr style="width: 80%;"></center>';
                        }
                    }
                } ?>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="row">

                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="box-login" style="border-left: 4px solid #02ee5a; border-radius: 5px;">
                                <p style="font-size: 175%;"><i class="fa fa-lock" aria-hidden="true"></i> Verander uw wachtwoord</p>
                                <p>Verander uw wachtwoord, wees er zeker van dat het een <span style="color: #02ee5a;">sterk</span> wachtwoord is.</p>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="box-login" style="border-radius: 5px;">
                                <form id="password" class="form-horizontal" method="POST">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Oud:</label>
                                        <div class="col-sm-8">
                                            <input name="Old" class="form-control" id="pr_old" placeholder="Old password" type="password" / disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Nieuw:</label>
                                        <div class="col-sm-8">
                                            <input name="New" class="form-control" id="pr_new" placeholder="New password" type="password" / disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Repeat:</label>
                                        <div class="col-sm-8">
                                            <input name="Repeat New" class="form-control" id="pr_re_new" placeholder="Repeat new password" type="password" / disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-8">
                                            <button type="submit" name="verander" class="btn" style="background-color: #02ee5a; color: white;">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<?php
require_once 'partial/footer.php';
?>