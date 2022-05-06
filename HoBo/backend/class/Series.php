<?php
    require_once 'DBConfig.php';

        Class Series extends DBConfig{

            public $serieId;

            public function getSerie(){ //algemene code om alles van de tabel series op te halen
                $sql = "SELECT * FROM serie";
                $connExec = $this->connect()->prepare($sql);
                $connExec->execute();
                return $connExec->fetchAll(PDO::FETCH_OBJ);

            }

            public function getSerieImdb(){ //zelfde als hierboven maar dan specifiek voor één serie
                //serieID word uit de webbalk variabele gehaald zodat specifiek die serie kan worden opgezocht in de database
                $sql = "SELECT * FROM serie WHERE SerieID = " . $_GET['serie'];
                $connExec = $this->connect()->prepare($sql);
                $connExec->execute();
                return $connExec->fetchAll(PDO::FETCH_OBJ);

            }

            public function searchSerie($search){ //hiermee krijg je zoek resultaten te zien in search.php
                $sql = "SELECT * FROM serie WHERE SerieTitel LIKE '%" . $search . "%' LIMIT 30" ;
                //beperking tot 30 zoek resultaten om de database niet te overbelasten
                $connExec = $this->connect()->prepare($sql);
                $connExec->execute();
                return $connExec->fetchAll(PDO::FETCH_OBJ);
            }

            public function setHistory($sid){ 
                //als je op de stream pagina terecht komt, dan word het opgeslagen in je geschiedenis
                //$sid is een afkorting voor SerieID
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
                //hierin word de geschiedenis opgehaald van de gebruiker.
                $sql = "SELECT serie.SerieTitel, DATE_FORMAT(history.DateOfStream, '%d-%m-%Y %H:%i') as datum, history.SerieID FROM history
                        INNER JOIN serie ON history.SerieID = serie.SerieID
                        WHERE history.KlantNr = " . $_SESSION['klantnr'] . " ORDER BY datum DESC LIMIT 30";
                        //beperking op geschiedenis ophalen om de server niet te overbelasten
                        //sorteren op datum van boven naar beneden ipv andersom
                $connExec = $this->connect()->prepare($sql);
                $connExec->execute();
                return $connExec->fetchAll(PDO::FETCH_OBJ);    
            }



            

        }

?>