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
try {
  $sql = $pdo->prepare(
   "DELETE FROM users
    WHERE id=?"
  );
  $sql->execute(array($current_user_id));
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();;
  exit();
}

try {
  $sql = $pdo->prepare(
   "DELETE FROM works
    WHERE user_id=?"
  );
  $sql->execute(array($current_user_id));
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

session_destroy();
?>
<?php include('../partial/top_layout.php'); ?>
<div class="container">
  ユーザー情報を削除しました
</div>
<?php include('../partial/bottom_layout.php'); ?>
