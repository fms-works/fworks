<?php
session_start();
require_once('../common.php');

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ../user/login.php');
  exit();
}

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];

// バリデーション
if(empty($_POST['title']) || empty($_FILES['main_image']) || empty($_POST['detail'])) {
  header('Location: new.php');
  exit();
}

// データを取得
$new_title = h($_POST['title']);

$images = array();
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
$new_glink  = !empty($_POST['glink'])  ? h($_POST['glink'])   : '';
$new_oplink = !empty($_POST['oplink']) ? h($_POST['oplink']) : '';

$date = date("Y-m-d H:i:s");
// work保存
try {
  $sql = $pdo->prepare(
  "INSERT INTO works
      (title, link, detail, github_link, openprocessing_link, user_id, created_at, updated_at)
    VALUES
      (?, ?, ?, ?, ?, ?, ?, ?)"
  );
  $sql->execute(
    array($new_title, $new_link, $new_detail, $new_glink, $new_oplink, $current_user_id, $date, $date)
  );
  $work_id = $pdo->lastInsertId('id');
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// SQL文作成
$values_sql = '';
for ($i = 0; $i < count($images); $i++) {
  if ($i !== 0) $values_sql .= ",";
  $values_sql .= "(?, ?, ?, ?, ?)";
}

$insert_array = array();
foreach ($images as $i => $image) {
  array_push($insert_array, $image);
  array_push($insert_array, $current_user_id);
  array_push($insert_array, $work_id);
  array_push($insert_array, $i);
  array_push($insert_array, $date);
}

// 画像保存
try {
  $sql = $pdo->prepare(
   "INSERT INTO work_images
      (content, user_id, work_id, num, created_at)
    VALUES " . $values_sql
  );
  $sql->execute($insert_array);
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// タグ取得
$tags = array();
if (!empty($_POST['tag1'])) array_push($tags, h($_POST['tag1']));
if (!empty($_POST['tag2'])) array_push($tags, h($_POST['tag2']));
if (!empty($_POST['tag3'])) array_push($tags, h($_POST['tag3']));

$tag_ids = array();
foreach ($tags as $tag) {
  try {
    $sql = $pdo->prepare(
     "SELECT * FROM tags
      WHERE name LIKE ?"
    );
    $sql->execute(array($tag));
    $foundTag = $sql->fetch();
  } catch (PDOException $e) {
    echo 'MySQL connection failed: ' . $e->getMessage();
    exit();
  }
  //  同じ名前のタグが見つからなかったら
  if (empty($foundTag)) {
    $sql = $pdo->prepare(
      "INSERT INTO tags (name)
       VALUES (?)"
    );
    $sql->execute(array($tag));
    array_push($tag_ids, $pdo->lastInsertId('id'));
  } else {
    array_push($tag_ids, $foundTag['id']);
  }
}

// タグ登録
foreach ($tag_ids as $id) {
  try {
    $sql = $pdo->prepare(
     "INSERT INTO work_tags
        (work_id, tag_id)
      VALUES
        (?, ?)"
    );
    $sql->execute(array($work_id, $id));
  } catch (PDOException $e) {
    echo 'MySQL connection failed: ' . $e->getMessage();
    exit();
  }
}

header('Location: ../index.php');
exit();
?>
