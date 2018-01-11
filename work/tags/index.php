<?php
session_start();
require_once('../../common.php');

$path = '../../';
$title = 'タグ一覧';

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);

try {
  $tags = $pdo->query(
   "SELECT
      tags.*,
      count(work_tags.tag_id) AS works_count
    FROM tags
    LEFT OUTER JOIN work_tags ON tags.id=work_tags.tag_id
    GROUP BY tags.id
    ORDER BY works_count DESC"
  )->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
?>
<?php include('../../partial/top_layout.php'); ?>
<h1 class="py-3 my-4">タグ一覧</h1>
<div class="row mb-3">
  <?php foreach($tags as $tag): ?>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 my-3 px-3">
      <a href="show.php?id=<?php echo $tag['id']; ?>">
        <button type="button" class="w-100 py-2 btn btn-outline-info">
          <?php echo $tag['name'] . " (" . $tag['works_count'] . ")"; ?>
        </button>
      </a>
    </div>
  <?php endforeach; ?>
</div>
<?php include('../../partial/bottom_layout.php'); ?>
