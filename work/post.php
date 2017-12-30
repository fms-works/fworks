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
  return base64_encode(file_get_contents($image_file['tmp_name']));
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
$values_sql = '';
for ($i = 0; $i < count($images); $i++) {
  if ($i !== 0) $values_sql .= ",";
  $values_sql .= "(?, ?, ?, ?, ?)";
}

$sql = $pdo->prepare("
  INSERT INTO work_images(
    content, user_id, work_id, main, created_at
  ) VALUES " . $values_sql);

$insert_array = [];
foreach ($images as $i => $image) {
  array_push($insert_array, $image);
  array_push($insert_array, $current_user_id);
  array_push($insert_array, $work_id);
  // mainのimageはmainカラムを1にするr
  if ($i === 0) {
    array_push($insert_array, 1);
  } else {
    array_push($insert_array, 0);
  }
  array_push($insert_array, $date);
}
$sql->execute($insert_array);

header('Location: ../index.php');
exit();
?>
