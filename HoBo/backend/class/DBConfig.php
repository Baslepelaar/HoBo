<?php
    class DBConfig {
        public function connect() {
            try {
                $conn = new PDO("mysql:host=localhost;dbname=hobo2022", 'root', '');
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
function connection()
{
    $host = "localhost";
    $user = 'root';
    $pass = '';
    $db = 'hobo2022';

    return $link = mysqli_connect($host, $user, $pass, $db);
}