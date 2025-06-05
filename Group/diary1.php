<?php
require_once __DIR__ . '/core/Session.php';

Session::requireLoginForAllPages();

$loginStatus = Session::getLoginStatus();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Fluffy Planet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Bangers&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/diary.css" />
    <link rel="stylesheet" href="./css/music.css" />
    <script src="./js/music.js" defer></script>
  </head>
  <body>
      <?php include_once __DIR__ . '/includes/header.php'; ?>
    <!-- <video id="video" style="display: none;" src="./img/onload.mp4"></video> -->
    <!-- Character -->
    <img id="character" src="./img/default.png" alt="Character" />

  <header>
       <!-- Include common header with session management -->
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

    <div class="page-wrapper">
      <h1 class="form-header">Diary</h1>
      <!-- a diary form, with date input, title input, and content text area -->
      <form id="diary-form">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required />
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required />
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        <button type="submit">Submit</button>
      </form>
    </div>

    <div id="balloon-container"></div>

    <footer>&copy; 2025 Fluffy Planet</footer>

    <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/diary.js"></script>
    <script src="./js/character.js"></script>
  </body>
</html>
