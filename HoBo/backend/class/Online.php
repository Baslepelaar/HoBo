<?php

    require_once 'IP.php';

    class Online extends IP {

        public function getIs_online(){
            if(!empty($_SESSION['klantnr'])){
    
                $sql = "SELECT * FROM `users` WHERE `KlantNr`='".$_SESSION['klantnr']."' AND `Banned`='0'";
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
