<?php
session_start();

require_once '../common.php';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ../user/login.php');
  exit();
}

$current_user_id = $_SESSION['current_user_id'];

// バリデーション
$_SESSION['empty_title']      = false;
$_SESSION['empty_main_image'] = false;
$_SESSION['empty_detail']     = false;

if(empty($_POST['title']) || empty($_FILES['main_image']) || empty($_POST['detail'])) {
  if(empty($_POST['title']))       $_SESSION['empty_title'] = true;
  if(empty($_FILES['main_image'])) $_SESSION['empty_main_image'] = true;
  if(empty($_POST['detail']))      $_SESSION['empty_detail'] = true;

  header('Location: new.php');
  exit();
}

// データを取得
$new_title = h($_POST['title']);

$images = [];
function getImage($image_file) {
  return file_get_contents($image_file['tmp_name']);
}
// TODO: 画像を保存
array_push($images, 'image');
// array_push($images, getImage($_FILES['main_image']));
if (!empty($_FILES['sub_image1']['tmp_name'])) {
  // TODO: 画像を保存
  array_push($images, 'image1');
  // array_push($images, getImage($_FILES['sub_image1']));
}
if (!empty($_FILES['sub_image2']['tmp_name'])) {
  // TODO: 画像を保存
  array_push($images, 'image2');
  // array_push($images, getImage($_FILES['sub_image2']));
}
if (!empty($_FILES['sub_image3']['tmp_name'])) {
  // TODO: 画像を保存
  array_push($images, 'image3');
  // array_push($images, getImage($_FILES['sub_image3']));
}
$new_link   = !empty($_POST['link'])   ? h($_POST['link'])   : '';
$new_detail = !empty($_POST['detail']) ? h($_POST['detail']) : '';

$date = date("Y-m-d H:i:s");

// work保存
$sql = $pdo->prepare("
  INSERT INTO works(
    title, link, detail, user_id, created_at, updated_at
  ) VALUES (
    ?, ?, ?, ?, ?, ?
)");
$sql->execute(
  array($new_title, $new_link, $new_detail, $current_user_id, $date, $date)
);
$work_id = $pdo->lastInsertId('id');

// image保存
$index = 0;
foreach($images as $image) {
  $sql = $pdo->prepare("
    INSERT INTO work_images(
      content, user_id, work_id, main, created_at
    ) VALUES (
      ?, ?, ?, ?, ?
  )");
  // mainのimageはmainカラムを1にする
  if($index === 0) {
    $sql->execute(array($image, $current_user_id, $work_id, 1, $date));
  } else {
    $sql->execute(array($image, $current_user_id, $work_id, 0, $date));
  }
  $index++;
}

header('Location: ../index.php');
exit();
?>
