<?php
session_start();

require_once('../common.php');

$path = '../';
$title = 'ユーザー編集';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: login.php');
  exit();
}

$current_user_id = $_SESSION['current_user_id'];
// 現在のユーザーを取得
$user = $pdo->query("
  SELECT name, profile, github_account, avatar
  FROM users
  WHERE id=$current_user_id
")->fetchAll()[0];
?>
<?php include('../partial/top_layout.php'); ?>
<div class="container">
  <?php // ユーザー情報編集フォーム ?>
  <form action="update.php" method="post">
    <input type="file" name="avatar" value="<?php echo $user['avatar']; ?>">
    <input type="text" name="name" value="<?php echo $user['name']; ?>">
    <input type="text" name="github_account" value="<?php echo $user['github_account']; ?>">
    <textarea name="profile" rows="" cols="">
      <?php echo $user['profile']; ?>
    </textarea>
    <a href="show.php">キャンセル</a>
    <input type="submit" value="変更する">
  </form>
</div>
<?php include('../partial/bottom_layout.php'); ?>
