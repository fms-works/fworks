<?php
session_start();
require_once('../common.php');

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: login.php');
  exit();
}

$current_user_id = $_SESSION['current_user_id'];

// データを更新
if (isset($_POST['name']) && isset($_POST['github_account']) &&
  isset($_POST['profile'])) {
  $new_name           = h($_POST['name']);
  $new_github_account = h($_POST['github_account']);
  $new_profile        = h($_POST['profile']);

  try {
    $sql = $pdo->prepare(
    "UPDATE users
      SET
        name=?,
        github_account=?,
        profile=?
      WHERE id=$current_user_id"
    );
    $sql->execute(
      array($new_name, $new_github_account, $new_profile)
    );
  } catch (PDOException $e) {
    echo 'MySQL connection failed: ' . $e->getMessage();
    exit();
  }
}
// TODO: 更新失敗時の処理

header('Location: show.php');
exit();
?>
