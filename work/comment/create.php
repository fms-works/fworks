<?php
session_start();
require_once("../../common.php");

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);

$content = !empty($_POST["content"]) ? h($_POST["content"]) : null;
$work_id = !empty($_POST["work_id"]) ? h($_POST['work_id']) : null;

if(empty($content) || empty($work_id) || empty($current_user_id)){
  echo "failed, some GET values are empty.";
  exit();
}

$date = date("Y-m-d H:i:s");

// commentsにINSERTする
try {
  $sql = $pdo->prepare(
   "INSERT INTO comments
      (content, user_id, work_id, created_at)
    VALUES
      (?, ?, ?, ?)"
  );
  $sql->execute(
    array($content, $current_user_id, $work_id, $date)
  );
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// レスポンス
echo json_encode(array(
  'user_id' => $current_user_id,
  'user_avatar' => $user_data['avatar'],
  'username' => $user_data['name'],
  'content' => $content
));
header("Content-type: application/json; charset=UTF-8");
exit();
?>
