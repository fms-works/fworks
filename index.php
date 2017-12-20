<?php
session_start();

require_once 'common.php';

// user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['user_id'])) {
  header('Location: user/login.php');
  exit();
}

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
  <link href="assets/css/style.css" rel="stylesheet">
  <title>nkmr</title>
</head>
<body>
  <header>
    <a href="">メインページ</a>
    <?php if (!empty($_SESSION['user_id'])) { ?>
      <a href="user/logout.php">ログアウトする</a>
    <?php } ?>
    <a href="user/profile.php">プロフィール</a>
  </header>

  <div class="container">
    <a href="work/new.php">投稿する</a>
  </div>

  <footer></footer>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <!-- bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <script src="assets/js/application.js"></script>
</body>
</html>
