<?php
session_start();

require_once __DIR__ . '/core/DbManager.php';
require_once __DIR__ . '/core/Session.php';

Session::requireLoginForAllPages();

$loginStatus = Session::getLoginStatus();

$successMessage = '';
$errorMessage = '';

// POSTデータの処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['items']) && !empty($_POST['items'])) {
        try {
            $dbManager = new DbManager();
            $pdo = $dbManager->getConnection();
            $pdo->beginTransaction();

            // 現在の日付を取得
            $currentDate = date('Y-m-d');
            
            // ユーザーIDを適切に取得（セッションから取得することを推奨）
            $userId = $_SESSION['user_id'] ?? null;

            if (!$userId) {
                throw new Exception("ユーザーがログインしていません");
            }

            $insertCount = 0;
            foreach ($_POST['items'] as $index => $item) {
                // データの検証
                if (empty($item['item']) || !isset($item['item-price']) || !isset($item['item-quantity'])) {
                    throw new Exception("必要なデータが不足しています");
                }

                $stmt = $pdo->prepare("INSERT INTO user_purchases (product, price, amount, total, date, user_id) 
                                     VALUES (:product, :price, :amount, :total, :date, :user_id)");
                
                $insertData = [
                    ':product' => $item['item'],
                    ':price' => floatval($item['item-price']),
                    ':amount' => intval($item['item-quantity']),
                    ':total' => floatval($item['item-totalPrice']),
                    ':date' => $currentDate,
                    ':user_id' => $userId
                ];
                
                $result = $stmt->execute($insertData);
                
                if (!$result) {
                    throw new Exception("データベースへの挿入に失敗しました");
                }
                
                $insertCount++;
            }

            $pdo->commit();
            $successMessage = "購入情報を保存しました！($insertCount 件の商品)";

        } catch (PDOException $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $errorMessage = "データベースエラー: " . $e->getMessage();
            error_log($errorMessage);
        } catch (Exception $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $errorMessage = $e->getMessage();
            error_log($errorMessage);
        }
    } else {
        $errorMessage = "カートにアイテムがありません";
    }
}
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

  <!-- Show error or success messages -->
  <?php if ($errorMessage): ?>
  <div style="background: #f9f9f9; padding: 15px; margin: 10px; border-radius: 5px; border-left: 4px solid #f44336;">
    <div style="color: #f44336; font-weight: bold;">
      ✗ <?php echo htmlspecialchars($errorMessage); ?>
    </div>
  </div>
  <?php endif; ?>
  
  <?php if ($successMessage): ?>
  <div style="background: #f9f9f9; padding: 15px; margin: 10px; border-radius: 5px; border-left: 4px solid #4CAF50;">
    <div style="color: #4CAF50; font-weight: bold;">
      ✓ <?php echo htmlspecialchars($successMessage); ?>
    </div>
  </div>
  <script>
    // Clear cart after successful purchase
    document.addEventListener('DOMContentLoaded', function() {
      if (window.cartFunctions && window.cartFunctions.clearCartAfterPurchase) {
        window.cartFunctions.clearCartAfterPurchase();
      }
      // Redirect to cart or home page after a few seconds
      setTimeout(function() {
        window.location.href = 'cart.php';
      }, 3000);
    });
  </script>
  <?php endif; ?>

  <div class="container">
  <h2>Checkout</h2>
  <form action="" method="POST" class="cart">
    <!-- Personal Info -->
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

    <!-- Shipping Info -->
    <label for="address">Shipping Address</label>
    <textarea id="address" name="address" placeholder="Enter your shipping address" rows="4" required></textarea>

    <label for="shipping">Shipping Method</label>
    <select id="shipping" name="shipping" required>
      <option value="standard">Standard (3–5 days) – ¥500</option>
      <option value="express">Express (1–2 days) – ¥1000</option>
      <option value="pickup">In-store Pickup – Free</option>
    </select>

    <div>
      <h3>Order Summary</h3>
      <p>Subtotal: <span id="subtotal">¥0</span></p>
      <p>Shipping: <span id="shipping-cost">¥500</span></p>
      <p><strong>Total: ¥<span id="total-price">0</span></strong></p>
    </div>

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
      <script src="./js/cart.js"></script>
  </body>
</html>