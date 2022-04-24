<?php

require_once 'UserRight.php';

class DelSerie extends UserRight {

    function delSerie($id) {
        $serie = $_GET['serie'];
        $data = $_GET['data'];

        if($this->canManageFilms($id)) {

            $sql = "SELECT * FROM serie WHERE SerieID ='".$serie."'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if(sizeof($stmt->fetchAll(PDO::FETCH_OBJ)) > 0){
                $sql = "UPDATE serie SET Actief ='".$data."' WHERE SerieID ='".$serie."';";
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute();

                header('Location: admin.php?id='.$serie.'&success=The status of this post is successfully switched.');
            } else {
                header('Location: ../?danger=We cant find that post.');
            }
        }
    }

}