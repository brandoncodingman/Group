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
    <div class="login">
        <h1>ユーザーIDとパスワードを入力してください</h1>
        <p>新規登録は<a href="register.php">こちら</a>へ</p>
        <div class="form">
            <form action="" method="POST">
                <div class="input">
                    <span>ユーザーID：<input type="text" name="username"></span><br>
                    <span>パスワード：<input type="text" name="password"></span><br>
                </div>
                <div class="submit"><input type="submit" value="ログイン" ></div>
            </form>
        </div>
    </div>
</body>

</html>