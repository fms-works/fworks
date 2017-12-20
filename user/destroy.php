<?php
session_start();

require_once '../common.php';

// user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['user_id'])) {
  header('Location: user/login.php');
  exit();
}

$user_id = $_SESSION['user_id'];

// ユーザー情報の削除
$pdo->query("
  DELETE FROM users
  WHERE id=$user_id
");

session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>profile</title>
</head>
<body>
  <header>
    <a href="../index.php">メインページ</a>
  </header>

  <div class="container">
    ユーザー情報を削除しました
  </div>

  <footer></footer>
</body>
</html>
