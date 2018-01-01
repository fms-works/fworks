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
  $works = $pdo->query(
   "SELECT
      works.*,
      ( SELECT content FROM work_images
        WHERE work_id=works.id AND work_images.num=0
        LIMIT 1
      ) AS first_work_image,
      ( SELECT count(*) FROM likes
        WHERE likes.work_id=works.id
      ) AS likes_count
    FROM works
    WHERE works.user_id=$user_id
    ORDER BY works.created_at DESC"
  )->fetchAll();
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
<div class="form-group py-3">
  <label>プロフィール</label>
  <p><?php echo !empty($user['profile']) ? $user['profile'] : '登録されていません'; ?></p>
</div>
<?php // 作品一覧 ?>
<h3 class="py-3">作品一覧</h3>
<div class="row">
  <?php if (empty($works)) echo '<p>まだ作品がありません</p>'; ?>
  <?php foreach($works as $work): ?>
    <div class="px-1 py-3 col-xs-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card card-shadow">
        <a class="card-link" href="../work/show.php?id=<?php echo $work['id']; ?>">
          <img class="card-img-top lazy" src="../assets/images/no_image.png" data-src="data:image/png;base64,<?php echo $work['first_work_image']; ?>" alt="work image">
        </a>
        <div class="card-body">
          <h4 class="card-title"><?php echo $work['title']; ?></h4>
          <p class="card-detail"><?php echo $work['detail']; ?></p>
          <p><?php echo $work['likes_count']; ?>いいね</p>
          <?php if ($current_user_id === $user_id): ?>
            <div class="w-100 d-flex justify-content-end">
              <a href="../work/edit.php?id=<?php echo $work['id']; ?>" class="btn btn-info btn-sm mx-1 py-0">編集</a>
              <a href="../work/destroy.php?id=<?php echo $work['id']; ?>" onClick="return confirm('削除してもよろしいですか？');" class="btn btn-danger btn-sm py-0">削除</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
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
