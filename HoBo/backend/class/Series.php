<?php
    require_once 'DBConfig.php';

        Class Series extends DBConfig{

            public $serieId;
            // public $serieTitle;
            // public $serieDescription;
            // public $serieImdb;
            // public $serieSeason;

            public function getSerie(){
                $sql = "SELECT * FROM serie";
                $connExec = $this->connect()->prepare($sql);
                $connExec->execute();
                return $connExec->fetchAll(PDO::FETCH_OBJ);

            }

            public function getSerieImdb(){
                $sql = "SELECT * FROM serie WHERE SerieID = " . $_GET['serie'];
                $connExec = $this->connect()->prepare($sql);
                $connExec->execute();
                return $connExec->fetchAll(PDO::FETCH_OBJ);

            }

            public function searchSerie($search){
                $sql = "SELECT * FROM serie WHERE SerieTitel LIKE '%" . $search . "%'" ;
                $connExec = $this->connect()->prepare($sql);
                $connExec->execute();
                return $connExec->fetchAll(PDO::FETCH_OBJ);
            }



            

        }

?>