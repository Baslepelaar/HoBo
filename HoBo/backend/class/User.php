<?php

    require_once 'DBConfig.php';

    class User extends DBConfig {

        function getUser($id) {
            $sql 	= "SELECT * FROM users WHERE KlantNr = :KlantNr";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":KlantNr", $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>