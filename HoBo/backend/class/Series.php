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

            public function setHistory($sid){
                try {
                    $sql = "INSERT INTO history (KlantNr, SerieID) VALUES (:KlantNr, :SerieID)";
                    $connExec = $this->connect()->prepare($sql);
                    $connExec->bindParam(":KlantNr", $_SESSION['klantnr']);
                    $connExec->bindParam(":SerieID", $sid);
                    $connExec->execute();
                } catch (Exception $e){
                    echo $e->getMessage();
                }
            }

            public function getHistory(){
                $sql = "SELECT serie.SerieTitel, DATE_FORMAT(history.DateOfStream, '%d-%m-%Y %H:%i') as datum FROM history
                        INNER JOIN serie ON history.SerieID = serie.SerieID
                        WHERE history.KlantNr = " . $_SESSION['klantnr'];
                $connExec = $this->connect()->prepare($sql);
                $connExec->execute();
                return $connExec->fetchAll(PDO::FETCH_OBJ);    
            }



            

        }

?>