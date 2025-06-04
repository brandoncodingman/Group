<?php
require "Points.inc.php";
Class DbManager{

    
     private PDO $conn;
 function getDb() : PDO{
    $dsn = 'mysql:dbname=fluffy_planets; host=127.0.0.1; charset=utf8';
    $user ='root';
    $password = '';


    $db =new PDO($dsn,$user,$password);
    return $db;

       try {
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("DB Error: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->conn;
    }
}

    
