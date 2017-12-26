<?php
session_start();

require_once('../../common.php');

$path = '../../';
$title = 'タグ一覧';

try {
  $tags = $pdo->query("
    SELECT * FROM tags
  ")->fetchAll();
} catch (PDOException $e) {
  echo $e;
  exit();
}
?>
<?php include('../../partial/top_layout.php'); ?>
<div class="container">
  <?php // TODO: タグ一覧を表示 ?>
  <?php foreach($tags as $tag) { ?>
    <p><?php echo $tag['name']; ?></p>
  <?php } ?>
</div>
<?php include('../../partial/bottom_layout.php'); ?>
