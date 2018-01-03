<?php
session_start();
require_once("../../common.php");

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];

$work_id = !empty($_POST['work_id']) ? h($_POST['work_id']) : null;

if (empty($work_id)) {
  echo "like failed";
  exit();
}

$date = date("Y-m-d H:i:s");

// TODO: user_idとwork_idの組が被っていないか確認する
try {
  $sql = $pdo->prepare(
   "INSERT INTO likes
      (user_id, work_id, created_at)
    VALUES
      (?, ?, ?)"
  );
  $sql->execute(array($current_user_id, $work_id, $date));
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// レスポンス
echo json_encode('like success');
header("Content-type: application/json; charset=UTF-8");
exit();
?>
