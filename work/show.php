<?php
session_start();
require_once('../common.php');

$path = '../';
$title = '作品';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ../user/login.php');
  exit();
}

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);

// 表示する作品のIDを取得
$work_id = !empty($_GET['id']) ? h($_GET['id']) : 0;
// 作品を取得する
try {
  $sql = $pdo->prepare(
   "SELECT
      *,
      (
        SELECT count(*) FROM likes
        WHERE likes.work_id=works.id
      ) AS likes_count
    FROM works
    WHERE id=?"
  );
  $sql->execute(array($work_id));
  $work = $sql->fetch();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();;
  exit();
}

// 存在しない作品を選択したらメイン画面に戻る
if (empty($work)) {
  header("Location: ../index.php");
  exit();
}

// 作品の画像を取得
try {
  $sql = $pdo->prepare(
   "SELECT content, num
    FROM work_images
    WHERE work_id=?"
  );
  $sql->execute(array($work_id));
  $work_images = $sql->fetchAll();
} catch (PDOExctption $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// 作品のタグを取得
try {
  $sql = $pdo->prepare(
   "SELECT tags.name
    FROM
      work_tags
      LEFT OUTER JOIN tags ON tags.id=work_tags.tag_id
    WHERE work_tags.work_id=?"
  );
  $sql->execute(array($work_id));
  $tags = $sql->fetchAll();
} catch (PDOExctption $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}

// 作品のコメントを取得
try {
  $sql = $pdo->prepare(
   "SELECT
      comments.content,
      users.avatar AS user_avatar,
      users.name AS user_name
    FROM comments
      LEFT OUTER JOIN users ON users.id=comments.user_id
    WHERE comments.work_id=?"
  );
  $sql->execute(array($work_id));
  $comments = $sql->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();;
  exit();
}

// 自分がいいねしているか取得する
try {
  $sql = $pdo->prepare(
   "SELECT * from LIKES
    WHERE user_id=? AND work_id=?"
  );
  $sql->execute(array($current_user_id, $work_id));
  $like = $sql->fetch();
  $is_liked = $like > 0 ? true : false;
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();;
  exit();
}
?>
<?php include('../partial/top_layout.php'); ?>
<?php // 作品表示 ?>
<?php // 自分の作品を編集する　?>
<?php if ($current_user_id === $work['user_id']): ?>
  <a href="edit.php?id=<?php echo $work_id; ?>" class="btn btn-info">編集する</a>
<?php endif; ?>
<div class="form-group">
  <label>タイトル</label>
  <p><?php echo $work['title']; ?></p>
</div>
<div class="form-group">
  <p><span id="likesCount"><?php echo $work['likes_count']; ?></span>いいね</p>
</div>
<img class="work-heart" id="<?php echo $is_liked ? 'unlike' : 'like'; ?>" data-workid="<?php echo $work['id']; ?>" src="../assets/images/<?php echo $is_liked ? 'heart.png' : 'noheart.svg'; ?>">
<?php // メイン画像 ?>
<?php foreach($work_images as $i => $image): ?>
  <?php if ($image['num'] === '0'): ?>
    <div class="form-group">
      <img src="../assets/images/no_image.png" data-src="data:image/png;base64,<?php echo $image['content']; ?>" alt="image" class="img-thumbnail rounded lazy">
    </div>
    <?php array_splice($work_images, $i, 1); break; ?>
  <?php endif; ?>
<?php endforeach; ?>
<?php // サブ画像 ?>
<div class="form-group row">
  <?php foreach($work_images as $image): ?>
    <div class="col-xs-12 col-sm-6 col-md-4">
      <img src="../assets/images/no_image.png" data-src="data:image/png;base64,<?php echo $image['content']; ?>" alt="image" class="img-thumbnail rounded lazy">
    </div>
  <?php endforeach; ?>
</div>
<?php // Githubリポジトリ ?>
<div class="form-group">
  <label>Githubリポジトリ</label>
  <?php if (empty($work['github-link'])): ?>
    <p>Githubリポジトリはありません</p>
  <?php else: ?>
    <p><?php echo $work['github-link']; ?></p>
  <?php endif; ?>
</div>
<?php // OpenProcessingリンク ?>
<div class="form-group">
  <label>OpenProcessingリンク</label>
  <?php if (empty($work['openprocessing-link'])): ?>
    <p>OpenProcessingリンクはありません</p>
  <?php else: ?>
    <p><?php echo $work['openprocessing-link']; ?></p>
  <?php endif; ?>
</div>
<?php // リンク ?>
<div class="form-group">
  <label>リンク</label>
  <?php if (empty($work['link'])): ?>
    <p>リンクはありません</p>
  <?php else: ?>
    <p><?php echo $work['link']; ?></p>
  <?php endif; ?>
</div>
<?php // タグ一覧 ?>
<div class="form-group">
  <label>タグ</label>
  <div class="d-flex justify-content-start">
    <?php if (empty($tags)): ?>
      <p>タグがつけられていません</p>
    <?php else: ?>
      <?php foreach ($tags as $tag): ?>
        <p class="mr-2"><?php echo $tag['name']; ?></p>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</di>
<div class="form-group">
  <label>詳細</label>
  <p><?php echo $work['detail']; ?></p>
</div>
<?php // コメント投稿 ?>
<form>
  <div class="form-group">
    <label for="commentInput">コメントする</label>
    <input type="text" name="content" id="commentInput" class="form-control" placeholder="コメントを入力してください">
  </div>
  <button class="btn btn-primary px-4 mb-5" id="postComment" data-workid='<?php echo $work_id; ?>'>送信</button>
</form>
<?php // コメント表示 ?>
<h1 class="py-3 my-4 page-title">コメント一覧</h1>
<div id="comments">
  <?php foreach ($comments as $comment): ?>
    <div class="card my-2">
      <div class="card-header py-1">
        <img class="work-avatar lazy" src="../assets/images/no_image.png" data-src="<?php echo $comment['user_avatar']; ?>">
        <p class="work-username text-dark d-inline align-middle">えびけん</p>
      </div>
      <div class="card-body py-2">
        <?php echo $comment['content']; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php // 削除ボタン ?>
<div class="py-3">
  <a href="destroy.php?id=<?php echo $work_id; ?>" onClick="return confirm('削除してもよろしいですか？');" class="btn btn-danger px-4">この作品を削除する</a>
</div>
<?php include('../partial/bottom_layout.php'); ?>
