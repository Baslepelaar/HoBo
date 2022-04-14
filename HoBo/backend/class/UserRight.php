<?php

require_once 'Online.php';

class UserRight extends Online {

    public function canUseStaffPanel($id) {
        $sql = "SELECT * FROM `userrights` WHERE `User_ID`='".$id."' AND `Can_use_adminpanel`='1'";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function canManageSettings($id) {
        $sql = "SELECT * FROM userrights WHERE User_ID = :id AND Can_manage_settings = '1'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if(sizeof($stmt->fetchAll(PDO::FETCH_OBJ)) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function canManageStaff($id) {
        $sql = "SELECT * FROM userrights WHERE User_ID = :id AND Can_manage_admins = '1'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if(sizeof($stmt->fetchAll(PDO::FETCH_OBJ)) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function canManageUsers($id) {
        $sql = "SELECT * FROM userrights WHERE User_ID = :id AND Can_manage_users = '1'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if(sizeof($stmt->fetchAll(PDO::FETCH_OBJ)) > 0) {
            return true;
        } else {
            return false;
        }
    }

}
?>
