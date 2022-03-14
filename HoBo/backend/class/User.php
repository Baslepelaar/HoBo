<?php

    require_once 'DBConfig.php';

    class User extends DBConfig {

        public function create($data) {
            try {
                if($data['password'] != $data['conf-password']) {
                    throw new Exception("Wachtworden zijn niet het zelfde.");
                }
                $passwordEncr = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

                $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(":username", $data['username']);
                $stmt->bindParam(":password", $passwordEncr);
                if($stmt->execute()) {
                    header("Location: login.php");
                }
            } catch(Exception $e) {
                echo $e->getMessage();
            }
        }

        public function getUsers() {
            $sql = "SELECT id, username FROM users";
            $stmt = $this->connect()->prepare($sql);
            $stmt->exeute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>