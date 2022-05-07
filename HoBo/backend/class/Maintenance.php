<?php

require_once 'DBConfig.php';

class Maintenance extends DBConfig {

    function getMaintenance() {

        $sql 	= "SELECT data FROM settings WHERE variable ='maintenance'";
        $result = connection()->query($sql);
        if($result->num_rows > 0) {
            return $result->fetch_assoc()['data'];
        } else {
            return "";
        }
    }
}
?>
