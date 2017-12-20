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
  </div>

  <footer></footer>
</body>
</html>
