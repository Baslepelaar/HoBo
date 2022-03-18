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
		include('inc/HTMLPurifier.standalone.php');
		$config = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($config);
		$config->set('HTML.SafeIframe', true);
		$config->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%'); //allow YouTube and Vimeo
		
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
		
		$user_ip = get_client_ip();
		addIPtoList($user_ip);
		if(isIPBanned($user_ip)){
			header('Location: https://google.com');
		}
		
		if(!$online) {
				header('Location: index.php');
		}
		else {
			if(!empty($_GET['id'])) {
				if(!canManageParkPosts($_SESSION['id'], $id)) {
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
			
if (isset($_POST['submit'])) {
    $parkid = $_POST['id'];
    $title = $_POST['title'];
    $title = trim($title);
    $title = strip_tags($title);
    $body = $_POST['article'];
    $body = preg_replace("/\r\n|\r/", "<br>", $body);
    $body = strip_tags($body, '<strong>, <i>, <br>, <h1>, <h2>, <h3>, <h4>, <h5>, <u>, <del>, <a>');
    $body = trim($body);

    $bodyimg = '';
    if (isset($_FILES['headerimage'])) {
        $imga = $_FILES['articleimage'];
        $bodyimg = uploadimage($imga);
    } else {
        $bodyimg = 'Invalid URL';
    }

    $headerimg = '';
    if (isset($_FILES['headerimage'])) {
        $imgb = $_FILES['headerimage'];
        $headerimg = uploadimage($imgb);
    } else {
        $headerimg = 'Invalid URL';
    }
    if (canManageParkPosts($_SESSION['id'], $id)) {
        addParkPost($parkid, $title, $body, $headerimg, $bodyimg);
        header('Location: park.php?id='.$id.'&success=Your post have been send to staff to get reviewed, please wait.');
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
		<title>MineThemepark | Write Post</title>
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
				<div class="box-login" >
					<h4 style="margin-left: 5%;"><strong>Text design</strong></h4>
					<center><hr style="width: 90%;"></center>
					<div style="margin-left: 5%; margin-right: 5%;">
						<p>&lt;i&gt;<i>Italic text...</i>&lt;/i&gt;</p>
						<p>&lt;strong&gt;<strong>Bold text...</strong>&lt;/strong&gt;</p>
						<p>&lt;del&gt;<del>Deleted text</del>...&lt;/del&gt;</p>
						<p>&lt;u&gt;<u>Underlined text...</u>&lt;/u&gt;</p>
						<p>&lt;h1&gt;Heading text size 1 to 5&lt;/h1&gt;</p>
						
					</div>
				</div>
					<?php include('inc/sidebar-left.php'); ?>
				</div>
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					<div class="box-login" >
						<h5 style="margin-left: 5%;"><a href="park.php?id=<?php echo $id; ?>" class="park-link"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</strong></a></h5>
					</div>
					<div class="box-login" >
						<h4 style="margin-left: 5%;"><strong>Write Post</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
							<form name="register" id="register" enctype="multipart/form-data" method="post" autocomplete="off" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="title" class="col-md-2 control-label">Title:</label>
                                            <div class="col-md-10" id="titlediv">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>" required>
                                                <input type="text" class="form-control" name="title" id="title"
                                                       placeholder="Title of your post" value=""
                                                       required>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label for="article" class="col-md-2 control-label">Article:</label>
                                            <div class="col-md-10" id="titlediv">
                                                <textarea type="text" class="form-control" name="article" id="article"
                                                          placeholder="Type here your article..." value="" rows="10"
                                                          required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="articleheader" class="col-md-2 control-label">Banner Image:</label>
                                            <div class="col-md-10" id="headdiv">
                                                <input type="file" id="headerimage" name="headerimage" accept="image/*" required>
                                                <input type="text" readonly="" class="form-control" style ="margin-top: 5px;" placeholder="Select an image" id="headertext">
                                                <script>
                                                    $("#headerimage").change(function () {
                                                        if ($("#headerimage").val() == '') {
                                                            document.getElementById("headertext").placeholder = 'Select Image';
                                                        } else {
                                                            document.getElementById("headertext").placeholder = $("#headerimage").val().replace(/C:\\fakepath\\/i, '');
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="articleimage" class="col-md-2 control-label">Post Images:</label>
                                            <div class="col-md-10" id="articlediv">
                                                <input type="file" id="articleimage" name="articleimage"
                                                       accept="image/*" onchange="loadBodyPreview(this)" required>
                                                <input type="text" readonly="" class="form-control" style ="margin-top: 5px;" placeholder="Select an image" id="articletext">
                                                <script>
                                                    $("#articleimage").change(function () {
                                                        if ($("#articleimage").val() == '') {
                                                            document.getElementById("articletext").placeholder = 'select Image';
                                                        } else {
                                                            document.getElementById("articletext").placeholder = $("#articleimage").val().replace(/C:\\fakepath\\/i, '');
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-raised btn-success" name="submit" id="postbutton">Post</button>
                                            <button type="button" onclick="loadPreview()" class="btn btn-raised btn-info" data-toggle="modal" data-target="#preview">Preview
                                            </button>
                                        </div>
                                        <div class="modal fade" id="preview" role="dialog">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                        <h4 class="modal-title">Post Preview</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="nothing" alt="You have no image selected."
                                                             class="img-responsive center-block" id="prvimage"/>
                                                        <h3 id="prvtitle"></h3>
                                                        <p id="prvbody"></p>
                                                    </div>
                                                    <script>
                                                        function loadPreview() {
                                                            document.getElementById('prvtitle').innerHTML = document.getElementById('title').value;
                                                            document.getElementById('prvbody').innerHTML = document.getElementById('article').value.replace(/\r?\n/g, '<br />');
                                                            ;
                                                        }

                                                        function loadBodyPreview(fileInput) {
                                                            var files = fileInput.files;
                                                            for (var i = 0; i < files.length; i++) {
                                                                var file = files[i];
                                                                var imageType = /image.*/;
                                                                if (!file.type.match(imageType)) {
                                                                    continue;
                                                                }
                                                                var img = document.getElementById("prvimage");
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
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
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