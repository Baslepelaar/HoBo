<?php

require_once 'Register.php';

class Login extends Register {

    public function getUser() {
        $sql = "SELECT KlantNr, Voornaam, Password FROM users";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function login($data) {
        try {
            $user = $this->getUser($data['voornaam']);
            if(!$user) {
                throw new Exception("Gebruiker bestaat niet.");
            }
            if(!password_verify($data['password'], $user->password)) {
                throw new Exception("Wachtwoord is incorrect.");
            }
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['voornaam'] = $user->voornaam;
            header("Location: backend/admin.php");
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>