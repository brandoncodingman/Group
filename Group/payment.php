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
    <link rel="stylesheet" href="./css/payment.css">
    <script src="./js/music.js" defer></script>
  </head>
  <body>
    
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

  <div class="container">
    <h2>Checkout</h2>
    <form action="fake_payment_message.php" method="POST">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required>

      <label for="card">Card Number</label>
      <input type="text" id="card" name="card" placeholder="1234 5678 9012 3456" required>

      <label for="expiry">Expiry Date</label>
      <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>

      <label for="cvv">CVV</label>
      <input type="text" id="cvv" name="cvv" placeholder="3-digit code" required>

      <label for="shipping">Shipping Method</label>
      <select id="shipping" name="shipping" required>
        <option value="standard">Standard (3–5 days) – ¥500</option>
        <option value="express">Express (1–2 days) – ¥1000</option>
        <option value="pickup">In-store Pickup – Free</option>
      </select>

      <button class="btn" type="submit">Complete Purchase</button>
      <div class="note">* This is a demo form. No real payment will be processed.</div>
    </form>
  </div>


 <footer>&copy; 2025 Fluffy Planets <br><span class="iip">Created with ❤️ by Miyazaki, Matsura, Brandon.</span></footer>
    <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/balloon.js"></script>
    <script src="./js/firstview.js"></script>
     <script src="./js/global-character-loader.js"></script>
  </body>
</html>
