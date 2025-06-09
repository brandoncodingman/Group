<?php
require_once "./core/DbManager.php";

try {
    $dbManager = new DbManager();
    $pdo = $dbManager->getConnection();
    // $userId = Session::getUserId();

    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT * FROM user_purchases ORDER BY date DESC');
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($result);
} catch (PDOException $e) {
    die("エラーメッセージ:{$e->getMessage()}");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文履歴</title>
    

</head>

<body>
</body>

</html>