<?php
session_start();

require_once('../common.php');

$path = '../';
$title = '作品';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ../user/login.php');
  exit();
}

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];

// 表示する作品のIDを取得
$work_id = !empty($_GET['id']) ? h($_GET['id']) : 0;
// 作品を取得する
try {
  $sql = $pdo->prepare("
    SELECT * FROM works
    WHERE id=?
  ");
  $sql->execute(array($work_id));
  $work = $sql->fetch();
} catch (PDOException $e) {
  echo $e;
  exit();
}

// 存在しない作品を選択したらメイン画面に戻る
if (empty($work)) {
  header("Location: ../index.php");
  exit();
}

// 作品の画像を取得
try {
  $sql = $pdo->prepare("
    SELECT content
    FROM work_images
    WHERE work_id=?
  ");
  $sql->execute(array($work_id));
  $work_images = $sql->fetch();
} catch (PDOExctption $e) {
  echo $e;
  exit();
}
?>
<?php include('../partial/top_layout.php'); ?>
<div class="container">
  <?php // 作品表示 ?>
  <div>
    <?php // 自分の作品を編集する　?>
    <?php if ($current_user_id === $work['user_id']) { ?>
      <a href="../work/edit.php?id=<?php echo $work_id; ?>">編集する</a>
    <?php } ?>
    <p><?php echo $work['title']; ?></p>
    <?php foreach($work_images as $image) { ?>
      <p><?php echo $image; ?></p>
    <?php } ?>
  </div>
</div>
<?php include('../partial/bottom_layout.php'); ?>
