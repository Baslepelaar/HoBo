<?php

require_once 'DBConfig.php';

class Series extends DBConfig {


    public function getSeries() {
        $sql = "SELECT SerieTitel, IMDBLink FROM serie";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}