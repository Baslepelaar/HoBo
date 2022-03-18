<?php
/**
* Copyright (c) 2017 Netixy Development
*/

		/* Background */
		
		$bg = array('bg-01.png', 'bg-02.png', 'bg-03.png', 'bg-04.png', );

		$i = rand(0, count($bg)-1);
		$selectedBg = "$bg[$i]";
		
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
		
		if(!$online) {
				header('Location: index.php');
		}
		else {
			if(!canWritePost($_SESSION['id'])) {
				header('Location: staff-panel.php?warning=You are not allowed to write a post. If this is wrong you can contact a site administrator.');
			}
		}
		
		$user_ip = get_client_ip();
		addIPtoList($user_ip);
		if(isIPBanned($user_ip)){
			header('Location: https://google.com');
		}
			
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $title = trim($title);
    $title = strip_tags($title);
    $body = $_POST['article'];
    $body = preg_replace("/\r\n|\r/", "<br>", $body);
    $body = strip_tags($body, '<strong>, <i>, <br>, <h1>, <h2>, <h3>, <h4>, <h5>, <u>, <del>, <a>, <img>, <hr>');
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
    if (canWritePost($_SESSION['id'])) {
        addMTPPost($title, $body, $headerimg, $bodyimg);
        header('Location: staff-panel.php?success=You successfully posted a new article.');
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
			background: url(https://minethemepark.com/inc/img/background/<?php echo getParkbackground($id); ?>);
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
				<div class="col-sm-6">
					<?php include('inc/alert.php'); ?>
					<div class="box-login" >
						<h5 style="margin-left: 5%;"><a href="staff-panel.php" class="park-link"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</strong></a></h5>
					</div>
					<div class="box-login" >
						<h4 style="margin-left: 5%;"><strong>Write Post</strong></h4>
						<center><hr style="width: 90%;"></center>
						<div style="margin-left: 5%; margin-right: 5%;">
							<form name="register" id="register" enctype="multipart/form-data" method="post" autocomplete="off" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="title" class="col-md-2 control-label">Title:</label>
                                            <div class="col-md-10" id="titlediv">
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
                                            <p class="text-danger">All fields are required, uploading your files can take some secconds so please wait.</p>
                                            <button type="submit" class="btn btn-raised btn-success" name="submit"
                                                    id="postbutton">Post
                                            </button>
                                            <button type="button" onclick="loadPreview()"
                                                    class="btn btn-raised btn-info" data-toggle="modal"
                                                    data-target="#preview">Preview
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
					<div class="box-login" >
					<h4 style="margin-left: 5%;"><strong>Text design</strong></h4>
					<center><hr style="width: 90%;"></center>
					<div style="margin-left: 5%; margin-right: 5%;">
						<p>&lt;i&gt;<i>Italic text...</i>&lt;/i&gt;</p>
						<p>&lt;strong&gt;<strong>Bold text...</strong>&lt;/strong&gt;</p>
						<p>&lt;del&gt;<del>Deleted text</del>...&lt;/del&gt;</p>
						<p>&lt;u&gt;<u>Underlined text...</u>&lt;/u&gt;</p>
						<p>&lt;a href="URL"&gt;This will change in a link&lt;/a&gt;</p>
						<p>&lt;img src="URL"&gt;This will display an image.</p>
						<p>&lt;hr&gt;This will display a horizontal line.</p>
						<p>&lt;h1&gt;Heading text size 1 to 5&lt;/h1&gt;</p>
						
					</div>
				</div>
				</div>
			</div>
		</div>
		<script src="js/live-chat.js"></script>
	</body>
</html>