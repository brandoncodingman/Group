<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Bangers&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="./css/app.css" />
    <link rel="stylesheet" href="./css/music.css">
    <script src="./js/music.js" defer></script>
    <link rel="stylesheet" href="./css/t-shirt.css">
    <title>Shop - t-shirt</title>
</head>

<body>
     <!-- <video id="video" style="display: none;" src="./img/onload.mp4"></video> -->
    <!-- Character -->
    <img id="character" src="./img/default.png" alt="Character" />

  <header>
    <?php include_once __DIR__ . '../includes/Header.php'; ?>

   
      <button id="music-toggle" class="music-btn">🔇 Music Off</button>
         <?php if ($loginStatus['logged_in']): ?>
    <?php endif; ?>

      <h1>Fluffy Planets</h1>
    <div class="user-info">
        <span class="username">ようこそ、<?php echo htmlspecialchars($loginStatus['username']); ?>さん！</span>
        <span class="points">ポイント: <?php echo $loginStatus['points']; ?></span>
        <a href="actions/logout.php" class="logout-btn">ログアウト</a>
    </div>
    </header>

    <nav id="nav">
              <ul>
        <li><a href="./index.php">Home</a></li>
        <li><a href="./diary1.php">Diary</a></li>
        <li><a href="./character.php">Character</a></li>
        <li><a href="./information.php">Info</a></li>
        <li><a href="./shop.php">Shop</a></li>
        <li><a href="./cart.php">Cart</a></li>
      </ul>
    </nav>
    <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
    <div class="t-shirt">
        <div class="img">
            <button class="left"><</button>
             <img src="./img/Tshirt_front.png" alt="" id="front" style="display: block;">
             <img src="./img/Tshirt_back.png" alt="" id="back">
            <button class="right">></button>
        </div>
        <div class="detail">
            <div class="about">
                <h1 id="item">Tシャツ</h1>
                <p id="price">￥3,630</p>
            </div>
            <div class="buy">
                <div class="count">
                    <img src="../Group/img/mainasu.svg" alt="マイナスボタン" id="decrease">
                    <p id="quantity">1</p>
                    <img src="../Group/img/plus.svg" alt="プラスボタン" id="increase">
                </div>
                <input type="submit" value="カートに入れる">
            </div>
            <a href="./shop.php"><button id="back_shop">一覧へ戻る</button></a>
        </div>
    </div>

 <footer>&copy; 2025 Fluffy Planets <br><span class="iip">Created ❤️ with by Miyazaki, Matsura, Brandon.</span></footer>
     <script src="./js/t-shirt.js"> </script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/shop.js"></script>
       <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/balloon.js"></script>
    <script src="./js/firstview.js"></script>
     <script src="./js/global-character-loader.js"></script>
</body>

</html>