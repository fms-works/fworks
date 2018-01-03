<?php
session_start();
require_once('../common.php');

$path = '../';
$title = '作品投稿';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ' . $path . 'user/login.php');
  exit();
}

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);
?>
<?php include('../partial/top_layout.php'); ?>
<?php // TODO: 投稿のカラム増やす ?>
<h1 class="py-3 my-4 page-title">作品を投稿する</h1>
<form method="post" action="create.php" enctype="multipart/form-data">
  <?php include('./_work-form.php'); ?>
  <input type="submit" class="btn btn-primary px-4 mb-5" value="投稿する">
</form>
<?php include('../partial/bottom_layout.php'); ?>
