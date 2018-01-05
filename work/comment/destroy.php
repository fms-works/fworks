<?php
session_start();
require_once("../../common.php");

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];

$comment_id = !empty($_POST["comment_id"]) ? h($_POST['comment_id']) : null;

if(empty($comment_id) || empty($current_user_id)){
  echo "failed, some values are empty.";
  exit();
}

// コメントが自分の投稿したものかどうかチェックする
try {
  $sql = $pdo->prepare(
   "SELECT * FROM comments
    WHERE id=?"
  );
  $sql->execute(array($comment_id));
  $comment = $sql->fetch();
  if (empty($comment) || $comment['user_id'] !== $current_user_id) {
    echo "failed, invalid values.";
    exit();
  }
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// comments削除
try {
  $sql = $pdo->prepare(
   "DELETE FROM comments
    WHERE id=?"
  );
  $sql->execute(array($comment_id));
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// レスポンス
echo json_encode('destroy success');
header("Content-type: application/json; charset=UTF-8");
exit();
?>
