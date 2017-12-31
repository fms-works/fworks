<?php
session_start();
require_once('../common.php');

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ../user/login.php');
  exit();
}

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];

// 削除する作品のIDを取得
$work_id = !empty($_GET['id']) ? h($_GET['id']) : 0;

// 空ならリダイレクト
if (empty($work_id)) {
  header('Location: ../index.php');
  exit();
}

// 自分の作品を取得
try {
  $sql = $pdo->prepare(
   "SELECT user_id FROM works
    WHERE id=?"
  );
  $sql->execute(array($work_id));
  $work = $sql->fetch();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// 指定されたIDの作品が存在しない or 指定された作品が自分のではない場合リダイレクトする
if (empty($work) || $work['user_id'] !== $current_user_id) {
  header('Location: ../index.php');
  exit();
}

// 作品の削除
try {
  $sql = $pdo->prepare(
   "DELETE FROM works
    WHERE id=?"
  );
  $sql->execute(array($work_id));
} catch (PDOExcdption $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

header('Location: ../index.php');
?>
