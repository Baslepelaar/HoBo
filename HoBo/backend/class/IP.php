<?php

    require_once 'DBConfig.php';

    class IP extends DBConfig {
        public $ipaddress;

        public function get_client_ip() {
            // if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //     $this->ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            // } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //     $this->ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            // } else {
            //     $this->ipaddress = $_SERVER['REMOTE_ADDR'];
            // }
            $this->ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $this->ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $this->ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
             $this->ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $this->ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
                $this->ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $this->ipaddress = getenv('REMOTE_ADDR');
            else
                $this->ipaddress = 'UNKNOWN';

            return $this->ipaddress;
        }
        public function addIPtoList() {

            if($this->ipaddress == ''){

                echo 'het werkt niet';

                // $sql 	= "SELECT * FROM `ip` WHERE `ip`='".save_mysql($ip)."'";
                // $result = connection()->query($sql);
                // if($result->num_rows == 0) {

                //     $sql  = "INSERT INTO `ip` (`ip`, `datum`) VALUES ('".save_mysql($ip)."', '".date("d/m/Y")."');";
                //     $conn = connection();
                //     $id = $conn->query($sql);
                // }
            } else {
                try {
                    $sql = "INSERT INTO ip (Ip) VALUES (:Ip)";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindParam(":Ip", $this->ipaddress);

                } catch(Exception $e) {
                    echo $e->getMessage();
                }
                
            }
        }

        public function UpdateUserIP($user_id, $ip) {

            if($ip != '' && $ip != ''){

                $sql 	= "SELECT * FROM `users` WHERE `id`='".save_mysql($user_id)."' AND `ip`='None'";
                $result = connection()->query($sql);
                if($result->num_rows == 1) {

                    $sql = "UPDATE `users` SET `ip`='".save_mysql($ip)."' WHERE `id`='".$user_id."';";
                    $result = connection()->query($sql);
                }
            }
        }

        public function isIPBanned($ip) {
            $sql = "SELECT * FROM `ip` WHERE `ip`='".$ip."' AND `banned`='1'";
            $result = connection()->query($sql);
            $count = mysqli_num_rows($result);
            if($count > 0) {
                return true;
            } else {
                return false;
            }
        }

        function getIpFromUser($uid) {

            $sql 	= "SELECT ip FROM users WHERE KlantNr=".$uid."";
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
    }
?>
