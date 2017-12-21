<?php
session_start();

require_once '../common.php';

// user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['user_id'])) {
  header('Location: user/login.php');
  exit();
}

$user_id = $_SESSION['user_id'];
// 現在のユーザーを取得
$user = $pdo->query("
  SELECT name, profile, github_account, avatar
  FROM users
  WHERE id=$user_id
")->fetchAll()[0];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/template.min.css">
  <link href="../assets/css/style.css" rel="stylesheet">
  <title>edit</title>
</head>
<body>
  <header>
    <a href="../index.php">メインページ</a>
    <?php if (!empty($_SESSION['user_id'])) { ?>
      <a href="logout.php">ログアウトする</a>
    <?php } ?>
  </header>

  <div class="container">
    <?php // ユーザー情報編集フォーム ?>
    <form action="profile.php" method="post">
      <input type="file" name="avatar" value="<?php echo $user['avatar']; ?>">
      <input type="text" name="name" value="<?php echo $user['name']; ?>">
      <input type="text" name="github_account" value="<?php echo $user['github_account']; ?>">
      <textarea name="profile" rows="" cols="">
        <?php echo $user['profile']; ?>
      </textarea>
      <a href="profile.php">キャンセル</a>
      <input type="submit" value="変更する">
    </form>
  </div>

  <footer></footer>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <!-- bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../assets/js/template.min.js"></script>
  <script src="../assets/js/application.js"></script>
</body>
</html>
