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

}
?>
