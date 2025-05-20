<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Move Character on Page</title>
    <link rel="stylesheet" href="./css/app.css" />
  </head>
  <body>
    <!-- Intro Images -->
    <img
      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgFX8zXXcNdccAIHVtA_C51bImLwJYIoSGkg&s"
      id="top-image"
      class="intro-image"
      alt="Top Cover"
    />
    <img
      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgFX8zXXcNdccAIHVtA_C51bImLwJYIoSGkg&s"
      id="bottom-image"
      class="intro-image"
      alt="Bottom Cover"
    />

    <!-- Character -->
    <img id="character" src="./img/kirbygon.png" alt="Character" />

    <!-- Page layout -->
    <header>
      <h1>My Fake Website</h1>
      <p>Just a simple layout with a moving character!</p>
    </header>

    <nav>
      <a href="#">Home</a>
      <a href="#">About</a>
      <a href="#">Blog</a>
      <a href="#">Contact</a>
    </nav>

    <div class="container">
      <div class="main-content fancy-box">
        <h2>Main Content Area</h2>
        <p>This is where your page content would go.</p>
        <p>
          The character image moves freely across the entire page using arrow
          keys.
        </p>
      </div>

      <div class="sidebar fancy-box">
        <h3>Sidebar</h3>
        <p>Links, ads, or additional info can go here.</p>
      </div>
    </div>

    <footer>&copy; 2025 My Fake Website | Built for fun!</footer>

    <script src="./js/app.js"></script>
  </body>
</html>
