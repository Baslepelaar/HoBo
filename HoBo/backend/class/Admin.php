<?php

require_once 'DBConfig.php';

class Admin extends DBConfig
{

    function countUsers()
    {

        $sql = "SELECT KlantNr FROM `users` WHERE `active`='1' AND `banned`='0'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);

        return $count;
    }

    function countBannedUsers() {

        $sql = "SELECT * FROM `users` WHERE `banned`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);

        return $count;
    }

    function countSeries() {

        $sql = "SELECT * FROM `serie`";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);

        return $count;
    }

    function countStream() {

        $sql = "SELECT * FROM `stream`";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);

        return $count;
    }

    public function addAdmin($data) {
        try {
            if($data['Email'] != '') {
                    $sql 	= "SELECT KlantNr FROM users WHERE Email=:email ";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindParam(':email', $data['Email']);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_OBJ);
                    if($user != false) {
                        $user_id = $stmt->fetch(PDO::FETCH_OBJ);

                        $sql = "SELECT * FROM userrights WHERE User_ID =:userid ";
                        $stmt = $this->connect()->prepare($sql);
                        $stmt->bindParam(':userid', $user_id);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_OBJ);
                        if(!$result) {
                            $sql = "INSERT INTO userrights (User_ID) VALUES (:user_id)";
                            $stmt = $this->connect()->prepare($sql);
                            $stmt->bindParam(':user_id', $user->KlantNr);
                            if($stmt->execute()) {
                                header("Location: admin.php?succes");
                            }
                        } else {
                            header("Location: admin.php?already");
                        }
                    } else {
                        header("Location: admin.php?unkown");
                    }
                } else {
                header("Location: admin.php?veld leeg");
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAdmin() {
        $sql = "SELECT * FROM userrights
                JOIN users ON 
                    users.KlantNr = userrights.User_ID
                ORDER BY ID ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function getUserData() {
        $sql = "SELECT * FROM users ORDER BY KlantNr ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
