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
    <!-- <link rel="stylesheet" href="index.html"> -->
    <link rel="stylesheet" href="./css/app.css" />
    <link rel="stylesheet" href="./css/music.css">
    <script src="./js/music.js" defer></script>
    <link rel="stylesheet" href="./css/shop.css">
    <title>Shop</title>
</head>

<body>
    <header>
        <h1>Fluffy Planets</h1>
        <button id="music-toggle" class="music-btn">🔇 Music Off</button>
    </header>

    <nav id="nav">
        <ul>
            <li><a href="./index.html">Home</a></li>
            <li><a href="./diary1.php">Diary</a></li>
            <li><a href="./character.php">Character</a></li>
            <li><a href="./information.html">Info</a></li>
            <li><a href="./shop.php">Shop</a></li>
            <li><a href="./cart.php">Cart</a></li>
        </ul>
    </nav>
    <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

    <div class="shop">
        <div class="tshirt_container">
            <div class="t-shirt">
                <button class="left"><</button>
                    <a href="./t-shirt.php">
                            <img src="../Group/img/Tshirt_front.png" alt="" id="front" style="display: block;">
                            <img src="../Group/img/Tshirt_back.png" alt="" id="back">
                        </a>
                            <button class="right">></button>
                </div>
                <a href="./t-shirt.php">
                    <p class="name">Tシャツ</p>
                </a>
                <p class="price">￥3,630</p>
            </div>
        <div class="case_beige">
                <a href="./case_beige.php">
                <img src="../Group/img/case_beige.png" alt="">
                <p class="name">スマホケース(ベージュ) </p>
            </a>
                <p class="price">￥2,530</p>
            </div>
        <div class="case_green">
                <a href="./case_green.php">
            <img src="../Group/img/case_green.png" alt="">
                <p class="name">スマホケース(グリーン) </p>
            </a>
                <p class="price">￥2,530</p>
            </div>
        <div class="Tumbler">
                <a href="./Tumbler.php">
                <img src="../Group/img/Tumbler.png" alt="">
                <p class="name">タンブラー (2個セット) </p>
            </a>
                <p class="price">￥8,800</p>
            </div>
        <div class="DIARY">
                <a href="./DIARY.php">
                <img src="../Group/img/DIARY.png" alt="">
                <p class="name">日記帳</p>
            </a>
                <p class="price">￥1,100</p>
            </div>
        <div class="underlay">
            <a href="./underlay.php">
                <img src="../Group/img/underlay.png" alt="">
                <p class="name">下敷き</p>
            </a>
                <p class="price">￥550</p>
        </div>
    </div>



    <footer>&copy; 2025 Fluffy Planets</footer>


    <!-- <script src="./js/app.js"></script> -->
    <script src="./js/t-shirt.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/shop.js"></script>

</body>

</html>