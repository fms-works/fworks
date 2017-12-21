<?php
session_start();

require_once 'common.php';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: user/login.php');
  exit();
}

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];

// work一覧を取得
try {
  $works = $pdo->query("
    SELECT
      works.id,
      works.title,
      users.id     AS user_id,
      users.name   AS user_name,
      users.avatar AS user_avatar,
      (
        SELECT content FROM work_images
        WHERE work_images.work_id=works.id AND work_images.main=1
      ) AS first_work_image,
      (
        SELECT count(*) FROM likes
        WHERE likes.work_id=works.id
      ) AS likes_count
    FROM
      works
      LEFT OUTER JOIN users ON works.user_id=users.id
    ORDER BY works.created_at
  ")->fetchAll();
} catch (PDOException $e) {
  echo $e;
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <!-- tamplate -->
  <link rel="stylesheet" href="assets/css/template.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <title>nkmr</title>
</head>
<body>
  <header>
    <a href="">メインページ</a>
    <?php if (!empty($_SESSION['current_user_id'])) { ?>
      <a href="user/logout.php">ログアウトする</a>
    <?php } ?>
    <a href="user/profile.php?id=<?php echo $current_user_id; ?>">プロフィール</a>

    <div class="title">
      <h1>FMS Works Published Service</h1>
      <p>FMSの学生のための作品公開用SNSです。</p>
      <p>自分の作品を見てもらい、みんなで創作意欲を上げていきましょう！</p>
    </div>

    <div class="header-right">
      <ul>
        <li>
          <div class="dropdown">
            <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="assets/images/barbie.jpg" class="img-circle" height="35" width="35">
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <button class="dropdown-item" type="button">投稿する</button>
              <button class="dropdown-item" type="button">マイページ</button>
              <button class="dropdown-item" type="button">ログアウト</button>
            </div>
        　</div>
        </li>
        <li>
          <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" aria-label="Search">
            <button type="submit" class="btn btn-info btn-lg  my-sm-0">検索</button>
          </form>
        </li>
       </ul>
     </div>
  </header>

  <nav>
    <div class="header-left">
      <ul>
        <li><a class="hidden-xs" href="index.html">トップ</a></li>
        <li><a class="hidden-xs" href="index.html">カテゴリ</a></li>
        <li><a class="hidden-xs" href="index.html">ソート</a></li>
        <li><a class="hidden-xs" href="index.html">使い方</a></li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid">
    <a href="work/new.php">投稿する</a>
    <main class="" id="main-collapse">
      <div class="hero-full-wrapper">
        <div class="grid">
          <div class="gutter-sizer"></div>
          <div class="grid-sizer"></div>

          <?php // 作品一覧を表示 ?>
          <div class="grid-item">
            <img class="img-responsive" alt="" src="assets/images/img-12.jpg">
            <a href="./project.html" class="project-description">
              <div class="project-text-holder">
                <div class="project-text-inner">
                  <h3>Vivamus vestibulum</h3>
                  <p>Discover more</p>
                </div>
              </div>
            </a>
          </div>

          <div class="grid-item">
            <img class="img-responsive" alt="" src="assets//images/img-05.jpg">
            <a href="./project.html" class="project-description">
              <div class="project-text-holder">
                <div class="project-text-inner">
                  <h3>Vivamus vestibulum</h3>
                  <p>Discover more</p>
                </div>
              </div>
            </a>
          </div>

          <div class="grid-item">
            <img class="img-responsive" alt="" src="assets/images/img-13.jpg">
            <a href="./project.html" class="project-description">
              <div class="project-text-holder">
                <div class="project-text-inner">
                  <h3>Vivamus vestibulum</h3>
                  <p>Discover more</p>
                </div>
              </div>
            </a>
          </div>

          <div class="grid-item">
            <img class="img-responsive" alt="" src="./images/img-04.jpg">
            <a href="./project.html" class="project-description">
              <div class="project-text-holder">
                <div class="project-text-inner">
                  <h3>Vivamus vestibulum</h3>
                  <p>Discover more</p>
                </div>
              </div>
            </a>
          </div>

          <div class="grid-item">
            <img class="img-responsive" alt="" src="assets//images/img-07.jpg">
            <a href="./project.html" class="project-description">
              <div class="project-text-holder">
                <div class="project-text-inner">
                  <h3>Vivamus vestibulum</h3>
                  <p>Discover more</p>
                </div>
              </div>
            </a>
          </div>

          <div class="grid-item">
            <img class="img-responsive" alt="" src="assets/images/img-11.jpg">
            <a href="./project.html" class="project-description">
              <div class="project-text-holder">
                <div class="project-text-inner">
                  <h3>Vivamus vestibulum</h3>
                  <p>Discover more</p>
                </div>
              </div>
            </a>
          </div>

          <div class="grid-item">
            <img class="img-responsive" alt="" src="assets/images/img-10.jpg">
            <a href="./project.html" class="project-description">
              <div class="project-text-holder">
                <div class="project-text-inner">
                  <h3>Vivamus vestibulum</h3>
                  <p>Discover more</p>
                </div>
              </div>
            </a>
          </div>

          <div class="grid-item">
            <img class="img-responsive" alt="" src="assets/images/img-03.jpg">
            <a href="./project.html" class="project-description">
              <div class="project-text-holder">
                <div class="project-text-inner">
                  <h3>Vivamus vestibulum</h3>
                  <p>Discover more</p>
                </div>
              </div>
            </a>
          </div>
        </div><!-- grid -->
      </div><!-- hero-full-wrapper -->
    </main>
  </div><!-- container -->

  <footer></footer>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <!-- bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <!-- tamplate -->
  <script type="text/javascript" src="assets/js/template.min.js"></script>
  <script src="assets/js/application.js"></script>
</body>
</html>
