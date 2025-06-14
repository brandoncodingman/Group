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
    <link rel="stylesheet" href="./css/information.css" />
    <link rel="stylesheet" href="./css/indextable.css" />
    <link rel="stylesheet" href="./css/music.css" />
    <script src="./js/music.js" defer></script>
  </head>
  <body>
     <?php include_once __DIR__ . '../includes/Header.php'; ?>
    <!-- <video id="video" style="display: none;" src="./img/onload.mp4"></video> -->
    <!-- Character -->
    <img id="character" src="./img/default.png" alt="Character" />

    <!-- Page layout -->
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
    <main>
      <div class="president-container">
        <h1 class="section-heading">Fluffy Planets Staff</h1>
        <div class="image-container">
          <img
            id="president-image"
            src="./img/vicepresident.png"
            alt="president"
          />
        </div>
        <div class="information-container">
          <h2>👑 Fluffy Planets'全王様のご紹介</h2>
          <div>
            <h3>名前：</h3>
            <p>バルバロス一世・もふもふ皇帝陛下</p>

            <h3>役職：</h3>
            <p>
              ふわふわ惑星株式会社 絶対君主・CEO（Chief Emperor of
              Overfluffiness）
            </p>

            <h3>経歴：</h3>
            <p>
              バルバロス一世は、1000年に一度誕生するという伝説の超もふもふ系生命体。<br />
              幼少期より毛玉の支配力を発揮し、3歳で近所の犬を服従させ、5歳で自らの王国を建国。<br />
              社内では毎朝の「忠誠のもふもふチェック」を欠かさず、逆らった者は全員ぬいぐるみ型の牢獄へ。<br />
              社訓：「我に忠誠を、そして毛を整えよ。」
            </p>

            <h3>趣味：</h3>
            <ul>
              <li>王座で丸くなること（勤務時間中）</li>
              <li>部下のふわふわ具合の監視</li>
              <li>毛並みコンテストでの審査（常に優勝者）</li>
              <li>戦略的お昼寝（Nap of Domination™）</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- president end -->

      <!-- vice president start -->
      <div class="vice-container">
        <h1 class="section-heading">Fluffy Planets Staff</h1>
        <div class="image-container">
          <img id="vice-image" src="./img/fusion.jpg" alt="vice" />
        </div>
        <div class="information-container">
          <h2>🤴 Fluffy Planets' 副王のご紹介</h2>
          <div>
            <h3>名前：</h3>
            <p>サー・マクフラッフィー副王閣下</p>

            <h3>役職：</h3>
            <p>
              ふわふわ惑星株式会社 副王・VP（Vice Purveyor of Fluff and
              Operations）
            </p>

            <h3>経歴：</h3>
            <p>
              サー・マクフラッフィーは、もふもふ王国で厳しい訓練を受けた名家の出身。<br />
              若干2歳にして完璧な会議出席姿勢を身につけ、4歳で部門運営の極意を習得。<br />
              現在はCEOの右腕として、もふもふ秩序の維持と社内ふわふわ戦略を指揮中。<br />
              社是：「副王に忠誠を、会議には毛並みを整えて出席せよ。」
            </p>

            <h3>趣味：</h3>
            <ul>
              <li>ミーティング中の優雅な毛づくろい</li>
              <li>進行表の上でのくつろぎ</li>
              <li>部下への静かなるプレッシャー（圧）</li>
              <li>完璧な角度でのパワーナップ（Silent Domination™）</li>
            </ul>
          </div>
        </div>
      </div>

  <!-- employee start -->
<div class="employee-container">
  <h1 class="section-heading">Fluffy Planets Staff</h1>
  <div class="image-container">
    <img id="employee-image" src="./img/matsura.jfif" alt="employee" />
  </div>
  <div class="information-container">
    <h2>🧑🖥️ Fluffy Planets’ 唯一無二の社員のご紹介</h2>
    <div>
      <h3>名前：</h3>
      <p>Treeさん</p>

      <h3>役職：</h3>
      <p>ふわふわ惑星株式会社 唯一の社員・Official Fluff Wrangler（唯一の毛玉調教師）</p>

      <h3>経歴：</h3>
      <p>
        つい最近IIP金沢職業訓練校を卒業し、晴れてFluffy Planets唯一の新入社員に。<br />
        社長と副社長が日々お昼寝に専念する間、全ての仕事をChatGPTの力を借りつつこなすスーパー社員。<br />
        「社長も副社長も忙しいので、ぼくが全部やります！」を合言葉に奮闘中。<br />
        社訓：「社長と副社長のご機嫌取りは我が使命。あとはChatGPTが何とかしてくれる！」<br />
        最近の悩みは、AIに負けそうなこと。<br />
        ちなみに、まだIIP金沢時代からの伝説の遅いパソコンを愛用中。忍耐力が鍛えられます。  
      </p>

      <h3>趣味：</h3>
      <ul>
        <li>深夜にChatGPTと秘密会議</li>
        <li>社長の居眠り中にコーヒーでこっそりエネルギーチャージ</li>
        <li>「今日の毛玉指数」をAIに分析してもらう</li>
        <li>社員唯一ゆえの孤独感を、ふわふわ毛玉で癒す</li>
      </ul>
    </div>
  </div>
</div>
<!-- employee end -->




      <!-- company information start -->
      <div class="company-container">
        <h1 class="section-heading">Fluffy Planets Info</h1>
        <div class="image-container">
          <img id="company-image" src="./img/logo.jfif" alt="Fluffy Planets" />
        </div>
        <div class="information-container">
          <h2>🌍 Fluffy Planets（ふわふわ惑星）について</h2>
          <div>
            <h3>会社名：</h3>
            <p>Fluffy Planets（ふわふわ惑星株式会社）</p>

            <h3>なにしてるの？：</h3>
            <p>
              わたしたちは、子どもたちの想像力をくすぐる<br />
              もふもふでキュートな商品やアプリをお届けしています！<br />
              Tシャツやマグカップなどのグッズ販売に加え、<br />
              あなたの毎日をもっと楽しくする「ふわふわ日記アプリ」も運営中♪
            </p>

            <h3>フワキャラ（Chibi Planet）とは？：</h3>
            <p>
              ポイントを集めて、かわいい「ちび惑星キャラクター」をゲット！<br />
              コレクションして、自分だけの銀河を作っちゃおう☆彡
            </p>

            <h3>ターゲット：</h3>
            <p>
              5歳〜12歳くらいの好奇心いっぱいなキッズたち！（と、心がふわふわな大人も歓迎）
            </p>

            <h3>スローガン：</h3>
            <p>「毎日に、ちょっとした宇宙の魔法を ✨」</p>

            <h3>主なサービス：</h3>
            <ul>
              <li>もふもふ惑星Tシャツ・マグカップ販売</li>
              <li>日記が書けるふわふわアプリ</li>
              <li>ポイントで集めるちびキャラたち</li>
              <li>季節イベントやギャラクシー大冒険キャンペーン</li>
            </ul>
          </div>
        </div>
      </div>
      
    </main>

    <div class="footer-container">
 <footer>&copy; 2025 Fluffy Planets <br><span class="iip">Created with ❤️ by Miyazaki, Matsura, Brandon.</span></footer>
    </div>

 <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/balloon.js"></script>
    <script src="./js/firstview.js"></script>
          <script src="./js/app.js"></script>
    <script src="./js/hamburger.js"></script>
    <script src="./js/balloon.js"></script>
    <script src="./js/firstview.js"></script>
     <script src="./js/global-character-loader.js"></script>
  </body>
</html>
