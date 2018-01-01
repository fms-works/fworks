<?php
session_start();
require_once('../common.php');

$path = '../';
$title = '作品編集';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ../user/login.php');
  exit();
}

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);

// 編集する作品のIDを取得
$work_id = !empty($_GET['id']) ? h($_GET['id']) : 0;

// 作品を取得
try {
  $sql = $pdo->prepare(
   "SELECT * FROM works
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

// 作品の画像を取得
try {
  $sql = $pdo->prepare(
   "SELECT content, num FROM work_images
    WHERE work_id=?"
  );
  $sql->execute(array($work_id));
  $work_images = $sql->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// メイン画像とサブ画像を分類
$main_image = '';
$sub_images = [];
foreach($work_images as $image) {
  if ($image['num'] === '0') {
    $main_image = $image;
  } else {
    array_push($sub_images, $image);
  }
}

// 作品のタグを取得
try {
  $sql = $pdo->prepare(
   "SELECT tags.name
    FROM
      work_tags
      LEFT OUTER JOIN tags ON tags.id=work_tags.tag_id
    WHERE work_tags.work_id=?"
  );
  $sql->execute(array($work_id));
  $tags = $sql->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
?>
<?php include('../partial/top_layout.php'); ?>
<h1 class="py-3 my-4 page-title">作品を編集する</h1>
<form method="post" action="update.php" enctype="multipart/form-data">
  <input type="hidden" name="work_id" value="<?php echo $work_id; ?>">
  <?php include('./_work-form.php'); ?>
  <input type="submit" class="btn btn-primary px-4 mb-5" value="更新する">
</form>
<?php include('../partial/bottom_layout.php'); ?>
