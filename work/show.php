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

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);

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
  $work_images = $sql->fetchAll();
} catch (PDOExctption $e) {
  echo $e;
  exit();
}
?>
<?php include('../partial/top_layout.php'); ?>
<?php // 作品表示 ?>
<?php // 自分の作品を編集する　?>
<?php if ($current_user_id === $work['user_id']) { ?>
  <a href="edit.php?id=<?php echo $work_id; ?>" class="btn btn-info">編集する</a>
<?php } ?>
<div class="form-group">
  <label>タイトル</label>
  <p><?php echo $work['title']; ?></p>
</div>
<?php foreach($work_images as $i => $image) { ?>
  <?php if ($i === 0) { ?>
    <div class="form-group">
      <image src="data:image/png;base64,<?php echo $image['content']; ?>" alt="image" class="img-thumbnail rounded">
    </div>
    <div class="form-group row">
  <?php } else { ?>
      <div class="col-xs-12 col-sm-6 col-md-4">
        <image src="data:image/png;base64,<?php echo $image['content']; ?>" alt="image" class="img-thumbnail rounded">
      </div>
  <?php } ?>
<?php } ?>
</div>
<div class="form-group">
  <label>Githubリポジトリ</label>
  <p><?php echo $work['github-link']; ?></p>
</div>
<div class="form-group">
  <label>OpenProcessingリンク</label>
  <p><?php echo $work['openprocessing-link']; ?></p>
</div>
<div class="form-group">
  <label>リンク</label>
  <p><?php echo $work['link']; ?></p>
</div>
<div class="form-group">
  <label>詳細</label>
  <p><?php echo $work['detail']; ?></p>
</div>
<div class="py-3">
  <a href="destroy.php?id=<?php echo $work_id; ?>" onClick="return confirm('削除してもよろしいですか？');" class="btn btn-danger px-4">削除する</a>
</div>
<?php include('../partial/bottom_layout.php'); ?>
