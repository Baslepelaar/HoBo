<?php

    require_once 'IP.php';

    class Online extends IP {

        public function getIs_online($id){
            if(!empty($$id)){
    
                $sql = "SELECT * FROM `users` WHERE `KlantNr`='".$id."' AND `Banned`='0'";
                $result = connection()->query($sql);
    
                if($result->num_rows > 0){
                    
                    return true;
                }
                else{
                    
                    return false;
                }
            }
            else{
                return false;
            }
        }
        
    }
?>
