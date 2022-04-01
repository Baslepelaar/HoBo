<?php

require_once 'Online.php';

class Login extends Online {

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
//            die(var_dump($user));
            if(!$user) {
                header("Location: login.php?login=danger");
                throw new Exception("Danger");
            }
            if(!password_verify($data['password'], $user->Password)) {
                header("Location: login.php?login=danger");
                throw new Exception("Danger");
            }
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $user->Email;
            $_SESSION['klantnr'] = $user->KlantNr;
            header("Location: index.php?login=success");
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
}
?>