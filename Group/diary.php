<?php
require_once './DbManager.php';
require_once './Encode.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th>日記</th>
                <th>件名</th>
                <th>投稿日時</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $db = getDb();
                $stt = $db->prepare('SELECT number,date,title FROM diary');
                $stt->execute();

                while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <tr>
                        <td><a href=""><?=e($row['number'])?></a></td>
                        <td><a href=""><?=e($row['date'])?></a></td>
                        <td><a href=""><?=e($row['title'])?></a></td>
                    </tr>
            <?php
                }
            } catch (PDOException $e) {
                die("エラーメッセージ：{$e->getMessage()}");
            }
            ?>
        </tbody>
    </table>
</body>

</html>