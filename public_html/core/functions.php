<?php
/**
* Copyright (c) 2017 Netixy Development
*/

	/* User */
	
    function is_online(){
        if(!empty($_SESSION['id'])){
            require_once('ini.php');

            $sql = "SELECT * FROM `users` WHERE `ID`='".$_SESSION['id']."' AND `Banned`='0'";
            $result = connection()->query($sql);

            if($result->num_rows > 0){
                
                return true;
            }
            else{
                
                return false;
            }
        }
        else{
            return false;
        }
    }
    function save_mysql($input){
        return str_replace(array("\"", "\'", "\\"), "", $input);
    }
    function login($email, $password){
		
        require_once('ini.php');

        if($email != '' && $password != ''){
            $sql 	= "SELECT * FROM `users` WHERE `email`='".save_mysql($email)."'";
            $result = connection()->query($sql);
            if($result->num_rows > 0){
                $sql 	= "SELECT * FROM `users` WHERE `email`='".save_mysql($email)."' AND `password`='".md5(save_mysql($password))."'";
                $result = connection()->query($sql);
                if($result->num_rows > 0){
                    $row = mysqli_fetch_assoc($result);
                    if($row['banned'] == 0){
                        if($row['active'] == 1){
                            
                            $_SESSION['id'] = $row['id'];
                            return 'loged_in';
                        }
                        else{
                            
                            return '?warning=Your account is not active yet, check your e-mail.';
                        }
                    }
                    else{
                        
                        return '?danger=Your account has been banned!';
                    }
                }
                else{
                    
                    return '?warning=The password is incorrect!';
                }
            }
            else{
                
                return '?warning=Your email address is unknown!';
            }
        }
        else{
            
            return '?warning=Not all required fields are filled!';
        }
    }
    function logout()
    {
        session_unset();
        header('Location: ../index.php?success=You are succesfull logged out.');
    }
    function sign_up($email, $firstname, $familyname, $minecraft, $password, $repassword, $ip){
		
        require_once('ini.php');

        if($email != '' && $firstname != '' && $familyname != '' && $minecraft != '' && $password != '' && $repassword != '' && $ip != ''){
			$sql 	= "SELECT * FROM `users` WHERE `ip`='".$ip."'";
            $result = connection()->query($sql);
			if($result->num_rows < 3){
				 
				 
            $sql 	= "SELECT * FROM `users` WHERE `email`='".save_mysql($email)."'";
            $result = connection()->query($sql);
            if($result->num_rows == 0){
                if($password == $repassword){
                    $sql 	= "INSERT INTO `users` (`email`, `firstname`, `familyname`, `password`, `minecraft`, `lang`, `datum`, `ip`) VALUES ('".save_mysql($email)."', '".save_mysql($firstname)."', '".save_mysql($familyname)."', '".md5(save_mysql($password))."', '".save_mysql($minecraft)."', 'EN', '".date("d/m/Y")."', '".save_mysql($ip)."');";
                    $conn = connection();
                    
                    $to      = $email;
                    $subject = 'Account verification';
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
                    $headers .= "From: MineThemepark <activation@minethemepark.com>" . "\r\n";
                    $headers .= "Content-Transfer-Encoding: base64" . "\r\n" .
                    "X-Mailer: PHP/" . phpversion();
                    
                    $message = '<!doctype html>
									<html>
										<head>
											<title>MineThemepark Activation</title>
										</head>
										<body>
											<center>
													<p>Thanks for signing up at MineThemepark.<br />
														To activate your account. <a href="https://minethemepark.com/core/activation.php?type=verifyAccount&id='.$conn->insert_id.'&email='.$email.'">Click here</a></p>
													<p style="padding-top: 50px">Sponsored by <a href="https://netixydev.com">Netixy Development</a></p>
											</center>
										</body>
									</html>';
                    
                    $message = chunk_split(base64_encode($message));
                    
                    mail($to, $subject, $message, $headers);
                    
                    return 'signed_up';
                }
                else{
                    
                    return '?warning=The passwords are not the same.';
                }
            }
            else{
                
                return '?warning=That email is already registered.';
            }
        }
		else {
			return '?danger=To many accounts signed up at you ip adress "'.$ip.'"!';
		}
		}
        else{
            
            return '?warning=Not all required fields are filled!';
        }
    }
	function get_client_ip()
	{
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';

      return $ipaddress;
	}
	function addIPtoList($ip){
		
        require_once('ini.php');
		
		if($ip != ''){
			
			$sql 	= "SELECT * FROM `ip` WHERE `ip`='".save_mysql($ip)."'";
			$result = connection()->query($sql);
			if($result->num_rows == 0){

				$sql  = "INSERT INTO `ip` (`ip`, `datum`) VALUES ('".save_mysql($ip)."', '".date("d/m/Y")."');";
				$conn = connection();
				$id = $conn->query($sql);
			}
        }
    }
	function UpdateUserIP($user_id, $ip){
		
        require_once('ini.php');
		
		if($ip != '' && $ip != ''){
			
			$sql 	= "SELECT * FROM `users` WHERE `id`='".save_mysql($user_id)."' AND `ip`='None'";
			$result = connection()->query($sql);
			if($result->num_rows == 1){

				$sql = "UPDATE `users` SET `ip`='".save_mysql($ip)."' WHERE `id`='".$user_id."';";
				$result = connection()->query($sql);
			}
        }
    }
    function active($id, $email)
    {
        require_once('ini.php');
        
        $sql = "SELECT * FROM `users` WHERE `id`='".save_mysql($id)."' AND `email`='".save_mysql($email)."';";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            $sql = "UPDATE `users` SET `active`='1' WHERE `id`='".save_mysql($id)."' AND `email`='".save_mysql($email)."';";
            connection()->query($sql);
        }
    }
    function generateCode($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function getMinecraft($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `minecraft` FROM `users` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['minecraft'];
        }
        else
        {
            return "";
        }
    }
	function getDatum($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `datum` FROM `users` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['datum'];
        }
        else
        {
            return "";
        }
    }
	function getIpFromUser($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `ip` FROM `users` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['ip'];
        }
        else
        {
            return "";
        }
    }
	function getIDfromMail($email)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `id` FROM `users` WHERE `email`='".$email."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['id'];
        }
        else
        {
            return "";
        }
    }
	function getLang($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `lang` FROM `users` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['lang'];
        }
        else
        {
            return "";
        }
    }
    function getEmail($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `email` FROM `users` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['email'];
        }
        else
        {
            return "";
        }
    }
    function getFirstName($id)
    {
		require_once('ini.php');
        
        $sql 	= "SELECT `firstname` FROM `users` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['firstname'];
        }
        else
        {
            return "";
        }
    }
	function getFamilyName($id)
    {
		require_once('ini.php');
        
        $sql 	= "SELECT `familyname` FROM `users` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['familyname'];
        }
        else
        {
            return "";
        }
    }
    function change_password($old, $new, $rnew)
    {
        require_once('ini.php');

        if($old != '' && $new != '' && $rnew != ''){
            $sql 	= "SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."' AND `password`='".md5(save_mysql($old))."'";
            $result = connection()->query($sql);
            if($result->num_rows > 0){
                if($new == $rnew){
                    if($new != $old)
                    {
                        $sql 	= "UPDATE `users` SET `password`='".md5(save_mysql($new))."' WHERE `id`='".$_SESSION['id']."';";
                        connection()->query($sql);

                        return '1.Het wachtwoord is gewijzigt.';
                    }
                    else
                    {
                        return '0h.Het oude en nieuwe wachtwoord is het zelfde?';
                    }
                }
                else{
                    
                    return '0h.De wachtwoorden komen niet overeen.';
                }
            }
            else{
                
                return '0h.Het oude wachtwoord klopt niet.';
            }
        }
        else{
            
            return '0h.Niet alle velden zijn ingevult.';
        }
    }
	function reset_password_mail($email) {
		
		require_once('ini.php');
		
		if($email != ''){
			$sql 	= "SELECT * FROM `users` WHERE `email`='".$email."'";
            $result = connection()->query($sql);
			if($result->num_rows > 0){
					while($row = $result->fetch_assoc())
					{
					
					$to      = $email;
                    $subject = 'Password reset';
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
                    $headers .= "From: MineThemepark <noreply@minethemepark.com>" . "\r\n";
                    $headers .= "Content-Transfer-Encoding: base64\r\n".
                    "X-Mailer: PHP/" . phpversion();
                    
                    $message = '<!doctype html>
									<html>
										<head>
											<title>MineThemepark Password Reset</title>
										</head>
										<body>
											<center>
													<p>Reset your password of MineThemepark.<br />
														To reset your password, <a href="https://minethemepark.com/login.php?id='.$row['id'].'&code='.$row['password'].'">Click here</a></p>
													<p style="padding-top: 50px">Sponsored by <a href="https://netixydev.com">Netixy Development</a></p>
											</center>
										</body>
									</html>';
                    
                    $message = chunk_split(base64_encode($message));
                    
                    mail($to, $subject, $message, $headers);
					
					return 'password_reset_mailed';
					
					}
				}
			else {
				return("?warning=Your email address is unknown!");
			}
		}
		else {
			return("?warning=Not all fields are filled in!");
		}
	}

	function reset_password($rcode, $rid, $new, $rnew)
    {
        require_once('ini.php');

        if($rcode != '' && $rid != '' && $new != '' && $rnew != ''){
            $sql 	= "SELECT * FROM `users` WHERE `password`='".save_mysql($rcode)."' AND `id`='".save_mysql($rid)."'";
            $result = connection()->query($sql);
            if($result->num_rows > 0){
                if($new == $rnew){
                    if($new != $rcode)
                    {
                        $sql 	= "UPDATE `users` SET `password`='".md5(save_mysql($new))."' WHERE `password`='".save_mysql($rcode)."' AND `id`='".save_mysql($rid)."';";
                        connection()->query($sql);

                        return 'password_reseted';
                    }
                    else
                    {
                        return("?warning=Your link is incorrect, please send a new mail or contact us!");
                    }
                }
                else{
                    return("?warning=The passwords are not the same!");
                }
            }
            else{
				return("?danger=Something went wrong, conntact us!");
            }
        }
        else{
            return("?warning=Not all fields are filled in!");
        }
    }
	function isBanned($id) {
        $sql = "SELECT * FROM `users` WHERE `id`='".$id."' AND `banned`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function isIPBanned($ip) {
        $sql = "SELECT * FROM `ip` WHERE `ip`='".$ip."' AND `banned`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function isPlayerFollowingAnyPark($id) {
		
		require_once('ini.php');
		
		$email = getEmail($id);
		
        $sql = "SELECT * FROM `parks` WHERE `followers` LIKE '%{$email}%' AND `reviewed`='1' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function CountFollowing($id) {
		
		require_once('ini.php');
		
		$email = getEmail($id);

		$sql = "SELECT * FROM `parks` WHERE `followers` LIKE '%{$email}%' AND `reviewed`='1' AND `deleted`='0'";
		$result = connection()->query($sql);
		$count = mysqli_num_rows($result);
		return ($count);
    }
	function isParkStaff($id) {
        $sql = "SELECT * FROM `parks_staff` WHERE `user_id`='".$id."'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	/* User End */
	
	/* System */
	
	function getMaintenance()
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `data` FROM `settings` WHERE `variable`='maintenance'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['data'];
        }
        else
        {
            return "";
        }
    }
	function countUsers() {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `users` WHERE `active`='1' AND `banned`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function countBannedUsers() {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `users` WHERE `banned`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function countActiveParks() {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `parks` WHERE `reviewed`='1' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function countRequestParks() {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `parks` WHERE `reviewed`='0' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function countPostParks() {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `posts` WHERE `reviewed`='1' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function countRequestPostParks() {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `posts` WHERE `reviewed`='0' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function uploadimage($img) {
        $filename = $img['tmp_name'];
        $client_id="e7652137f0fae10";
        $handle = fopen($filename, "r");
        $data = fread($handle, filesize($filename));
        $pvars   = array('image' => base64_encode($data));
        $timeout = 30;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
        $out = curl_exec($curl);
        curl_close ($curl);
        $pms = json_decode($out,true);
        $url=$pms['data']['link'];
        if($url!=""){
            return $url;
        }else{
            return $pms['data']['error'];
        }
    }
	/* System End */
	
	/* Parks */
	
	function addParkImages($park_id, $headerimg, $logoimg, $backgroundimg)
    {
        require_once('ini.php');
		
        if($headerimg == 'Invalid URL' || $headerimg == '') {
            $headerimg = getParkheader($park_id);
        }
		
        if($logoimg == 'Invalid URL' || $logoimg == '') {
            $logoimg = getParklogo($park_id);
        }
		
		if($backgroundimg == 'Invalid URL' || $backgroundimg == '') {
            $backgroundimg = getParkbackground($park_id);
        }
		
		$sql = "UPDATE `parks` SET `header`='".$headerimg."' WHERE `id`='".$park_id."';";
		connection()->query($sql);
		
		$sql = "UPDATE `parks` SET `logo`='".$logoimg."' WHERE `id`='".$park_id."';";
		connection()->query($sql);
		
		$sql = "UPDATE `parks` SET `background`='".$backgroundimg."' WHERE `id`='".$park_id."';";
		connection()->query($sql);
			
    }
	
	function changeParkRank($user_id, $park_id, $rank, $description) {
		
		require_once('ini.php');
		
		if($user_id != '' && $park_id != '' && $rank != ''){
			
			$sql = "SELECT * FROM `parks_staff` WHERE `user_id`='".$user_id."' AND `park_id`='".$park_id."'";
			$result = connection()->query($sql);
			$count = mysqli_num_rows($result);
			if($count > 0) {
				
				$sql = "UPDATE `parks_staff` SET `description`='".$description."', `rank`='".$rank."' WHERE `user_id`='".$user_id."' AND `park_id`='".$park_id."';";
				$result = connection()->query($sql);
				
				return 'change_rank_success';
			}
			else {
				return("index.php?danger=Something went wrong, try again.");
			}
		}
		else {
			return("index.php?warning=Not all fields are filled in.");
		}
    }
	function updateParkSettings($park_id, $ip, $description, $email, $twitter, $website, $facebook, $instagram, $youtube, $snapchat) {
		
		require_once('ini.php');
		
		if($park_id != '' && $ip != '' && $twitter != '') {
			
			$sql 	= "SELECT * FROM `parks` WHERE `id`='".$park_id."'";
			$result = connection()->query($sql);
			if($result->num_rows > 0)
			{
				$sql = "UPDATE `parks` SET `ip`='".$ip."' WHERE `id`='".$park_id."';";
				connection()->query($sql);
			
				$sql = "UPDATE `parks` SET `twitter`='".$twitter."' WHERE `id`='".$park_id."';";
				connection()->query($sql);
			
				if($description != '')	{
					$sql = "UPDATE `parks` SET `description`='".$description."' WHERE `id`='".$park_id."';";
					connection()->query($sql);
				}
			
				if($email != '')	{
					$sql = "UPDATE `parks` SET `email`='".$email."' WHERE `id`='".$park_id."';";
					connection()->query($sql);
				}
			
				if($website != '')	{
					$sql = "UPDATE `parks` SET `website`='".$website."' WHERE `id`='".$park_id."';";
					connection()->query($sql);
				}
			
				if($facebook != '')	{
					$sql = "UPDATE `parks` SET `facebook`='".$facebook."' WHERE `id`='".$park_id."';";
					connection()->query($sql);
				}
			
				if($instagram != '')	{
					$sql = "UPDATE `parks` SET `instagram`='".$instagram."' WHERE `id`='".$park_id."';";
					connection()->query($sql);
				}
			
				if($youtube != '')	{
					$sql = "UPDATE `parks` SET `youtube`='".$youtube."' WHERE `id`='".$park_id."';";
					connection()->query($sql);
				}
			
				if($snapchat != '')	{
					$sql = "UPDATE `parks` SET `snapchat`='".$snapchat."' WHERE `id`='".$park_id."';";
					connection()->query($sql);
				}
				
				return 'update-park-settings-success';
			}
			else {
				return("index.php?danger=Something went wrong, try again.");
			}
        }
		else {
			return("index.php?danger=Something went wrong, try again.");
		}
    }		
	function addParkstaff($email, $rank, $park_id){
		
        require_once('ini.php');

        if($email != '' && $rank != '' && $park_id != ''){
			
			$sql = "SELECT * FROM `users` WHERE `email`='".$email."'";
			$result = connection()->query($sql);
			$count = mysqli_num_rows($result);
			if($count > 0) {
			
				$user_id = getIDfromMail($email);
			
				$sql = "SELECT * FROM `parks_staff` WHERE `user_id`='".$user_id."' AND `park_id`='".$park_id."'";
				$result = connection()->query($sql);
				$count = mysqli_num_rows($result);
				if(!$count > 0) {
				
					$sql  = "INSERT INTO `parks_staff` (`park_id`, `user_id`, `rank`) VALUES ('".save_mysql($park_id)."', '".save_mysql($user_id)."', '".save_mysql($rank)."');";
					$conn = connection();
					$id = $conn->query($sql);
					
				
					return 'park_add_staff_success';
				}
				else{
					return '?warning=That user is already a staff member.';
				}
			}
			else {
				return '?warning=That email adress is unknown.';
			}
		}
		else{
			return '?warning=Not all fields are filed in.';
		}
    }
	function requestPark($owner, $park_name, $park_ip, $park_website, $park_twitter, $park_facebook, $park_youtube){
		
        require_once('ini.php');

        if($owner != '' && $park_name != '' && $park_ip != '' && $park_twitter != ''){
			
            $sql 	= "SELECT * FROM `parks` WHERE `name`='".save_mysql($park_name)."' AND `deleted`='0'";
            $result = connection()->query($sql);
            if($result->num_rows == 0){
				
                $sql 	= "SELECT * FROM `users` WHERE `id`='".$owner."'";
				$result = connection()->query($sql);
				if($result->num_rows > 0) {
				
                    $sql 	= "INSERT INTO `parks` (`name`, `owner`, `logo`, `header`, `background`, `ip`, `twitter`, `youtube`, `website`, `facebook`, `datum`) VALUES ('".save_mysql($park_name)."', '".save_mysql($owner)."', 'https://minethemepark.com/inc/img/parks/default/logo.png', 'https://minethemepark.com/inc/img/parks/default/header.png', 'https://minethemepark.com/inc/img/background/bg-01.png', '".save_mysql($park_ip)."', '".save_mysql($park_twitter)."', '".save_mysql($park_youtube)."', '".save_mysql($park_website)."', '".save_mysql($park_facebook)."', '".date("d/m/Y")."');";
                    $conn = connection();
					$id = $conn->query($sql);
                    
                    return 'park_apply_success';
                }
                else{
                    
                    return '?danger=Something went wrong, try again.';
                }
            }
            else{
                
                return '?warning=A park with that name already exist.';
            }
        }
        else{
            
            return '?warning=Not all required fields are filled!';
        }
    }
	function addParkStaffOwner($park_id){
		
        require_once('ini.php');

        if($park_id != ''){
			
			$owner = getParkowner($park_id);
			
			$sql 	= "SELECT * FROM `parks_staff` WHERE `user_id`='".$owner."' AND `park_id`='".$park_id."'";
            $result = connection()->query($sql);
            if($result->num_rows == 0){
			
				$sql  = "INSERT INTO `parks_staff` (`park_id`, `user_id`, `rank`, `can_write_post`, `can_manage_staff`, `can_manage_comments`, `can_manage_settings`, `can_manage_applys`) VALUES ('".save_mysql($park_id)."', '".save_mysql($owner)."', 'Park Owner', '1', '1', '1', '1', '1');";
				$conn = connection();
				$id = $conn->query($sql);
			}
        }
    }
	function getParkowner($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `owner` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['owner'];
        }
        else
        {
            return "";
        }
    }
	function getStaffDescription($id, $park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `description` FROM `parks_staff` WHERE `user_id`='".$id."' AND `park_id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['description'];
        }
        else
        {
            return "";
        }
    }
	function getParkRankText($id, $park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `rank` FROM `parks_staff` WHERE `park_id`='".$park_id."' AND `user_id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
			return $result->fetch_assoc()['rank'];
        }
        else
        {
            return "";
        }
    }
	function getParkRank($id, $park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `rank` FROM `parks_staff` WHERE `park_id`='".$park_id."' AND `user_id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
			while($row = $result->fetch_assoc())
			{
				if($row['rank'] == 'Park Owner') {
					return '<span class="label label-danger">Owner</span>';
				}
				else {
					return '<span class="label label-info">'.$row['rank'].'</span>';
				}
			}
        }
        else
        {
            return "";
        }
    }
	function getParkname($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `name` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['name'];
        }
        else
        {
            return "";
        }
    }
	function getParktwitter($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `twitter` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['twitter'];
        }
        else
        {
            return "";
        }
    }
	function getParkfacebook($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `facebook` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['facebook'];
        }
        else
        {
            return "";
        }
    }
	function getParkwebsite($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `website` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['website'];
        }
        else
        {
            return "";
        }
    }
	function getParkinstagram($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `instagram` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['instagram'];
        }
        else
        {
            return "";
        }
    }
	function getParkyoutube($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `youtube` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['youtube'];
        }
        else
        {
            return "";
        }
    }
	function getParksnapchat($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `snapchat` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['snapchat'];
        }
        else
        {
            return "";
        }
    }
	function getParkemail($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `email` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['email'];
        }
        else
        {
            return "";
        }
    }
	function getParklogo($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `logo` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['logo'];
        }
        else
        {
            return "";
        }
    }
	function getParkbackground($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `background` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['background'];
        }
        else
        {
            return "";
        }
    }
	function getParkheader($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `header` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['header'];
        }
        else
        {
            return "";
        }
    }
	function getParkdescription($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `description` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['description'];
        }
        else
        {
            return "";
        }
    }
	function getParkip($park_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `ip` FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['ip'];
        }
        else
        {
            return "";
        }
    }
	function isFollowing($id, $park_id) {
		
		require_once('ini.php');
		
		$email = getEmail($id);

        $sql = "SELECT * FROM `parks` WHERE `id`='".$park_id."' AND `followers` LIKE '%{$email}%'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function isParkDelted($park_id) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `parks` WHERE `id`='".$park_id."' AND `deleted`='1'";
		connection()->query($sql);
		
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function isParkStafffromID($user_id, $park_id) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `parks_staff` WHERE `park_id`='".$park_id."' AND `user_id`='".$user_id."'";
		connection()->query($sql);
		
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function countFollowers($park_id) {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $followers = explode(",", $row['followers']);
        return (count($followers)-1);
    }
	function existPark($park_id) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `parks` WHERE `id`='".$park_id."' AND `deleted`='0' AND `reviewed`='1'";
		connection()->query($sql);
		
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function followPark($id, $park_id) {
		
		require_once('ini.php');
		
		$email = getEmail($id);
		
        if(!isFollowing($id, $park_id)) {
            $sql="UPDATE `parks` SET `followers` = CONCAT(followers,'".$email.",') WHERE `id`='".$park_id."';";
            $result = connection()->query($sql);
        }
    }
    function unfollowPark($id, $park_id) {
		
		require_once('ini.php');
		
		$email = getEmail($id);
		
        if(isFollowing($id, $park_id)) {
            $sql = "UPDATE `parks` SET `followers` = REPLACE(followers,'" . $email . ",','') WHERE `id`='".$park_id."';";
            $result = connection()->query($sql);
        }
    }
	function countParkPosts($park_id) {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `posts` WHERE `park_id`='".$park_id."' AND `reviewed`='1' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function canManageParkPosts($id, $park_id) {
        $sql = "SELECT * FROM `parks_staff` WHERE `park_id`='".$park_id."' AND `user_id`='".$id."' AND `can_write_post`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canManageParkStaff($id, $park_id) {
        $sql = "SELECT * FROM `parks_staff` WHERE `park_id`='".$park_id."' AND `user_id`='".$id."' AND `can_manage_staff`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canManageParkApply($id, $park_id) {
        $sql = "SELECT * FROM `parks_staff` WHERE `park_id`='".$park_id."' AND `user_id`='".$id."' AND `can_manage_applys`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canManageParkComments($id, $park_id) {
        $sql = "SELECT * FROM `parks_staff` WHERE `park_id`='".$park_id."' AND `user_id`='".$id."' AND `can_manage_comments`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canManageParkSettings($id, $park_id) {
        $sql = "SELECT * FROM `parks_staff` WHERE `park_id`='".$park_id."' AND `user_id`='".$id."' AND `can_manage_settings`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	/* Parks End */
	
	/* Apply*/
	
	function addJobOffer($title, $body, $park_id){
		
        require_once('ini.php');

        if($title != '' && $body != '' && $park_id != ''){
			
			$sql 	= "SELECT * FROM `parks` WHERE `id`='".$park_id."'";
			$result = connection()->query($sql);
			if($result->num_rows > 0)
			{
			
			$sql  = "INSERT INTO `applys` (`park_id`, `apply_title`, `apply_body`, `posted_on`) VALUES ('".save_mysql($park_id)."', '".save_mysql($title)."', '".save_mysql($body)."', '".date("d/m/Y")."');";
            $conn = connection();
            $id = $conn->query($sql);
				
            return 'add_apply_success';
			
			}
			else {
				return 'index.php?danger=Something went wrong, please try again.';
			}
        }
        else{
			return '?id='.$park_id.'&warning=Not all feelds are filled in.';
        }
    }
	function countApplyReplys($apply_id) {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `apply_reply` WHERE `apply_id`='".$apply_id."' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function isdeletedApply($apply_id) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `applys` WHERE `id`='".$apply_id."' AND `deleted`='1'";
		connection()->query($sql);
		
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function existApply($apply_id) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `applys` WHERE `id`='".$apply_id."'";
		connection()->query($sql);
		
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function getParkidFromApply($apply_id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `park_id` FROM `applys` WHERE `id`='".$apply_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['park_id'];
        }
        else
        {
            return "";
        }
    }
	function getApplyTitle($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `apply_title` FROM `applys` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['apply_title'];
        }
        else
        {
            return "";
        }
    }
	function getApplyBody($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `apply_body` FROM `applys` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['apply_body'];
        }
        else
        {
            return "";
        }
    }
	function addApplyReply($apply_id, $user_id, $about, $why, $discord, $skype){
		
        require_once('ini.php');

        if($user_id != '' && $about != '' && $why != ''){
			$sql  = "INSERT INTO `apply_reply` (`apply_id`, `user_id`, `about_user`, `discord_user`, `skype_user`, `why`, `datum`) VALUES ('".save_mysql($apply_id)."', '".save_mysql($user_id)."', '".save_mysql($about)."', '".save_mysql($discord)."', '".save_mysql($skype)."', '".save_mysql($why)."', '".date("d/m/Y")."');";
            $conn = connection();
            $id = $conn->query($sql);
				
            return 'apply_reply_success';
        }
        else{
			return '?id='.$apply_id.'&warning=Not all fields are filled in.';
        }
    }
	function updateParkApply($apply_id, $title, $body) {
		
		require_once('ini.php');
		
		if($apply_id != '' && $title != '' && $body != '') {
			
			$sql 	= "SELECT * FROM `applys` WHERE `id`='".$apply_id."'";
			$result = connection()->query($sql);
			if($result->num_rows > 0)
			{
				$sql = "UPDATE `applys` SET `apply_title`='".$title."' WHERE `id`='".$apply_id."';";
				connection()->query($sql);
			
				$sql = "UPDATE `applys` SET `apply_body`='".$body."' WHERE `id`='".$apply_id."';";
				connection()->query($sql);
				
				return 'update_apply_success';
			}
			else {
				return("index.php?danger=Something went wrong, try again.");
			}
        }
		else {
			return("index.php?danger=Something went wrong, try again.");
		}
    }
	/* Apply End */
	
	/* Article */
	function updateParkPost($postid, $title, $body) {
		
		require_once('ini.php');
		
		if($postid != '' && $title != '' && $body != '') {
			
			$sql 	= "SELECT * FROM `posts` WHERE `id`='".$postid."'";
			$result = connection()->query($sql);
			if($result->num_rows > 0)
			{
				$sql = "UPDATE `posts` SET `post_title`='".$title."' WHERE `id`='".$postid."';";
				connection()->query($sql);
			
				$sql = "UPDATE `posts` SET `post_body`='".$body."' WHERE `id`='".$postid."';";
				connection()->query($sql);
				
			}
        }
    }
	function addParkPost($park_id, $title, $body, $headerimg, $posterimg)
    {
        require_once('ini.php');
		
        if($headerimg == 'Invalid URL' || $headerimg == '') {
            $headerimg = getParkheader($park_id);
        }
        if($posterimg == 'Invalid URL' || $posterimg == '') {
            $bodyimg = getParkheader($park_id);
        }
		
        $sql = "INSERT INTO `posts` (`park_id`, `post_title`, `post_body`, `post_header`, `post_poster`, `posted_on`) VALUES ('".save_mysql($park_id)."', '".save_mysql($title)."', '".save_mysql($body)."', '".save_mysql($headerimg)."', '".save_mysql($posterimg)."', '".date("d/m/Y")."')";
        $conn = connection();
		$id = $conn->query($sql);
		
    }
	function getParkidFromArticle($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `park_id` FROM `posts` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['park_id'];
        }
        else
        {
            return "";
        }
    }
	function getArticleHeader($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `post_header` FROM `posts` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['post_header'];
        }
        else
        {
            return "";
        }
    }
	function getArticleTitle($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `post_title` FROM `posts` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['post_title'];
        }
        else
        {
            return "";
        }
    }
	function getArticleBody($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `post_body` FROM `posts` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['post_body'];
        }
        else
        {
            return "";
        }
    }
	function statusArticle($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `reviewed` FROM `posts` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['reviewed'];
        }
        else
        {
            return false;
        }
    }
	function isdeletedPost($post) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `posts` WHERE `id`='".$post."' AND `deleted`='1'";
		connection()->query($sql);
		
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function existPost($post) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `posts` WHERE `id`='".$post."'";
		connection()->query($sql);
		
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function likePost($id, $post) {
		
		require_once('ini.php');
		
		$email = getEmail($id);
		
        if(!isLikingPost($id, $post)) {
            $sql="UPDATE `posts` SET `post_likes` = CONCAT(post_likes,'".$email.",') WHERE `id`='".$post."';";
            $result = connection()->query($sql);
        }
    }
    function unlikePost($id, $post) {
		
		require_once('ini.php');
		
		$email = getEmail($id);
		
        if(isLikingPost($id, $post)) {
            $sql = "UPDATE `posts` SET post_likes = REPLACE(post_likes,'" . $email . ",','') WHERE `id`='".$post."';";
            $result = connection()->query($sql);
        }
    }
	function isLikingPost($id, $post) {
		
		require_once('ini.php');
		
		$email = getEmail($id);

        $sql = "SELECT * FROM `posts` WHERE `id`='".$post."' AND `post_likes` LIKE '%{$email}%'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function hasCommentPost($id, $post) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `comments` WHERE `user_id`='".$id."' AND `post_id`='".$post."' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function countLikesPost($post) {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `posts` WHERE `id`='".$post."'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $likes = explode(",", $row['post_likes']);
        return (count($likes)-1);
    }
	function countCommentsPost($post) {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `comments` WHERE `post_id`='".$post."' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function postCommentPost($comment, $post_id, $user_id){
		
        require_once('ini.php');

        if($comment != '' && $post_id != '' && $user_id != ''){
			$sql  = "INSERT INTO `comments` (`user_id`, `post_id`, `data`, `datum`) VALUES ('".save_mysql($user_id)."', '".save_mysql($post_id)."', '".save_mysql($comment)."', '".date("d/m/Y")."');";
            $conn = connection();
            $id = $conn->query($sql);
				
            return 'post_comment_success';
        }
        else{
			return '?id='.$post_id.'&warning=Not all fields are filled in.';
        }
    }
	/* Article End */
	
	/* MineThemepark */
	
	function addMTPPost($title, $body, $headerimg, $posterimg)
    {
        require_once('ini.php');
		
        if($headerimg == 'Invalid URL' || $headerimg == '') {
            $headerimg = 'http://minethemepark.com/inc/img/background/bg-01.png';
        }
        if($posterimg == 'Invalid URL' || $posterimg == '') {
            $bodyimg = 'http://minethemepark.com/inc/img/background/bg-01.png';
        }
		
        $sql = "INSERT INTO `minethemepark_posts` (`post_title`, `post_body`, `post_header`, `post_poster`, `posted_on`) VALUES ('".save_mysql($title)."', '".save_mysql($body)."', '".save_mysql($headerimg)."', '".save_mysql($posterimg)."', '".date("d/m/Y")."')";
        $conn = connection();
		$id = $conn->query($sql);
		
    }
	function getMTPpostImage($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `post_header` FROM `minethemepark_posts` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['post_header'];
        }
        else
        {
            return "";
        }
    }
	function getMTPbody($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `post_body` FROM `minethemepark_posts` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['post_body'];
        }
        else
        {
            return "";
        }
    }
	function getMTPdate($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `posted_on` FROM `minethemepark_posts` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['posted_on'];
        }
        else
        {
            return "";
        }
    }
	function getMTPtitle($id)
    {
        require_once('ini.php');
        
        $sql 	= "SELECT `post_title` FROM `minethemepark_posts` WHERE `id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['post_title'];
        }
        else
        {
            return "";
        }
    }
	function existMTP($post) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `minethemepark_posts` WHERE `id`='".$post."'";
		connection()->query($sql);
		
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function isdeletedMTP($post) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `minethemepark_posts` WHERE `id`='".$post."' AND `deleted`='1'";
		connection()->query($sql);
		
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function likeMTP($id, $post) {
		
		require_once('ini.php');
		
		$email = getEmail($id);
		
        if(!isLikingMTP($id, $post)) {
            $sql="UPDATE `minethemepark_posts` SET `post_likes` = CONCAT(post_likes,'".$email.",') WHERE `id`='".$post."';";
            $result = connection()->query($sql);
        }
    }
    function unlikeMTP($id, $post) {
		
		require_once('ini.php');
		
		$email = getEmail($id);
		
        if(isLikingMTP($id, $post)) {
            $sql = "UPDATE `minethemepark_posts` SET post_likes = REPLACE(post_likes,'" . $email . ",','') WHERE `id`='".$post."';";
            $result = connection()->query($sql);
        }
    }
	function isLikingMTP($id, $post) {
		
		require_once('ini.php');
		
		$email = getEmail($id);

        $sql = "SELECT * FROM `minethemepark_posts` WHERE `id`='".$post."' AND `post_likes` LIKE '%{$email}%'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function countLikesMTP($post) {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `minethemepark_posts` WHERE `id`='".$post."'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        $likes = explode(",", $row['post_likes']);
        return (count($likes)-1);
    }
	function hasCommentMTP($id, $post) {
		
		require_once('ini.php');

        $sql = "SELECT * FROM `minethemepark_comments` WHERE `user_id`='".$id."' AND `post_id`='".$post."' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function countCommentsMTP($post) {
		
		require_once('ini.php');
		
        $sql = "SELECT * FROM `minethemepark_comments` WHERE `post_id`='".$post."' AND `deleted`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
		
        return $count;
    }
	function postCommentMTP($comment, $post_id, $user_id){
		
        require_once('ini.php');

        if($comment != '' && $post_id != '' && $user_id != ''){
			$sql  = "INSERT INTO `minethemepark_comments` (`user_id`, `post_id`, `data`, `datum`) VALUES ('".save_mysql($user_id)."', '".save_mysql($post_id)."', '".save_mysql($comment)."', '".date("d/m/Y")."');";
            $conn = connection();
            $id = $conn->query($sql);
				
            return 'mtp_comment_success';
        }
        else{
			return '?id='.$post_id.'&warning=Not all fields are filled in.';
        }
    }
	function updateMTPpost($post_id, $title, $body) {
		
		require_once('ini.php');
		
		if($post_id != '' && $title != '' && $body != '') {
			
			$sql 	= "SELECT * FROM `minethemepark_posts` WHERE `id`='".$post_id."'";
			$result = connection()->query($sql);
			if($result->num_rows > 0)
			{
				$body = preg_replace("/\r\n|\r/", "<br>", $body);
				$body = strip_tags($body, '<strong>, <i>, <br>, <h1>, <h2>, <h3>, <h4>, <h5>, <u>, <del>, <a>');
				
				$sql = "UPDATE `minethemepark_posts` SET `post_title`='".$title."' WHERE `id`='".$post_id."';";
				connection()->query($sql);
			
				$sql = "UPDATE `minethemepark_posts` SET `post_body`='".$body."' WHERE `id`='".$post_id."';";
				connection()->query($sql);
				
				return 'update-mtp-post-success';
			}
			else {
				return("index.php?danger=Something went wrong, try again.");
			}
        }
		else {
			return("index.php?danger=Something went wrong, try again.");
		}
    }
	/* MineThemepark End */
	
	/* Staff */
	function addMTPstaff($email){
		
        require_once('ini.php');

        if($email != ''){
			
			$sql = "SELECT * FROM `users` WHERE `email`='".$email."'";
			$result = connection()->query($sql);
			$count = mysqli_num_rows($result);
			if($count > 0) {
			
				$user_id = getIDfromMail($email);
			
				$sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$user_id."'";
				$result = connection()->query($sql);
				$count = mysqli_num_rows($result);
				if(!$count > 0) {
				
					$sql  = "INSERT INTO `mtp_staff` (`user_id`) VALUES ('".save_mysql($user_id)."');";
					$conn = connection();
					$id = $conn->query($sql);
					
				
					return 'mtp_add_staff_success';
				}
				else{
					return '?warning=That user is already a staff member.';
				}
			}
			else {
				return '?warning=That email adress is unknown.';
			}
		}
		else{
			return '?warning=Not all fields are filed in.';
		}
    }
	function canManagePosts($id) {
        $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."' AND `can_manage_posts`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canUseStaffPanel($id) {
        $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."' AND `can_use_staffpanel`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canManageparkRequests($id) {
        $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."' AND `can_manage_parkrequests`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canManageComments($id) {
        $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."' AND `can_manage_comments`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canManageUsers($id) {
        $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."' AND `can_manage_users`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canManageStaff($id) {
        $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."' AND `can_manage_staff`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canManageSettings($id) {
        $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."' AND `can_manage_settings`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function canWritePost($id) {
        $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."' AND `can_write_post`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function isStaff($id) {
        $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='".$id."'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }
	function getStaffRank($id) {
        require_once('ini.php');
        
        $sql 	= "SELECT `rank` FROM `mtp_staff` WHERE `user_id`='".$id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
            return $result->fetch_assoc()['rank'];
        }
        else
        {
            return "";
        }
    }
	function getRank($id) {
		
		require_once('ini.php');
		
		$sql 	= "SELECT * FROM `ranks` WHERE `id`='".$id."'";
		$result = connection()->query($sql);
		$count = mysqli_num_rows($result);
		if($count > 0) {
			while($row = $result->fetch_assoc())
			{
			  return '<span class="label label-'.$row['color'].'">'.$row['name'].'</span>';
			}
		}
		else {
			return '';
		}
	}
	function acceptParkRequest($park_id) {
		
		require_once('ini.php');
		
		$sql 	= "SELECT * FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
			$sql = "UPDATE `parks` SET `reviewed`='1' WHERE `id`='".$park_id."';";
			$result = connection()->query($sql);
			
			addParkStaffOwner($park_id);
        }
    }
	function rejectParkRequest($park_id) {
		
		require_once('ini.php');
		
		$sql 	= "SELECT * FROM `parks` WHERE `id`='".$park_id."'";
        $result = connection()->query($sql);
        if($result->num_rows > 0)
        {
			$sql = "UPDATE `parks` SET `deleted`='1' WHERE `id`='".$park_id."';";
			$result = connection()->query($sql);
			
			$sql = "UPDATE `parks` SET `reviewed`='2' WHERE `id`='".$park_id."';";
			$result = connection()->query($sql);
        }
    }
	
	
	/* Staff End */
	
    
	
?>