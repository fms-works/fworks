<?php
session_start();
require_once('../../common.php');

$path = '../../';
$title = 'タグ一覧';

try {
  $tags = $pdo->query(
   "SELECT * FROM tags"
  )->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
?>
<?php include('../../partial/top_layout.php'); ?>
<?php // TODO: タグ一覧を表示 ?>
<?php foreach($tags as $tag): ?>
  <p><?php echo $tag['name']; ?></p>
<?php endforeach; ?>
<?php include('../../partial/bottom_layout.php'); ?>
