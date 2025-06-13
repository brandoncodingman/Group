<?php
require_once __DIR__ . '/core/Session.php';

Session::requireLoginForAllPages();

$loginStatus = Session::getLoginStatus();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fluffy Planet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Bangers&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/app.css" />
    <link rel="stylesheet" href="./css/balloon.css" />
    <link rel="stylesheet" href="./css/firstview.css" />
    <link rel="stylesheet" href="./css/indextable.css" />
    <link rel="stylesheet" href="./css/music.css" />
    <script src="./js/music.js" defer></script>
  </head>
  <body>
    <video id="video" style="display: none" src="./img/onload.mp4"></video>
    <!-- Character -->
    <img id="character" src="./img/default.png" alt="Character" />

    <header>
      <?php include_once __DIR__ . '../includes/Header.php'; ?>

      <button id="music-toggle" class="music-btn">🔇 Music Off</button>
      <?php if ($loginStatus['logged_in']): ?>
      <?php endif; ?>

      <h1>Fluffy Planets</h1>
      <div class="user-info">
        <span class="username"
          >ようこそ、<?php echo htmlspecialchars($loginStatus['username']); ?>さん！</span
        ><br class="br">
        <span class="points"
          >ポイント:
          <?php echo $loginStatus['points']; ?></span
        ><br class="br">
        <a href="actions/logout.php" class="logout-btn">ログアウト</a><br class="br">
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

    <div id="media-container">
      <!-- Video element -->
      <video id="videoElement" autoplay muted>
        <source src="./img/dairypoints.mp4" type="video/mp4" />
        Your browser does not support the video tag.
      </video>

      <img id="imageElement" src="./img/header.png" alt="Fallback Image" />
    </div>
    <div class="balloon-container">
      <div class="balloon">
        <a href="./shop.php"
          ><img src="./img/clothingvideo.jpg" alt="shop" />
          <figcaption>Shop</figcaption></a
        >
      </div>
      <div class="balloon">
        <a href="./diary1.php"
          ><img src="./img/diarybook.jpg" alt="diary" />
          <figcaption>Diary</figcaption></a
        >
      </div>
      <div class="balloon">
        <a href="./character.php"
          ><img src="./img/earth-nobg.png" alt="character" />

          <figcaption>Characters</figcaption></a
        >
      </div>
    </div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th class="index-title">ページ</th>
            <th class="index-title">説明</th>
          </tr>
        </thead>
        <tbody>
          <tr onclick="toggleDetails(this)">
            <td>Diary ページ</td>
            <td>日記を書いてスターダストポイントを獲得しましょう。</td>
          </tr>
          <tr class="details">
            <td colspan="2">日記のふきだしはクリックで変化します。</td>
          </tr>
          <tr onclick="toggleDetails(this)">
            <td>Characters ページ</td>
            <td>解除済みのキャラクターを閲覧・管理できます。</td>
          </tr>
          <tr class="details">
            <td colspan="2">ここでキャラクターの詳細を確認できます。</td>
          </tr>
          <tr onclick="toggleDetails(this)">
            <td>Shop ページ</td>
            <td>Fluffy Planet公式グッズを購入できます。</td>
          </tr>
          <tr class="details">
            <td colspan="2">季節限定のセール情報もお見逃しなく。</td>
          </tr>
          <tr onclick="toggleDetails(this)">
            <td>Stardust Points</td>
            <td>登録、日記の記入、ショップ購入で獲得できます。</td>
          </tr>
          <tr class="details">
            <td colspan="2">
              スターダストポイントはナビバーかキャラクターページで確認できます。
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="youtube-container">
      <iframe
        width="560"
        height="315"
        src="https://www.youtube.com/embed/OT1lfeIDoj4?si=bofpX6KokDLCCiNJ"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen
      ></iframe>
    </div>

    <footer>
      &copy; 2025 Fluffy Planets <br /><span class="iip"
        >Created with ❤️ by Miyazaki, Matsura, Brandon.</span
      >
    </footer>
    <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/balloon.js"></script>
    <script src="./js/firstview.js"></script>
    <script src="./js/global-character-loader.js"></script>
  </body>
</html>
