<?php
session_start();

require_once 'common.php';

// user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['user_id'])) {
  header('Location: user/login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>nkmr</title>
</head>
<body>
  <header>
    <a href="../index.php">メインページ</a>
    <?php if (!empty($_SESSION['user_id'])) { ?>
      <a href="user/logout.php">ログアウトする</a>
    <?php } ?>
    <a href="user/profile.php">プロフィール</a>
  </header>

  <div class="container">
  </div>

  <footer></footer>
</body>
</html>
