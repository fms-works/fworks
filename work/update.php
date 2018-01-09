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

// 保存する画像の中身
$images = array();
// 保存する画像の番号
$nums = array();
function getImage($image_file) {
  return base64_encode(file_get_contents($image_file['tmp_name']));
}
if (!empty($_FILES['main_image']['tmp_name'])) {
  array_push($images, getImage($_FILES['main_image']));
  array_push($nums, 0);
}
if (!empty($_FILES['sub_image1']['tmp_name'])) {
  array_push($images, getImage($_FILES['sub_image1']));
  array_push($nums, 1);
}
if (!empty($_FILES['sub_image2']['tmp_name'])) {
  array_push($images, getImage($_FILES['sub_image2']));
  array_push($nums, 2);
}
if (!empty($_FILES['sub_image3']['tmp_name'])) {
  array_push($images, getImage($_FILES['sub_image3']));
  array_push($nums, 3);
}
$new_link   = !empty($_POST['link'])   ? h($_POST['link'])   : '';
$new_detail = !empty($_POST['detail']) ? h($_POST['detail']) : '';
$new_glink  = !empty($_POST['glink'])  ? h($_POST['glink'])  : '';
$new_oplink = !empty($_POST['oplink']) ? h($_POST['oplink']) : '';
$new_ytlink = !empty($_POST['ytlink']) ? h($_POST['ytlink']) : '';

$date = date("Y-m-d H:i:s");

// work更新
try {
  $sql = $pdo->prepare(
   "UPDATE works
    SET
      title=?,
      link=?,
      detail=?,
      github_link=?,
      openprocessing_link=?,
      youtube_link=?,
      updated_at=?
    WHERE id=?"
  );
  $sql->execute(
    array($new_title, $new_link, $new_detail, $new_glink, $new_oplink, $new_ytlink, $date, $work_id)
  );
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// image追加or更新
try {
  foreach ($images as $i => $image) {
    $sql = $pdo->prepare(
      "SELECT * FROM work_images
       WHERE work_id=? AND num=?"
    );
    $sql->execute(array($work_id, $nums[$i]));
    $saved_image = $sql->fetchAll();
    // 新しく追加
    if (empty($saved_image)) {
      $sql = $pdo->prepare(
         "INSERT INTO work_images
            (content, user_id, work_id, num, created_at)
          VALUES
            (?, ?, ?, ?, ?)"
      );
      $sql->execute(
        array($image, $current_user_id, $work_id, $nums[$i], $date)
      );
    } else {
      // 更新
      $sql = $pdo->prepare(
       "UPDATE work_images
        SET content=?
        WHERE work_id=? AND num=?"
      );
      $sql->execute(array($image, $work_id, $nums[$i]));
    }
  }
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// タグ削除
try {
  $sql = $pdo->prepare(
   "DELETE FROM work_tags
    WHERE work_id=?"
  );
  $sql->execute(array($work_id));
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// タグ作成
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
