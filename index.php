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

// work一覧を取得
try {
  $works = $pdo->query("
    SELECT
      works.id,
      works.title,
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
    ORDER BY works.created_at
  ")->fetchAll();
} catch (PDOException $e) {
  echo $e;
  exit();
}
?>
<?php include('partial/top_layout.php'); ?>
<?php // メイン ?>
<div class="container">
  <?php // 作品一覧を表示 ?>
  <div class="row">
    <?php $index = 0; // TODO: 消す ?>
    <?php foreach($works as $work) { ?>
      <div class="p-1 col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card">
          <a class="card-link" href="work/show.php?id=<?php echo $work['id']; ?>">
            <img class="card-img-top" src="
              <?php
                // TODO: $index関係を消す
                if ($index % 3 === 0) {
                  echo 'assets/images/bb8avatar.jpg';
                } else if ($index % 3 === 1) {
                  echo 'assets/images/sw.jpg';
                } else if ($index % 3 === 2) {
                  echo 'assets/images/chara1.png';
                } else {
                  echo $work['first_work_image'];
                }
                $index += 1;
              ?>
            " alt="work image">
          </a>
          <div class="card-body">
            <h4 class="card-title"><?php echo $work['title']; ?></h4>
            <p><?php echo $work['likes_count']; ?></p>
            <a class="card-user-link" href="user/show.php?<?php echo $work['user_id']; ?>">
              <?php // echo $work['user_avatar']; ?>
              <img class="work-avatar" src="assets/images/barbie.jpg">
              <p class="work-username text-dark"><?php echo $work['user_name']; ?></p>
            </a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<?php include('partial/bottom_layout.php') ?>
