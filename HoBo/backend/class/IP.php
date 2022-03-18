<?php

    require_once 'DBConfig.php';

    class IP extends DBConfig {

        public function get_client_ip() {
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
        public function addIPtoList($ip) {

            if($ip != ''){

                $sql 	= "SELECT * FROM `ip` WHERE `ip`='".save_mysql($ip)."'";
                $result = connection()->query($sql);
                if($result->num_rows == 0) {

                    $sql  = "INSERT INTO `ip` (`ip`, `datum`) VALUES ('".save_mysql($ip)."', '".date("d/m/Y")."');";
                    $conn = connection();
                    $id = $conn->query($sql);
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
    }
?>
