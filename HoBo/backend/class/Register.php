<?php

    require_once 'Online.php';

    class Register extends Online {

        public function create($data) {
            try {
                if($data['password'] != $data['conf-password']) {
                    throw new Exception("Wachtworden zijn niet het zelfde.");
                }
                $passwordEncrypt = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

                $sql = "INSERT INTO users (Voornaam, Tussenvoegsel, Achternaam, Email, Password, Ip) VALUES (:Voornaam, :Tussenvoegsel, :Achternaam, :Email, :Password, :Ip)";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(":Voornaam", $data['voornaam']);
                $stmt->bindParam(":Tussenvoegsel", $data['tussenvoegsel']);
                $stmt->bindParam(":Achternaam", $data['achternaam']);
                $stmt->bindParam(":Email", $data['email']);
                $stmt->bindParam(":Password", $passwordEncrypt);
                $stmt->bindParam(":Ip", $this->get_client_ip());
                if($stmt->execute()) {
                    header("Location: login.php");
                }
            } catch(Exception $e) {
                echo $e->getMessage();
            }
        } 

        public function getUser() {
            $sql = "SELECT KlantNr, Voornaam, Password FROM users";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>
