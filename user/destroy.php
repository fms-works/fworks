<?php
session_start();

require_once('../common.php');

$path = '../';
$title = 'ユーザー削除';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: login.php');
  exit();
}

$current_user_id = $_SESSION['current_user_id'];

// ユーザー情報の削除
$pdo->query("
  DELETE FROM users
  WHERE id=$current_user_id
");

session_destroy();
?>
<?php include('../partial/top_layout.php'); ?>
<div class="container">
  ユーザー情報を削除しました
</div>
<?php include('../partial/bottom_layout.php'); ?>
