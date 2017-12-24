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
<?php // サイドバー ?>
<header>
  <form class="form-inline">
    <input class="form-control mr-sm-2" type="search" aria-label="Search">
    <button type="submit" class="btn btn-info btn-lg my-sm-0">検索</button>
  </form>
  <ul>
    <li><a class="hidden-xs" href="index.html">トップ</a></li>
    <li><a class="hidden-xs" href="index.html">カテゴリ</a></li>
    <li><a class="hidden-xs" href="index.html">ソート</a></li>
    <li><a class="hidden-xs" href="index.html">使い方</a></li>
  </ul>
</header>

<?php // メイン ?>
<main id="main-collapse">
  <div class="hero-full-wrapper">
    <div class="grid">
      <div class="gutter-sizer"></div>
      <div class="grid-sizer"></div>

      <?php // 作品一覧を表示 ?>
      <?php // TODO: 表示画面を作る ?>
      <?php foreach($works as $work) { ?>
        <h3><?php echo $work['title']; ?></h3>
        <p><?php echo $work['user_avatar']; ?></p>
        <p><?php echo $work['user_name']; ?></p>
        <div style="background-image: <?php echo $work['first_work_image']; ?>"></div>
        <p><?php echo $work['likes_count']; ?></p>
      <?php } ?>

      <div class="grid-item">
        <img class="img-responsive" alt="" src="assets/images/img-12.jpg">
        <a href="./project.html" class="project-description">
          <div class="project-text-holder">
            <div class="project-text-inner">
              <h3>Vivamus vestibulum</h3>
              <p>Discover more</p>
            </div>
          </div>
        </a>
      </div>

      <div class="grid-item">
        <img class="img-responsive" alt="" src="assets//images/img-05.jpg">
        <a href="./project.html" class="project-description">
          <div class="project-text-holder">
            <div class="project-text-inner">
              <h3>Vivamus vestibulum</h3>
              <p>Discover more</p>
            </div>
          </div>
        </a>
      </div>

      <div class="grid-item">
        <img class="img-responsive" alt="" src="assets/images/img-13.jpg">
        <a href="./project.html" class="project-description">
          <div class="project-text-holder">
            <div class="project-text-inner">
              <h3>Vivamus vestibulum</h3>
              <p>Discover more</p>
            </div>
          </div>
        </a>
      </div>

      <div class="grid-item">
        <img class="img-responsive" alt="" src="assets/images/img-04.jpg">
        <a href="./project.html" class="project-description">
          <div class="project-text-holder">
            <div class="project-text-inner">
              <h3>Vivamus vestibulum</h3>
              <p>Discover more</p>
            </div>
          </div>
        </a>
      </div>

      <div class="grid-item">
        <img class="img-responsive" alt="" src="assets//images/img-07.jpg">
        <a href="./project.html" class="project-description">
          <div class="project-text-holder">
            <div class="project-text-inner">
              <h3>Vivamus vestibulum</h3>
              <p>Discover more</p>
            </div>
          </div>
        </a>
      </div>

      <div class="grid-item">
        <img class="img-responsive" alt="" src="assets/images/img-11.jpg">
        <a href="./project.html" class="project-description">
          <div class="project-text-holder">
            <div class="project-text-inner">
              <h3>Vivamus vestibulum</h3>
              <p>Discover more</p>
            </div>
          </div>
        </a>
      </div>

      <div class="grid-item">
        <img class="img-responsive" alt="" src="assets/images/img-10.jpg">
        <a href="./project.html" class="project-description">
          <div class="project-text-holder">
            <div class="project-text-inner">
              <h3>Vivamus vestibulum</h3>
              <p>Discover more</p>
            </div>
          </div>
        </a>
      </div>

      <div class="grid-item">
        <img class="img-responsive" alt="" src="assets/images/img-03.jpg">
        <a href="./project.html" class="project-description">
          <div class="project-text-holder">
            <div class="project-text-inner">
              <h3>Vivamus vestibulum</h3>
              <p>Discover more</p>
            </div>
          </div>
        </a>
      </div>
    </div><!-- grid -->
  </div><!-- hero-full-wrapper -->
</main>
<?php include('partial/bottom_layout.php') ?>
