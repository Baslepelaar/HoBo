<?php

require_once 'Online.php';

class UserRight extends Online {

    public function canUseStaffPanel($id) {
        $sql = "SELECT * FROM `userrights` WHERE `user_id`='".$id."' AND `can_use_staffpanel`='1'";
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
