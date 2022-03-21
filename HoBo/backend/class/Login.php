<?php

require_once 'Register.php';

class Login extends DBConfig {

    public function getUser($email) {
        $sql = "SELECT Password, Email, KlantNr FROM users WHERE Email = :Email";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':Email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function login($data) {
        try {
            $user = $this->getUser($data['email']);
            if(!$user) {
                throw new Exception("Gebruiker bestaat niet.");
            }
           // var_dump($data);
            if(!password_verify($data['password'], $user->Password)) {
                throw new Exception("Wachtwoord is incorrect.");
            }
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $user->email;
            header("Location: backend/admin.php");
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>