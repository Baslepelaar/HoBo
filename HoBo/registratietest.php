<?php
///* Background */
//
//$bg = array('bg-01.png', 'bg-02.png', 'bg-03.png', 'bg-04.png', );
//
//$i = rand(0, count($bg)-1);
//$selectedBg = "$bg[$i]";

session_start();
include('backend/functions.php');
$online = false;
if(is_online())
{
    $online = true;
}
if($online) {
    header('Location: index.php');
}

$user_ip = get_client_ip();

addIPtoList($user_ip);
if(isIPBanned($user_ip)){
    header('Location: https://google.com');
}

require_once 'backend/class/Register.php';

$user = new Register();

$users = $user->getUsers();
var_dump($users);
if(isset($_POST['register'])) {
    $user->create($_POST);
}
?>
<!DOCTYPE html>
<html>
<head>

    <?php include('partial/header.php'); ?>
    <title>HoBo | Registratie</title>
    <style type="text/css">
        body {
            background: url(inc/img/background/<?php echo $selectedBg; ?>);
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            position: relative;
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="container ctpadding">
    <div class="row">
        <div class="col-sm-3">

        </div>
        <div class="col-sm-6">
            <?php include('partial/alert.php'); ?>
            <?php 					if(getMaintenance() == '1') { ?>
                <div class="alert alert-warning alert-dismissable fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Maintenance mode is active, you cant make an account now.
                </div>
            <?php					}
            ?>
            <div class="box-login" style="border-radius: 5px;">
                <center><img src="inc/img/favicon.png" height="125px" class="login-logo">
                    <h4><strong>Sign Up</strong></h4></center>
                <div class="row">
                    <div class="col-sm-offset-3 col-sm-6">
                        <hr>
                    </div>
                </div>
                <form id="signup" class="form-horizontal" method="post">
                    <label for="email" id="email">Email: </label>
                    <input type="email" name="email" required>
                    <label for="voornaam" id="voornaam">Voornaam: </label>
                    <input type="text" name="voornaam" required>
                    <label for="achternaam" id="achternaam">Achternaam: </label>
                    <input type="text" name="achternaam" required>
                    <label for="password">Wachtwoord: </label>
                    <input type="password" name="password" required>
                    <label for="conf-password">Wachtwoord bevestigen: </label>
                    <input type="password" name="conf-password" required>
                    <input type="submit" name="register" value="Register">
                </form>
                <script>
                    $('#signup').on('submit', function(e) {
                        e.preventDefault();
                        $.ajax({
                            type: "POST",
                            url: "core/sign_up.php",
                            data: {email: " "+$('#su_email').val(), firstname: " "+$('#su_fi_name').val(), familyname: " "+$('#su_fa_name').val(), minecraft: " "+$('#su_minecraft').val(), password: " "+$('#su_password').val(), re_password: " "+$('#su_re_password').val(), ip: " "+$('#su_ip').val()},
                            success: function(data){
                                if(data === 'signed_up'){
                                    document.location.href = '?success=You successfully signed up, please check your mail for activation.';
                                }
                                else {
                                    document.location.href = data;
                                }
                            }
                        });
                    });
                </script>
                <a href="login.php" class="park-link" style="margin-left: 150px;">Back to Sign In</a>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-3">

</div>
</div>
</div>
</body>
</html>