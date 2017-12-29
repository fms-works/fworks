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

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);
?>
<?php include('../partial/top_layout.php'); ?>
<?php // ユーザー情報編集フォーム ?>
<form action="update.php" method="post">
  <input type="text" name="name" value="<?php echo $user_data['name']; ?>">
  <input type="text" name="github_account" value="<?php echo $user_data['github_account']; ?>">
  <textarea name="profile" rows="" cols="">
    <?php echo $user_data['profile']; ?>
  </textarea>
  <a href="show.php">キャンセル</a>
  <input type="submit" value="変更する">
</form>
<?php include('../partial/bottom_layout.php'); ?>
