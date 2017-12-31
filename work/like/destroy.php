<?php
session_start();
require_once("../../common.php");

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];

$work_id = !empty($_POST['work_id']) ? h($_POST['work_id']) : null;

if (empty($work_id)) {
  echo "unlike failed";
  exit();
}

try {
  $sql = $pdo->prepare(
   "DELETE FROM likes
    WHERE user_id=? AND work_id=?"
  );
  $sql->execute(array($current_user_id, $work_id));
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// レスポンス
echo json_encode('unlike success');
header("Content-type: application/json; charset=UTF-8");
exit();
?>
