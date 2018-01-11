<?php
session_start();
require_once('common.php');

$title = 'ログイン';
$path = '';
?>
<?php include('partial/head.php'); ?>
<body>
  <?php include('partial/header.php'); ?>
  <?php // トップ ?>
  <div class="container-fluid lp-top">
    <h1 class="py-5 lp-title">FWorks</h1>
    <p class="px-1 text-white">FWorksはFMSの学生のための作品公開サービスです。</p>
    <p class="px-1 text-white">自分の作品を見てもらい、みんなで創作意欲を高めていきましょう！</p>
    <div class="pt-5 d-flex justify-content-md-center row mx-0">
      <a href="index.php" class="col-sm-12 col-md-5 text-md-right d-block my-2 mr-md-2">
        <button type="button" class="btn btn-secondary btn-raised">
          ログインしないで作品を見る
        </button>
      </a>
      <a href="user/login_request.php" class="col-sm-12 col-md-5 text-md-left d-block my-2 ml-md-1">
        <button type="button" class="btn btn-info btn-raised">
          Twitterで新規登録/ログイン
        </button>
      </a>
    </div>
  </div>
  <div class="lp-odd py-5 d-flex justify-content-md-center">
    <div class="py-2 px-2">
      <h2 class="pb-3 text-weight-bold text-white">
        FWorksは、<br>
        FMSの学生のための作品共有SNSです
      </h2>
      <p class="py-3 text-dark">
        先輩や後輩の作品が見たい…<br>
        せっかくだから自分の作品も見て欲しい…<br>
        そんなFMSの学生の悩みを解決します！
      </p>
    </div>
    <div class="py-2 px-2">
      <img src="assets/images/home.jpg" class="lp-img rounded">
    </div>
  </div>
  <div class="lp-even py-5 d-flex justify-content-md-center">
    <div class="py-2 px-2">
      <?php // TODO: Twitterアイコンに差し替え ?>
      <img src="assets/images/login.png" class="lp-img rounded">
    </div>
    <div class="py-2 px-2">
      <h2 class="pb-3 text-weight-bold text-dark">登録は簡単！</h2>
    　<p class="py-3 text-dark">
        Twitterアカウントを使って登録。<br>
        メールアドレスとか面倒な登録は不要です！
        <br>
        <br>
        ※ログインしなくても作品を見ることはできますが、<br>
        投稿やコメント、いいねはできません。
      </p>
    </div>
  </div>
  <div class="lp-odd py-5 d-flex justify-content-md-center">
    <div class="py-2 px-2">
      <h2 class="pb-3 text-weight-bold text-white">投稿してみよう！</h2>
      <p class="py-3 text-dark">
        タイトルとメイン画像、詳細だけで投稿することができます。<br>
        タグを追加することができ、あとでタグから検索することができます！
        <br>
        <br>
        OpenProcessingやYouTubeのリンクを指定しておくと、<br>
        詳細ページで実際に動作を診てもらうことができます！
        <br>
        <br>
        <br>
        ※画像は4枚まで、タグは3つまで指定可能（今後増やしていく予定です！）<br>
        ※リンクはGithub,OpenProcessing,YouTubeに対応
      </p>
    </div>
    <div class="py-2 px-2">
      <img src="assets/images/form.png" class="d-block my-1 lp-img rounded">
      <img src="assets/images/link.png" class="d-block my-1 lp-img rounded">
    </div>
  </div>
  <div class="lp-even py-5 d-flex justify-content-md-center">
    <div class="py-2 px-2">
      <img src="assets/images/timeline.png" class="d-block my-1 lp-img rounded">
      <img src="assets/images/mypage.png" class="d-block my-1 lp-img rounded">
    </div>
    <div class="py-2 px-2">
      <h2 class="pb-3 text-weight-bold text-dark">投稿した作品は…</h2>
      <p class="py-3 text-dark">
        投稿した作品はタイムラインやマイページから見てもらうことができます。<br>
        いつでも編集・削除できるので、気軽に投稿してみましょう！<br>
        <br>
        投稿した作品はマイページにたまっていくので、<br>
        どんどん作ってどんどん公開しましょう！
      </p>
    </div>
  </div>
  <div class="lp-odd py-5 d-flex justify-content-md-center">
    <h1 class="text-white">便利な機能紹介</h1>
  </div>
  <div class="lp-odd py-5 d-flex justify-content-md-center">
    <div class="py-2 px-2">
      <h2 class="pb-3 text-weight-bold text-white">① タグ検索</h2>
      <p class="py-3 text-dark">
        投稿された作品はタグから検索することができます。<br>
        過去の先輩の作品はここから探しましょう！
      </p>
    </div>
    <div class="py-2 px-2">
      <img src="assets/images/tag.png" class="lp-img rounded">
    </div>
  </div>
  <div class="lp-odd py-5 d-flex justify-content-md-center">
    <div class="py-2 px-2">
      <img src="assets/images/like.png" class="lp-img rounded">
    </div>
    <div class="py-2 px-2">
      <h2 class="pb-3 text-weight-bold text-white">② いいね</h2>
      <p>
        気に入った作品にはいいね！しましょう<br>
        いいねされた数が多いと人気の投稿としてトップに表示されます。<br>
        <br>
        いいねした作品は、あとからまとめて見ることもできます。
      </p>
    </div>
  </div>
  <div class="lp-odd py-5 d-flex justify-content-md-center">
    <div class="py-2 px-2">
      <h2 class="pb-3 text-weight-bold text-white">③ コメント</h2>
      <p>
        作品にはコメントすることができます。<br>
        気になった作品にはどんどん質問や意見をコメントしましょう！
      </p>
    </div>
    <div class="py-2 px-2">
      <img src="assets/images/comment.png" class="lp-img rounded">
    </div>
  </div>
  <div class="container-fluid bg-light text-center">
    <p class="pt-5 pb-3 px-1 text-center text-dark">さっそくFWorksを使ってみましょう！</p>
    <div class="pb-5 d-flex justify-content-md-center row">
      <a href="index.php" class="col-sm-12 col-md-5 text-md-right d-block my-2 mr-md-2">
        <button type="button" class="btn btn-secondary btn-raised">
          ログインしないで作品を見る
        </button>
      </a>
      <a href="user/login_request.php" class="col-sm-12 col-md-5 text-md-left d-block my-2 ml-md-1">
        <button type="button" class="btn btn-info btn-raised">
          Twitterで新規登録/ログイン
        </button>
      </a>
    </div>
  </div>
  <?php include('partial/footer.php'); ?>
  <?php include('partial/script.php'); ?>
</body>
</html>
