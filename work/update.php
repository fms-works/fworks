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

// 更新する作品のIDを取得
$work_id = h($_POST['work_id']);

// 空ならリダイレクト
if (empty($work_id)) {
  header('Location: ../index.php');
  exit();
}

// 作品を取得
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

// バリデーション
if(empty($_POST['title']) || empty($_POST['detail'])) {
  header('Location: new.php');
  exit();
}

// データを取得
$new_title = h($_POST['title']);

$images = [];
function getImage($image_file) {
  return file_get_contents($image_file['tmp_name']);
}
array_push($images, getImage($_FILES['main_image']));
if (!empty($_FILES['sub_image1']['tmp_name'])) {
  array_push($images, getImage($_FILES['sub_image1']));
}
if (!empty($_FILES['sub_image2']['tmp_name'])) {
  array_push($images, getImage($_FILES['sub_image2']));
}
if (!empty($_FILES['sub_image3']['tmp_name'])) {
  array_push($images, getImage($_FILES['sub_image3']));
}
$new_link   = !empty($_POST['link'])   ? h($_POST['link'])   : '';
$new_detail = !empty($_POST['detail']) ? h($_POST['detail']) : '';

$date = date("Y-m-d H:i:s");

// work更新
try {
  $sql = $pdo->prepare(
   "UPDATE works
    SET
      title=?,
      link=?,
      detail=?,
      updated_at=?
    WHERE id=?"
  );
  $sql->execute(
    array($new_title, $new_link, $new_detail, $date, $work_id)
  );
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// 既存のimageのID一覧を取得する
try {
  $sql = $pdo->prepare(
   "SELECT id FROM work_images
    WHERE work_id=?"
  );
  $sql->execute(array($work_id));
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// image更新
// TODO: image更新を実装する
// $index = 0;
// foreach($images as $image) {
//   try {
//     $sql = $pdo->prepare("
//       UPDATE work_images
//       SET
//         cotent=?
//       WHERE id=?
//     ");
//     // mainのimageはmainカラムを1にする
//     if($index === 0) {
//       $sql->execute(array($image,$work_id, 1, $date));
//     } else {
//       $sql->execute(array($image, $current_user_id, $work_id, 0, $date));
//     }
//   } catch (PDOException $e) {
//     echo $e;
//     exit();
//   }
//   $index++;
// }

header('Location: ../index.php');
exit();
?>
