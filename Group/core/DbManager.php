<?php

class DbManager {
    private PDO $conn;

    public function __construct() {
        $dsn = 'mysql:dbname=LAA1651812-fluffy;host=mysql320.phy.lolipop.lan;charset=utf8';
        $user = 'LAA1651812';
        $password = 'root';

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

// function getDb() :PDO{
//     $dsn = 'mysql:dbname=fluffy_planets;host=127.0.0.1;charset=utf8';
//         $user = 'root';
//         $password = '';

//         $db = new PDO($dsn,$user,$password);
//         return $db;
// }

    