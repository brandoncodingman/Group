<?php

class DbManager {
    private PDO $conn;

    public function __construct() {
        $dsn = 'mysql:dbname=fluffy_planets;host=127.0.0.1;charset=utf8';
        $user = 'root';
        $password = '';

        try {
            $this->conn = new PDO($dsn, $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("DB接続エラー: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->conn;
    }
}


    
