<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Player Select</title>
    <link
      href="https://fonts.googleapis.com/css?family=Merriweather:400,700"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Bangers&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/character.css" />
     <link rel="stylesheet" href="./css/music.css" />
    <script src="./js/app.js" defer></script>
    <script src="./js/hamburger.js" defer></script>
    <script src="./js/character.js" defer></script>
    <script src="./js/music.js" defer></script>
  </head>
  <body>
    <!-- <video id="video" style="display: none;" src="./img/onload.mp4"></video> -->

    <!-- Character -->
    <img id="character" src="./img/earth-nobg.png" alt="Character" />

    <header>
      <h1>Fluffy Planets</h1>
        <button id="music-toggle" class="music-btn">🔇 Music Off</button>
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

    <!-- Close div #media-container -->

    <div class="container">
      <img
        class="logo"
        src="https://www.x-legend.com/fluffyplanetsaga/images/nav_logo.webp"
        alt="Logo"
      />

      <div class="stardust-counter">
        <div class="stars"></div>
        <div class="points">
          <p class="point-label">Stardust</p>
          <p class="point-value">0</p>
        </div>
        <div class="stars"></div>
      </div>

      <h1 class="title">Character Select</h1>
 <!-- purchase button -->
  <div class="button-container">
    <button id="purchase-button">Buy</button>
</div>
      <div class="select-container">
        <!-- Characters here from js -->
      </div>
    </div>

<div class="table-container">
  <table>
    <thead>
      <tr>
        <th>Character</th>
        <th>Facts</th>
      </tr>
    </thead>
    <tbody>
      <!-- JS facts here -->
    </tbody>
  </table>
</div>

    <footer>&copy; 2025 Fluffy Planet</footer>
  </body>
</html>