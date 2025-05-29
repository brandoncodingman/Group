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
    <link rel="stylesheet" href="./css/music.css">
  </head>
  <body>
  <img id="character" src="./img/default.png" alt="Character" />

  <header>
      <h1>Fluffy Planets</h1>
        <button id="music-toggle" class="music-btn">🔇 Music Off</button>
  </header>

  <nav id="nav">
    <ul>
      <li><a href="./index.html">Home</a></li>
      <li><a href="./diary.php">Diary</a></li>
      <li><a href="./character.php">Character</a></li>
      <li><a href="./shop.php">Shop</a></li>
      <li><a href="./cart.php">Cart</a></li>
    </ul>
  </nav>

  <div class="hamburger">
    <span class="bar"></span>
    <span class="bar"></span>
    <span class="bar"></span>
  </div>

  <!-- Wrap your page content -->
  <div class="page-wrapper">
    <section class="shop">
    <h2 id="shop-header">Fluffy Items for Sale</h2>
    <div class="products">
      <div class="product">
        <h3>Fluffy Bear</h3>
        <p>$10</p>
        <button onclick="addToCart('Fluffy Bear', 10)">Add to Cart</button>
      </div>
      <div class="product">
        <h3>Cosmic Hamster</h3>
        <p>$15</p>
        <button onclick="addToCart('Cosmic Hamster', 15)">Add to Cart</button>
      </div>
      <div class="product">
        <h3>Alien Cat</h3>
        <p>$20</p>
        <button onclick="addToCart('Alien Cat', 20)">Add to Cart</button>
      </div>
    </div>
  </section>

  <section class="cart">
    <h2>Shopping Cart</h2>
    <ul id="cart-items"></ul>
    <p><strong>Total: $<span id="total">0</span></strong></p>
    <button onclick="checkout()">Checkout</button>
  </section>
  </div>

  <footer>&copy; 2025 Fluffy Planet</footer>
    <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
<script src="./js/cart.js"></script>
    <script src="./js/character.js"></script>
</body>

</html>
