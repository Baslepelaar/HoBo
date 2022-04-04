<?php

require_once 'DBConfig.php';

class Admin extends DBConfig
{

    public function addMTPstaff($email)
    {

        if ($email != '') {

            $sql = "SELECT * FROM `users` WHERE `email`='" . $email . "'";
            $result = connection()->query($sql);
            $count = mysqli_num_rows($result);
            if ($count > 0) {

                $user_id = getIDfromMail($email);

                $sql = "SELECT * FROM `mtp_staff` WHERE `user_id`='" . $user_id . "'";
                $result = connection()->query($sql);
                $count = mysqli_num_rows($result);
                if (!$count > 0) {

                    $sql = "INSERT INTO `mtp_staff` (`user_id`) VALUES ('" . save_mysql($user_id) . "');";
                    $conn = connection();
                    $id = $conn->query($sql);


                    return 'mtp_add_staff_success';
                } else {
                    return '?warning=That user is already a staff member.';
                }
            } else {
                return '?warning=That email adress is unknown.';
            }
        } else {
            return '?warning=Not all fields are filed in.';
        }
    }

    function countUsers()
    {

        $sql = "SELECT * FROM `users` WHERE `active`='1' AND `banned`='0'";
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

    function AddAdmin() {

    }
}
?>
