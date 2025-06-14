<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rampart+One&display=swap" rel="stylesheet">
    <title>ログインページ</title>
</head>

<body>
    <img src="./img/open_door.jpg" alt="">
    <div class="login">
        <h1>ユーザーIDとパスワード<br class="br">を入力してください</h1>
        <p>新規登録は<a href="register.php">こちら</a>へ</p>
        <div class="form">
            <form action="actions/Login.php" method="POST">
                <div class="input">
                    <span>ユーザーID：<br class="br"><input type="text" name="username" required></span><br>
                    <span>パスワード：<br class="br"><input type="password" name="password" required></span><br>
                </div>
                <div class="submit-container">
                    <input class="submit" type="submit" value="ログイン">
                </div>
            </form>
        </div>
    </div>
      <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/balloon.js"></script>
    <script src="./js/firstview.js"></script>
     <script src="./js/global-character-loader.js"></script>
</body>
</html>
