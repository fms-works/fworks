<?php
session_start();

require_once '../common.php';

// user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['user_id'])) {
  header('Location: user/login.php');
  exit();
}

$user_id = $_SESSION['user_id'];

// フラッシュメッセージ用フラグ
$update_user_notice = false;

// 変更リクエストがあれば編集する
if (isset($_POST['name']) && isset($_POST['github_account']) &&
  isset($_POST['profile']) && isset($_POST['avatar'])) {
  $new_name           = h($_POST['name']);
  $new_github_account = h($_POST['github_account']);
  $new_profile        = h($_POST['profile']);
  $new_avatar         = h($_POST['avatar']);

  $sql = $pdo->prepare("
    UPDATE users
    SET
      name=?,
      github_account=?,
      profile=?,
      avatar=?
    WHERE id=$user_id
  ");
  $sql->execute(
    array($new_name, $new_github_account, $new_profile, $new_avatar)
  );
  $update_user_notice = true;
}

// 現在のユーザーを取得
$user = $pdo->query("
  SELECT name, github_account, profile, avatar
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
  <link href="../assets/css/style.css" rel="stylesheet">
  <title>profile</title>
</head>
<body>
  <?php if($update_user_notice === true) { ?>
    <p>更新しました</p>
  <?php } ?>

  <header>
    <a href="../index.php">メインページ</a>
    <?php if (!empty($_SESSION['user_id'])) { ?>
      <a href="logout.php">ログアウトする</a>
    <?php } ?>
  </header>

  <div class="container">
    <a href="edit.php">編集する</a>
    <image src="hoge.jpg"></image>
    <p><?php echo !empty($user['name']) ? $user['name'] : '登録されていません'; ?></p>
    <p><?php echo !empty($user['github_account']) ? $user['github_account'] : '登録されていません'; ?></p>
    <p><?php echo !empty($user['profile']) ? $user['profile'] : '登録されていません'; ?></p>
    <p><?php echo $user['avatar']; ?></p>
    <a href="destroy.php" onClick="return confirm('削除してもよろしいですか？');">
      削除する
    </a>
  </div>

  <footer></footer>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <!-- bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <script src="../assets/js/application.js"></script>
</body>
</html>
