<?php
function getDb() : PDO{
    $dsn = 'mysql:dbname=miyazakigroup; host=127.0.0.1; charset=utf8';
    $user ='root';
    $password = '';

    $db =new PDO($dsn,$user,$password);
    return $db;
}