<?php
session_start();
require_once('common.php');

define('WORKS_PER_PAGE', 16);

$path = '';
$title = 'トップ';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: user/login.php');
  exit();
}

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
if ($page > $page_num) {
  header('Location: index.php');
  exit();
}

// work一覧を取得
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
<?php // 作品一覧を表示 ?>
<a href="work/tags/index.php" class="btn btn-primary px-3">タグ一覧</a>
<?php include('_works.php'); ?>
<?php include('partial/bottom_layout.php'); ?>
