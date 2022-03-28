	<?php
	
	include('core/functions.php');
	
	
	if(!empty($_GET['park'])) {

		$park = $_GET['park'];
		
		require_once('core/ini.php');
					
		$sql 	= "SELECT * FROM `parks` WHERE `id`='".$park."' AND `deleted`='0' AND `reviewed`='1'";
		$result = connection()->query($sql);
		
		if($result->num_rows > 0){
	
		while($row = $result->fetch_assoc())
		{
			
			$name = $row['name'];
			$logo = $row['logo'];
			$ip = $row['ip'];
			$background = $row['background'];
			$header = $row['header'];
			$followers = countFollowers($park);
			$description = $row['description'];
			
			if(isset($_REQUEST['name'])) {
				
				$json = array('Error' => false, 'ID' => $park, 'Name' => $name);
				$jsonencoded = json_encode($json);
				echo $jsonencoded;
			}
			else {
				
				if(isset($_REQUEST['logo'])) {
				
					$json = array('Error' => false, 'ID' => $park, 'Logo' => $logo);
					$jsonencoded = json_encode($json);
					echo $jsonencoded;
				}
				else {
				
					if(isset($_REQUEST['background'])) {
				
						$json = array('Error' => false, 'ID' => $park, 'Background' => $background);
						$jsonencoded = json_encode($json);
						echo $jsonencoded;
					}
					else {
					
						if(isset($_REQUEST['header'])) {
				
							$json = array('Error' => false, 'ID' => $park, 'Header' => $header);
							$jsonencoded = json_encode($json);
							echo $jsonencoded;
						}
						else {
						
							if(isset($_REQUEST['ip'])) {
				
								$json = array('Error' => false, 'ID' => $park, 'IP' => $ip);
								$jsonencoded = json_encode($json);
								echo $jsonencoded;
							}
							else {
								
								if(isset($_REQUEST['followers'])) {
				
									$json = array('Error' => false, 'ID' => $park, 'Followers' => $followers);
									$jsonencoded = json_encode($json);
									echo $jsonencoded;
								}
								else {
									
									if(isset($_REQUEST['description'])) {
				
										$json = array('Error' => false, 'ID' => $park, 'Description' => $description);
										$jsonencoded = json_encode($json);
										echo $jsonencoded;
									}
									else {
									
										$json = array('Error' => false, 'ID' => $park, 'Followers' => $followers, 'Header' => $header, 'Logo' => $logo, 'IP' => $ip, 'Description' => $description, 'Background' => $background, 'Name' => $name);
										$jsonencoded = json_encode($json);
				
										echo $jsonencoded;
									}
								}
							}
						}
					}
				}
			}
		}
		}
		else {
			
			$err = array('Error' => true, 'Message' => "This park does not exist");
			echo json_encode($err);
		}
	}
	else {
		
		$err = array('Error' => true, 'Message' => "Park is not setted");
		echo json_encode($err);
	}
?>