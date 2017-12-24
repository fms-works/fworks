<?php
session_start();

require_once('../common.php');

$path = '../';
$title = 'ユーザー詳細';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: login.php');
  exit();
}

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];

// 表示するユーザーのIDを取得
$user_id = !empty($_GET['id']) ? h($_GET['id']) : $current_user_id;

// 現在のユーザーを取得
try {
  $sql = $pdo->prepare("
    SELECT name, github_account, profile, avatar
    FROM users
    WHERE id=?
  ");
  $sql->execute(array($user_id));
  $user_data = $sql->fetch();
} catch (PDOException $e) {
  echo $e;
  exit();
}

// 存在しないユーザーを選択したら自分のプロフィールページに遷移する
if (empty($user_data)) {
  header("Location: show.php?id=$current_user_id");
  exit();
} else {
  $user = $user_data;
}

// 作品一覧を表示する
try {
  $works = $pdo->query("
    SELECT
      works.*,
      (
        SELECT content FROM work_images
        WHERE work_id=works.id AND work_images.main=1
        LIMIT 1
      ) AS first_work_image
    FROM works
    WHERE works.user_id=$user_id
  ")->fetchAll();
} catch (PDOException $e) {
  echo $e;
  exit();
}
?>
<?php include('../partial/top_layout.php'); ?>
<div class="container">
  <?php // プロフィール ?>
  <div>
    <?php if ($current_user_id === $user_id) { ?>
      <a href="edit.php">編集する</a>
    <?php } ?>
    <image src="hoge.jpg"></image>
    <p><?php echo !empty($user['name']) ? $user['name'] : '登録されていません'; ?></p>
    <p><?php echo !empty($user['github_account']) ? $user['github_account'] : '登録されていません'; ?></p>
    <p><?php echo !empty($user['profile']) ? $user['profile'] : '登録されていません'; ?></p>
    <p><?php echo $user['avatar']; ?></p>
    <a href="destroy.php" onClick="return confirm('削除してもよろしいですか？');">
      削除する
    </a>
  </div>
  <?php // 作品一覧 ?>
  <div>
    <?php if (empty($works)) { ?>
      <p>まだ作品がありません</p>
    <?php } ?>
    <?php foreach($works as $work) { ?>
      <?php $work_id = $work['id'] ?>
      <a href="../work/show.php?id=<?php echo $work_id;?>">
        <div>
          <?php // 自分の作品を編集する　?>
          <p><?php echo $work['title']; ?></p>
          <p><?php echo $work['first_work_image']; ?></p>
        </div>
      </a>
      <?php if ($current_user_id === $user_id) { ?>
        <a href="../work/edit.php?id=<?php echo $work_id; ?>">編集する</a>
      <?php } ?>
    <?php } ?>
  </div>
</div>
<?php include('../partial/bottom_layout.php'); ?>
