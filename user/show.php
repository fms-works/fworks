<?php
session_start();
require_once('../common.php');

$path = '../';
$title = 'ユーザー詳細';

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
    WHERE works.user_id=?
    ORDER BY works.created_at DESC"
  );
  $sql->execute(array($user_id));
  $works = $sql->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
?>
<?php include('../partial/top_layout.php'); ?>
<?php // プロフィール ?>
<div class="d-flex justify-content-between">
  <h2 class="py-4">
    <?php echo $current_user_id === $user_id ? 'マイページ' : $show_user_data['name'] . 'さんのページ'; ?>
  </h2>
  <div class="py-4">
    <?php if ($current_user_id === $user_id): ?>
      <a href="edit.php" class="btn btn-info">編集する</a>
    <?php endif; ?>
  </div>
</div>
<div class="d-flex justify-content-start">
  <img src="../assets/images/no_image.png" data-src="<?php echo $show_user_data['avatar']; ?>" class="mypage-avatar lazy">
  <div class="px-2 py-4">
    <h4><?php echo $user['name']; ?></h4>
  </div>
</div>
<?php // SNSアイコン ?>
<div class="py-3">
  <a href="https://twitter.com/<?php echo $user['screen_name']; ?>?lang=ja" class="mr-2 icon-link">
    <img src="../assets/images/twitter.svg" alt="twitter" class="icon">
  </a>
  <?php if (!empty($user['github_account'])): ?>
    <a href="https://github.com/<?php echo $user['github_account']; ?>" class="icon-link">
      <img src="../assets/images/github.png" alt="github" class="icon">
    </a>
  <?php endif; ?>
</div>
<div class="py-3">
  <h5 class="py-1 my-2 page-title">プロフィール</h5>
  <p class="user-profile"><?php echo !empty($user['profile']) ? nl2br($user['profile']) : '登録されていません'; ?></p>
</div>
<?php // 作品一覧 ?>
<h3 class="py-3 page-title">作品一覧</h3>
<div class="card-columns px-1 py-3">
  <?php if (empty($works)) echo '<p>まだ作品がありません</p>'; ?>
  <?php foreach($works as $work): ?>
    <?php include('../partial/work.php'); ?>
  <?php endforeach; ?>
</div>
<?php if ($current_user_id === $work['user_id']): ?>
  <?php // Danger zone ?>
  <div class="py-5">
    <a href="destroy.php" onClick="return confirm('投稿した作品やユーザー情報は削除され、復元することはできません。本当に退会しますか？');" class="btn btn-danger px-4">
      退会する
    </a>
  </div>
<?php endif; ?>
<?php include('../partial/bottom_layout.php'); ?>
