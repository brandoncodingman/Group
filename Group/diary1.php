<?php
require_once __DIR__ . '/core/Session.php';
require_once __DIR__ . '/core/DbManager.php';

// Make sure user is logged in or redirect
Session::requireLoginForAllPages();

$loginStatus = Session::getLoginStatus();

$userId = Session::getUserId();

$db = new DbManager();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT date, title, content FROM diary WHERE user_id = :user_id ORDER BY date DESC");
$stmt->execute([':user_id' => $userId]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <script src="./js/diary.js" defer></script>
  </head>
  <body>
      <?php include_once __DIR__ . '/includes/header.php'; ?>

    <img id="character" src="./img/default.png" alt="Character" />

    <header>
      <?php include_once __DIR__ . '/includes/Header.php'; ?>

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
      <form id="diary-form" action="./actions/Diary_Saves.php" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required />
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        <button type="submit">Submit</button>
      </form>
    </div>

    <div id="balloon-container">
      <?php if (!empty($entries)): ?>
        <?php foreach ($entries as $entry): ?>
          <div class="balloon" style="background-color: <?php echo '#' . substr(md5($entry['title']), 0, 6); ?>; border: black solid 10px; border-radius: 40% 30% 50% 40% / 50% 60% 30% 40%;">
            <div class="balloon-date"><strong><?php echo htmlspecialchars(date('l, F j, Y', strtotime($entry['date']))); ?></strong></div>
            <div class="balloon-title"><em><?php echo htmlspecialchars($entry['title']); ?></em></div>
            <p class="balloon-text"><?php echo nl2br(htmlspecialchars($entry['content'])); ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No diary entries yet. Write your first one above!</p>
      <?php endif; ?>
    </div>

 <div class="footer-container">
   <footer>&copy; 2025 Fluffy Planets <br><span class="iip">Created with ❤️ by Miyazaki, Matsura, Brandon.</span></footer>
 </div>
    <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/diary.js"></script>
    <script src="./js/character.js"></script>
      <script src="./js/global-character-loader.js"></script>
  </body>
</html>
