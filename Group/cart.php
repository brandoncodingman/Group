<?php
require_once __DIR__ . '/core/Session.php';
require_once __DIR__ . '/core/DbManager.php';

Session::requireLoginForAllPages();

$loginStatus = Session::getLoginStatus();
$errorMessage = '';
$successMessage = '';

// REPLACE THIS ENTIRE SECTION WITH THE NEW CODE
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['items'])) {
    try {
        $dbManager = new DbManager();
        $conn = $dbManager->getConnection();
        
        // Get user ID from session
        $userId = Session::getUserId();
        
        if (!$userId) {
            throw new Exception('User not logged in');
        }
        
        // Prepare the insert statement for purchases
        $stmt = $conn->prepare("INSERT INTO user_purchases (product, price, amount, total, date, user_id) VALUES (?, ?, ?, ?, NOW(), ?)");
        
        $conn->beginTransaction();
        
        $grandTotal = 0;
        
        // Process each item in the cart and calculate grand total
        foreach ($_POST['items'] as $item) {
            $product = $item['item'];
            $price = (int)$item['item-price'];
            $amount = (int)$item['item-quantity'];
            $total = (int)$item['item-totalPrice'];
            
            // Add to grand total
            $grandTotal += $total;
            
            // Execute the insert for each item
            $stmt->execute([$product, $price, $amount, $total, $userId]);
        }
        
        // Update user points by adding the grand total (1 yen = 1 point)
        $updatePointsStmt = $conn->prepare("UPDATE user_info SET points = points + ? WHERE id = ?");
        $updatePointsStmt->execute([$grandTotal, $userId]);
        
        // Update session points to reflect the new total
        $getPointsStmt = $conn->prepare("SELECT points FROM user_info WHERE id = ?");
        $getPointsStmt->execute([$userId]);
        $newPointsTotal = $getPointsStmt->fetchColumn();
        
        // Update session with new points
        Session::updatePoints($newPointsTotal);
        
        $conn->commit();
        $successMessage = "ご購入ありがとうございます！注文が正常に処理され、{$grandTotal}ポイントが追加されました。";
        
    } catch (Exception $e) {
        if (isset($conn)) {
            $conn->rollBack();
        }
        $errorMessage = '注文の処理中にエラーが発生しました: ' . $e->getMessage();
    }
}
// END OF REPLACEMENT SECTION

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
    <link rel="stylesheet" href="./css/app.css" />
    <link rel="stylesheet" href="./css/cart.css" />
    <script src="./js/music.js" defer></script>
    <link rel="stylesheet" href="./css/music.css" />
  </head>

  <body>
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
        >
        <span class="points"
          >ポイント:
          <?php echo $loginStatus['points']; ?></span
        >
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

    <!-- Show error and success messages -->
    <?php if ($errorMessage): ?>
    <div
      style="
        background: #f9f9f9;
        padding: 15px;
        margin: 10px;
        border-radius: 5px;
        border-left: 4px solid #f44336;
      "
    >
      <div style="color: #f44336; font-weight: bold">
        ✗
        <?php echo htmlspecialchars($errorMessage); ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($successMessage): ?>
    <div
      style="
        background: #f9f9f9;
        padding: 15px;
        margin: 10px;
        border-radius: 5px;
        border-left: 4px solid #4caf50;
      "
    >
      <div style="color: #4caf50; font-weight: bold">
        ✓
        <?php echo htmlspecialchars($successMessage); ?>
      </div>
    </div>
    <script>
      // Clear cart after successful purchase
      document.addEventListener("DOMContentLoaded", function () {
        if (
          window.cartFunctions &&
          window.cartFunctions.clearCartAfterPurchase
        ) {
          window.cartFunctions.clearCartAfterPurchase();
        }
      });
    </script>
    <?php endif; ?>

    <!-- Wrap your page content -->
    <div class="page-wrapper">
      <section class="shop">
        <h2 id="shop-header">Fluffy Items for Sale</h2>
        <div class="products">
          <div class="product">
            <h3>Fluffy Bear</h3>
            <p>￥10</p>
            <button onclick="addToCart('Fluffy Bear', 10)">Add to Cart</button>
          </div>
          <div class="product">
            <h3>Cosmic Hamster</h3>
            <p>￥15</p>
            <button onclick="addToCart('Cosmic Hamster', 15)">
              Add to Cart
            </button>
          </div>
          <div class="product">
            <h3>Alien Cat</h3>
            <p>￥20</p>
            <button onclick="addToCart('Alien Cat', 20)">Add to Cart</button>
          </div>
        </div>
      </section>

      <form class="cart" action="" method="POST">
        <h2>Shopping Cart</h2>
        <div id="cart-items"></div>
        <p>
          <strong>Total: ￥<span id="total">0</span></strong>
        </p>

        <!-- Personal Info -->
        <label for="name">Full Name</label>
        <input
          type="text"
          id="name"
          name="name"
          placeholder="Smith John"
          required
        />

        <label for="email">Email Address</label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="Smith@gmail.com"
          required
        />

        <label for="card">Card Number</label>
        <input
          type="text"
          id="card"
          name="card"
          placeholder="1234 5678 9012 3456"
          required
        />

        <label for="expiry">Expiry Date</label>
        <input
          type="text"
          id="expiry"
          name="expiry"
          placeholder="MM/YY"
          required
        />

        <label for="cvv">CVV</label>
        <input
          type="text"
          id="cvv"
          name="cvv"
          placeholder="3-digit code"
          required
        />

        <!-- Shipping Info -->
        <label for="address">Shipping Address</label>
        <textarea
          id="address"
          name="address"
          placeholder="Enter your shipping address"
          rows="4"
          required
        ></textarea>
        <input type="submit" value="Checkout" id="checkout-btn" />
      </form>
    </div>

    <footer>
      &copy; 2025 Fluffy Planets <br /><span class="iip"
        >Created with ❤️ by Miyazaki, Matsura, Brandon.</span
      >
    </footer>
    <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/cart.js"></script>
    <script src="./js/character.js"></script>
    <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/balloon.js"></script>
    <script src="./js/firstview.js"></script>
    <script src="./js/global-character-loader.js"></script>
  </body>
</html>