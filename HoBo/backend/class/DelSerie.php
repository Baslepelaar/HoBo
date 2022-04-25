<?php

require_once 'UserRight.php';

class DelSerie extends UserRight {

    function delSerie($userId, $serieId) {

//        die(var_dump($userId));
        if($this->canManageFilms($userId)) {

            $sql = "SELECT * FROM serie WHERE SerieID = :serieId";

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':serieId', $serieId);
            $stmt->execute();
            $serieDel = $stmt->fetch(PDO::FETCH_OBJ);
            if($serieDel->Actief == 1){
                $sql = "UPDATE serie SET Actief = 0 WHERE SerieID = :serieId";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(':serieId', $serieId);
                $stmt->execute();

                header('Location: ../serie-list.php?id='.$serieId.'&success=The status of this post is successfully switched.');
            } else {
                header('Location: ../serie-list.php?danger=We cant find that post.');
            }
        }
    }

    function restoreSerie($userId, $serieId) {

//        die(var_dump($userId));
        if($this->canManageFilms($userId)) {

            $sql = "SELECT * FROM serie WHERE SerieID = :serieId";

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':serieId', $serieId);
            $stmt->execute();
            $serieDel = $stmt->fetch(PDO::FETCH_OBJ);
            if($serieDel->Actief == 0){
                $sql = "UPDATE serie SET Actief = 1 WHERE SerieID = :serieId";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(':serieId', $serieId);
                $stmt->execute();

                header('Location: ../serie-list.php?id='.$serieId.'&success=The status of this post is successfully switched.');
            } else {
                header('Location: ../serie-list.php?danger=We cant find that post.');
            }
        }
    }

}