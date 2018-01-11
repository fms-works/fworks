<?php
session_start();
require_once('common.php');

define('WORKS_PER_PAGE', 12);

$path = '';
$title = 'FWorks';

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);

// 作品数を取得
try {
  $works_count = $pdo->query(
    "SELECT count(*) FROM works"
  )->fetchColumn();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
$page_num = ceil($works_count / WORKS_PER_PAGE);

// ページネーション
if(!empty($_GET['page']) && preg_match('/^\d+$/', $_GET['page'])) {
  $page = (int)h($_GET['page']);
} else {
  $page = 1;
}
$offset = ($page - 1) * WORKS_PER_PAGE;

// 作品が存在しないページを選択したらリダイレクトする
if ($page !== 1 && $page > $page_num) {
  header('Location: index.php');
  exit();
}

// 人気のタグを取得
try {
  $popular_tags = $pdo->query(
   "SELECT
      work_tags.tag_id AS id,
      tags.name,
      count(*) AS works_count
    FROM work_tags
    LEFT OUTER JOIN tags ON tags.id=work_tags.tag_id
    GROUP BY tag_id
    ORDER BY works_count DESC
    LIMIT 3"
  )->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// 人気のworkを取得
try {
  $popular_works = $pdo->query(
   "SELECT
      works.*,
      users.id     AS user_id,
      users.name   AS user_name,
      users.avatar AS user_avatar,
      ( SELECT content FROM work_images
        WHERE work_images.work_id=works.id AND work_images.num=0
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
    ORDER BY likes_count DESC
    LIMIT 3"
  );
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// 全てのworkを取得
try {
  $sql = $pdo->prepare(
   "SELECT
      works.*,
      users.id     AS user_id,
      users.name   AS user_name,
      users.avatar AS user_avatar,
      ( SELECT content FROM work_images
        WHERE work_images.work_id=works.id AND work_images.num=0
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
    ORDER BY works.created_at DESC
    LIMIT :offset, :per"
  );
  $sql->bindValue(':offset', $offset, PDO::PARAM_INT);
  $sql->bindValue(':per', WORKS_PER_PAGE, PDO::PARAM_INT);
  $sql->execute();
  $works = $sql->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
?>
<?php include('partial/top_layout.php'); ?>
<?php // TODO: 検索機能を追加 ?>
<?php // TODO: ユーザーランキング表示 ?>
<?php // 人気のタグを表示 ?>
<h4 class="py-0 my-4 page-title">人気のタグ</h4>
<div class="row my-2 mx-0 px-0">
  <?php foreach ($popular_tags as $tag): ?>
    <div class="col-sm-3 my-1">
      <a href="work/tags/show.php?id=<?php echo $tag['id']; ?>" class="px-0">
        <button type="button" class="w-100 px-0 py-1 btn btn-outline-info">
          <?php echo $tag['name'] . " (" . $tag['works_count'] . ")"; ?>
        </button>
      </a>
    </div>
  <?php endforeach; ?>
  <div class="col-sm-3 my-1">
    <a href="work/tags/index.php" class="col-md-3 my-1 px-0">
      <button type="button" class="w-100 px-0 py-1 btn btn-outline-secondary">
        タグ一覧
      </button>
    </a>
  </div>
</div>
<?php // 人気の投稿を表示 ?>
<h4 class="py-0 my-4 page-title">人気の投稿</h4>
<div class="row">
  <?php foreach($popular_works as $work): ?>
    <?php include('partial/work.php'); ?>
  <?php endforeach; ?>
</div>
<?php // すべての投稿を表示 ?>
<h4 class="py-0 mt-3 page-title">全ての投稿</h4>
<div class="row">
  <?php foreach($works as $work): ?>
    <?php include('partial/work.php'); ?>
  <?php endforeach; ?>
</div>
<?php include('work/_pagination.php'); ?>
<?php include('partial/bottom_layout.php'); ?>
