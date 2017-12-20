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
</body>
</html>
