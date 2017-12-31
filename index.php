<?php
session_start();
require_once('common.php');

$path = '';
$title = 'トップ';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: user/login.php');
  exit();
}

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];

try {
  $sql = $pdo->prepare("
    SELECT name, github_account, profile, avatar
    FROM users
    WHERE id=?
  ");
  $sql->execute(array($current_user_id));
  $user_data = $sql->fetch();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// work一覧を取得
try {
  $works = $pdo->query(
   "SELECT
      works.*,
      users.id     AS user_id,
      users.name   AS user_name,
      users.avatar AS user_avatar,
      (
        SELECT content FROM work_images
        WHERE work_images.work_id=works.id AND work_images.main=1
        LIMIT 1
      ) AS first_work_image,
      (
        SELECT count(*) FROM likes
        WHERE likes.work_id=works.id
      ) AS likes_count
    FROM
      works
      LEFT OUTER JOIN users ON works.user_id=users.id
    ORDER BY works.created_at DESC"
  )->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
?>
<?php include('partial/top_layout.php'); ?>
<?php // 作品一覧を表示 ?>
<a href="work/tags/index.php">タグ一覧</a>
<div class="row">
  <?php foreach($works as $work): ?>
    <div class="px-1 py-3 col-xs-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card card-shadow">
        <a class="card-link" href="work/show.php?id=<?php echo $work['id']; ?>">
          <img class="card-img-top" src="data:image/png;base64,<?php echo $work['first_work_image']; ?>" alt="work image">
        </a>
        <div class="card-body">
          <h4 class="card-title"><?php echo $work['title']; ?></h4>
          <p class="card-detail"><?php echo $work['detail']; ?></p>
          <p><?php echo $work['likes_count']; ?>いいね</p>
          <a class="card-user-link" href="user/show.php?<?php echo $work['user_id']; ?>">
            <img class="work-avatar" src="<?php echo $work['user_avatar']; ?>">
            <p class="work-username text-dark"><?php echo $work['user_name']; ?></p>
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php include('partial/bottom_layout.php'); ?>
