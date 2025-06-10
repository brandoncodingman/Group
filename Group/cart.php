<?php
session_start(); 

require_once "./core/DbManager.php";
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
  <title>Fluffy Planet</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Bangers&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="./css/app.css" />
  <link rel="stylesheet" href="./css/cart.css" />
  <script src="./js/music.js" defer></script>
  <link rel="stylesheet" href="./css/music.css">
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

  <!-- Only show error messages, success is handled by JavaScript -->
  <?php if ($errorMessage): ?>
  <div style="background: #f9f9f9; padding: 15px; margin: 10px; border-radius: 5px; border-left: 4px solid #f44336;">
    <div style="color: #f44336; font-weight: bold;">
      ✗ <?php echo htmlspecialchars($errorMessage); ?>
    </div>
  </div>
  <?php endif; ?>
  
  <?php if ($successMessage): ?>
  <script>
    // Clear cart after successful purchase and show success message
    document.addEventListener('DOMContentLoaded', function() {
      if (window.cartFunctions && window.cartFunctions.clearCartAfterPurchase) {
        window.cartFunctions.clearCartAfterPurchase();
      }
      alert('<?php echo addslashes($successMessage); ?>');
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
          <button onclick="addToCart('Cosmic Hamster', 15)">Add to Cart</button>
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
      <p><strong>Total: ￥<span id="total">0</span></strong></p>
      <input type="submit" value="Checkout" id="checkout-btn">
    </form>
  </div>

  <footer>&copy; 2025 Fluffy Planets <br><span class="iip">Created with ❤️ by Miyazaki, Matsura, Brandon.</span></footer>
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