<?php
/**
* Copyright (c) 2017 Netixy Development
*/

		/* Background */
		
		$bg = array('bg-01.png', 'bg-02.png', 'bg-03.png', 'bg-04.png', );

		$i = rand(0, count($bg)-1);
		$selectedBg = "$bg[$i]";
		
		$id = $_GET['id'];
		
		session_start();
		include('core/functions.php');
		
		$online = false;
		if(is_online())
		{
			$online = true;
		}
		
		if(getMaintenance() == '1') {
			if(!$online) {
				header('Location: maintenance.php');
			}
			else {
				if(!isStaff($_SESSION['id'])) {
					header('Location: maintenance.php');
				}
			}
		}
		
		if(!$online) {
				header('Location: index.php');
		}
		else {
			if(!empty($_GET['id'])) {
				if(!canManageParkSettings($_SESSION['id'], $id)) {
					header('Location: park.php?id='.$id.'&warning=You are not allowed to write a post. If this is wrong you can contact your park owner.');
				}
				if(!existPark($id)) {
					header('Location: index.php');
				}
			}
			else {
				header('Location: index.php');
			}
		}
		
		$user_ip = get_client_ip();
		addIPtoList($user_ip);
		if(isIPBanned($user_ip)){
			header('Location: https://google.com');
		}
			
if (isset($_POST['submit'])) {
    $parkid = $_POST['id'];

    $logoimg = '';
    if (isset($_FILES['logoimage'])) {
        $imga = $_FILES['logoimage'];
        $logoimg = uploadimage($imga);
    } else {
        $logoimg = 'Invalid URL';
    }
	
	$headerimg = '';
    if (isset($_FILES['headerimage'])) {
        $imgb = $_FILES['headerimage'];
        $headerimg = uploadimage($imgb);
    } else {
        $headerimg = 'Invalid URL';
    }
	
	$backgroundimg = '';
    if (isset($_FILES['backgroundimage'])) {
        $imga = $_FILES['backgroundimage'];
        $backgroundimg = uploadimage($imga);
    } else {
        $backgroundimg = 'Invalid URL';
    }

    if (canManageParkSettings($_SESSION['id'], $id)) {
        addParkImages($parkid, $headerimg, $logoimg, $backgroundimg);
        header('Location: park-images.php?id='.$id.'&success=You have updated the park images.');
        exit;
    } else {
        header('Location: index.php');
        exit;
    }
}
		
