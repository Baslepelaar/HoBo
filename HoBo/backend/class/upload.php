<?php
require_once 'DBConfig.php';

class uploadVideo extends DBConfig {
        
    public function uploadVideo($data, $id) {
                $target_dir = "../uploads/"; //gaat naar uploads
                $target_file = $target_dir . basename($_FILES["video"]["name"]); //uiteindelijke locatie
                $uploadOk = 0; //controle variabele
                $FileSql = "SELECT COUNT(SerieID) as SerieCount FROM serie";
                $FileSqlExec = $this->connect()->prepare($FileSql);
                $FileSqlExec->execute();
                $RowCount = $FileSqlExec->fetchColumn() . $id; //ieder bestand een unieke naam met id van admin
                $movieFileType = pathinfo($target_file,PATHINFO_EXTENSION); //alleen extentie eruit halen
                $FileName = $RowCount . "." . $movieFileType; //hier krijgt een variable de unieke naam die ik aan de foto wil geven
                $source = $_FILES["video"]["tmp_name"]; //dit is waar het bestand vandaan komt
                $location = $target_dir . $FileName; //combineren wat de bestandsnaam is en waar het moet komen staan

                

                try{

                    if($movieFileType == "mp4" || $movieFileType == "mov" || $movieFileType == "mkv") { //controle of extentie correct is
                        $uploadOk = 1; 
                    }

                    if ($uploadOk == 0) {
                        echo "Sorry, only mp4, mov or mkv files are allowed.";
                        // if everything is ok, try to upload file
                        } else {
                        if (move_uploaded_file($source, $location)) { //bestand van tijdelijke locatie "uploaden" naar echte locatie en opslaan
                            echo "file has been uploaded!."; 
                                try{
                                    $active = 0;
                                    $sql = "INSERT INTO serie (SerieTitel, IMDBLink, Actief, location) 
                                            VALUES (:SerieTitel, :IMDBLink, :Actief , :location)";
                                    $stmt = $this->connect()->prepare($sql);
                                    $stmt->bindParam(":SerieTitel", $data['title']);
                                    $stmt->bindParam(":IMDBLink", $data['imdb']);
                                    $stmt->bindParam(":Actief", $active);
                                    $stmt->bindParam(":location", $location);  
                                    if($stmt->execute()){
                                        echo "file has been uploaded!.";
                                    }
                                }catch(Exception $e){
                                    echo $e->getMessage();
                                }
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    
                        } 
                } catch(Exception $e){
                    echo $e->getMessage();
                }
        }
    }
?>