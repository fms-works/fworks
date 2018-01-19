<?php
session_start();
require_once('../common.php');

$path = '../';
$title = 'いいねした作品';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: login.php');
  exit();
}

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);

// 表示するユーザーを取得
$user_id = !empty($_GET['id']) ? h($_GET['id']) : $current_user_id;
$show_user_data = get_user_data($pdo, $user_id);

// 存在しないユーザーを選択したら自分のプロフィールページに遷移する
if (empty($show_user_data)) {
  header("Location: show.php");
  exit();
} else {
  $user = $show_user_data;
}

// 作品一覧を表示する
try {
  $sql = $pdo->prepare(
   "SELECT
      works.*,
      users.id     AS user_id,
      users.name   AS user_name,
      users.avatar AS user_avatar,
      ( SELECT content FROM work_images
        WHERE work_id=works.id AND work_images.num=0
        LIMIT 1
      ) AS first_work_image,
      ( SELECT count(*) FROM comments
        WHERE comments.work_id=works.id
      ) AS comments_count,
      ( SELECT count(*) FROM likes
        WHERE likes.work_id=works.id
      ) AS likes_count
    FROM works
    LEFT OUTER JOIN users ON works.user_id=users.id
    LEFT OUTER JOIN likes ON works.id=likes.work_id
    WHERE likes.user_id=?
    ORDER BY works.created_at DESC"
  );
  $sql->execute(array($user_id));
  $like_works = $sql->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
?>
<?php include('../partial/top_layout.php'); ?>
<?php // プロフィール ?>
<div class="d-flex justify-content-between">
  <h2 class="py-4 page-title">
    <?php echo $current_user_id === $user_id ? 'いいねした作品' : $show_user_data['name'] . 'さんのいいねした作品'; ?>
  </h2>
</div>
<?php // 作品一覧 ?>
<div class="card-columns py-3">
  <?php if (empty($like_works)) echo '<p>まだいいねした作品がありません</p>'; ?>
  <?php foreach($like_works as $work): ?>
    <?php include('../partial/work.php'); ?>
  <?php endforeach; ?>
</div>
<?php include('../partial/bottom_layout.php'); ?>