?>
<!DOCTYPE html>
<html>
	<head>
		
		<?php include('inc/header.php'); ?>
		<title>MineThemepark | Park Images</title>
		<style type="text/css">
		body {
			background: url(<?php echo getParkbackground($id); ?>);
			background-attachment: fixed;
			background-size: cover;
			background-repeat: no-repeat;
			position: relative;
		}
		</style>
	</head>
	<body>
		
		<?php include('inc/navbar-1.php'); ?>
		<div class="container ctpadding" style="background-color: #efefef;">
			<div class="row">
				<div class="col-sm-3">
					<?php include('inc/sidebar-left.php'); ?>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					<div class="box-login" >
						<h5 style="margin-left: 5%;"><a href="park.php?id=<?php echo $id; ?>" class="park-link"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</strong></a></h5>
					</div>
					<div class="box-login" >
						<h4 style="margin-left: 5%;"><strong>Park Images</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
							<form name="uploadimage" id="uploadimage" enctype="multipart/form-data" method="post" autocomplete="off" class="form-horizontal">
										
										<div class="form-group">
                                            <label for="parkLogo" class="col-md-2 control-label">Logo:</label>
                                            <div class="col-md-10" id="headdiv">
												<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" required>
												<img src="<?php echo getParklogo($id); ?>" alt="" class="logo" id="logoprv" style="width: 20%;"/>
                                                <input type="file" id="logoimage" name="logoimage" accept="image/*" onchange="LoadLogoPreview(this)" required>
                                                <input type="text" readonly="" class="form-control" style ="margin-top: 5px;" placeholder="Select an image" id="logotext">
                                                <script>
                                                    $("#logoimage").change(function () {
                                                        if ($("#logoimage").val() == '') {
                                                            document.getElementById("logotext").placeholder = 'Select an Image';
                                                        } else {
                                                            document.getElementById("logotext").placeholder = $("#logoimage").val().replace(/C:\\fakepath\\/i, '');
                                                        }
                                                    });
													
													function LoadLogoPreview(fileInput) {
                                                            var files = fileInput.files;
                                                            for (var i = 0; i < files.length; i++) {
                                                                var file = files[i];
                                                                var imageType = /image.*/;
                                                                if (!file.type.match(imageType)) {
                                                                    continue;
                                                                }
                                                                var img = document.getElementById("logoprv");
                                                                img.file = file;
                                                                var reader = new FileReader();
                                                                reader.onload = (function (aImg) {
                                                                    return function (e) {
                                                                        aImg.src = e.target.result;
                                                                    };
                                                                })(img);
                                                                reader.readAsDataURL(file);
                                                            }
                                                        }
                                                </script>
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="parkHeader" class="col-md-2 control-label">Header:</label>
                                            <div class="col-md-10" id="headdiv">
												<img src="<?php echo getParkheader($id); ?>" alt="" class="header" id="headerprv" style="width: 20%;"/>
                                                <input type="file" id="headerimage" name="headerimage" accept="image/*" onchange="LoadHeaderPreview(this)" required>
                                                <input type="text" readonly="" class="form-control" style ="margin-top: 5px;" placeholder="Select an image" id="headertext">
                                                <script>
                                                    $("#headerimage").change(function () {
                                                        if ($("#headerimage").val() == '') {
                                                            document.getElementById("headertext").placeholder = 'Select an Image';
                                                        } else {
                                                            document.getElementById("headertext").placeholder = $("#headerimage").val().replace(/C:\\fakepath\\/i, '');
                                                        }
                                                    });
													
													function LoadHeaderPreview(fileInput) {
                                                            var files = fileInput.files;
                                                            for (var i = 0; i < files.length; i++) {
                                                                var file = files[i];
                                                                var imageType = /image.*/;
                                                                if (!file.type.match(imageType)) {
                                                                    continue;
                                                                }
                                                                var img = document.getElementById("headerprv");
                                                                img.file = file;
                                                                var reader = new FileReader();
                                                                reader.onload = (function (aImg) {
                                                                    return function (e) {
                                                                        aImg.src = e.target.result;
                                                                    };
                                                                })(img);
                                                                reader.readAsDataURL(file);
                                                            }
                                                        }
                                                </script>
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="parkHeader" class="col-md-2 control-label">Background:</label>
                                            <div class="col-md-10" id="headdiv">
												<img src="<?php echo getParkbackground($id); ?>" alt="" class="background" id="backgroundprv" style="width: 20%;"/>
                                                <input type="file" id="backgroundimage" name="backgroundimage" accept="image/*" onchange="LoadBackgroundPreview(this)" required>
                                                <input type="text" readonly="" class="form-control" style ="margin-top: 5px;" placeholder="Select an image" id="backgroundtext">
                                                <script>
                                                    $("#backgroundimage").change(function () {
                                                        if ($("#backgroundimage").val() == '') {
                                                            document.getElementById("backgroundtext").placeholder = 'Select an Image';
                                                        } else {
                                                            document.getElementById("backgroundtext").placeholder = $("#backgroundimage").val().replace(/C:\\fakepath\\/i, '');
                                                        }
                                                    });
													
													function LoadBackgroundPreview(fileInput) {
                                                            var files = fileInput.files;
                                                            for (var i = 0; i < files.length; i++) {
                                                                var file = files[i];
                                                                var imageType = /image.*/;
                                                                if (!file.type.match(imageType)) {
                                                                    continue;
                                                                }
                                                                var img = document.getElementById("backgroundprv");
                                                                img.file = file;
                                                                var reader = new FileReader();
                                                                reader.onload = (function (aImg) {
                                                                    return function (e) {
                                                                        aImg.src = e.target.result;
                                                                    };
                                                                })(img);
                                                                reader.readAsDataURL(file);
                                                            }
                                                        
                                                </script>
                                            </div>
                                        </div>
										
										

                                        <div class="text-center">
										<p class="text-danger">All fields are required, uploading your files can take some secconds so please wait.</p>
                                            <button type="submit" class="btn btn-raised btn-success" name="submit" id="postbutton">Save</button>
                                        </div>
                                    </form>
						</div>
					</div>
				</div>
				<div class="col-sm-3" style="margin-top: 5px;">
					<?php include('inc/sidebar.php'); ?>
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>