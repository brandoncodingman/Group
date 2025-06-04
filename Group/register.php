<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/register.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rampart+One&display=swap" rel="stylesheet">
    <title>新規登録</title>
</head>

<body>
    <img src="./img/close_door.jpg" alt="">
    <div class="login">
        <h1>ユーザーIDとパスワードを設定してください</h1>
        <p>ログインは<a href="login.php">こちら</a>へ</p>
        <div class="form">
            <form action="actions/Register.php" method="POST">
                <div class="input">
                    <span>ユーザーID：<input type="text" name="username"></span><br>
                    <span>パスワード：<input type="text" name="password"></span><br>
                </div>
                <div class="submit-container">
            <input class="submit" type="submit" value="登録" />
          </div>
            </form>
        </div>
    </div>
      <!-- <script src="./js/register.js"></script> -->

</body>

</html>