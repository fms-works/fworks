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
        LIMIT 1
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
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.0.0-beta.4/dist/css/bootstrap-material-design.min.css" integrity="sha384-R80DC0KVBO4GSTw+wZ5x2zn2pu4POSErBkf8/fSFhPXHxvHJydT0CSgAP2Yo2r4I" crossorigin="anonymous"> -->
  <!-- tamplate -->
  <link rel="stylesheet" href="assets/css/template.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <title>nkmr</title>
</head>
<body>
  <?php // ヘッダー ?>
  </nav>
  <nav class="navbar navbar-expand-lg justify-content-between">
    <a href="" class="navbar-brand">FMS Works Published Service</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="work/new.php">投稿する</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <!-- <?php // TODO: 自分のアバターを表示する ?>
            <div class="nav-avatar" style="background-image: url(assets/images/barbie.jpg)"></div> -->アバター
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="user/show.php">マイページ</a>
            <a class="dropdown-item" href="user/logout.php">ログアウト</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <?php // 左側に表示 ?>
  <header>
    <form class="form-inline">
      <input class="form-control mr-sm-2" type="search" aria-label="Search">
      <button type="submit" class="btn btn-info btn-lg my-sm-0">検索</button>
    </form>
    <ul>
      <li><a class="hidden-xs" href="index.html">トップ</a></li>
      <li><a class="hidden-xs" href="index.html">カテゴリ</a></li>
      <li><a class="hidden-xs" href="index.html">ソート</a></li>
      <li><a class="hidden-xs" href="index.html">使い方</a></li>
    </ul>
  </header>

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
          <img class="img-responsive" alt="" src="assets/images/img-04.jpg">
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

  <footer></footer>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <!-- bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" 。integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <!-- <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/bootstrap-material-design@4.0.0-beta.4/dist/js/bootstrap-material-design.js" integrity="sha384-3xciOSDAlaXneEmyOo0ME/2grfpqzhhTcM4cE32Ce9+8DW/04AGoTACzQpphYGYe" crossorigin="anonymous"></script> -->
  <!-- tamplate -->
  <script type="text/javascript" src="assets/js/template.min.js"></script>
  <script src="assets/js/application.js"></script>
</body>
</html>
