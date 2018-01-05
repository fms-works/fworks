<?php
session_start();
require_once('../common.php');

$path = '../';
$title = '作品詳細';

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
      works.*,
      users.id     AS user_id,
      users.name   AS user_name,
      users.avatar AS user_avatar,
      users.screen_name AS user_screen_name,
      ( SELECT count(*) FROM likes
        WHERE likes.work_id=works.id
      ) AS likes_count
    FROM works
    LEFT OUTER JOIN users ON works.user_id=users.id
    WHERE works.id=?"
  );
  $sql->execute(array($work_id));
  $work = $sql->fetch();
  // タイトルを取得
  $title = $work['title'];
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
   "SELECT *
    FROM work_tags
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
      comments.*,
      users.id AS user_id,
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
<h3 class="py-3 my-4 page-title">作品詳細ページ</h3>
<a class="card-user-link" href="../user/show.php?id=<?php echo $work['user_id']; ?>">
  <img src="../assets/images/no_image.png" data-src="<?php echo $work['user_avatar']; ?>" class="work-avatar lazy">
  <h4 class="work-username text-dark"><?php echo $work['user_name']; ?></h4>
</a>
<div class="d-flex justify-content-between py-2">
  <h1 class="mb-0 py-2"><?php echo $work['title']; ?></h1>
  <?php // 自分の作品を編集する　?>
  <?php if ($current_user_id === $work['user_id']): ?>
    <div class="py-2">
      <a href="edit.php?id=<?php echo $work_id; ?>" class="d-block btn btn-info">編集する</a>
    </div>
  <?php endif; ?>
</div>
<?php // タグ一覧 ?>
<div class="row px-0">
  <div class="col-11 row mx-0 px-0">
    <?php foreach ($tags as $tag): ?>
      <div class="col-3">
        <a href="tags/show.php?id=<?php echo $tag['id']; ?>" class="px-0">
          <button type="button" class="w-100 px-0 py-1 btn btn-outline-info">
            <?php echo $tag['name']; ?>
          </button>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="col-1 d-flex justify-content-end">
    <?php // Twitter投稿ボタン ?>
    <div class="d-inline align-middle pr-2">
      <?php
        echo twitter_share_button(
          "「" . $work['title'] . "」",
          "http://ebinuma.nkmr.io/work/work/show?id=" . $work['id']
        );
      ?>
    </div>
    <img class="work-heart card-heart my-1" id="<?php echo $is_liked ? 'unlike' : 'like'; ?>" data-workid="<?php echo $work['id']; ?>" src="../assets/images/<?php echo $is_liked ? 'heart.png' : 'noheart.svg'; ?>">
    <span id="likesCount" class="px-1 text-danger"><?php echo $work['likes_count']; ?></span>
  </div>
</div>
<div class="my-4">
  <h4 class="py-0 my-4 page-title">詳細</h4>
  <p><?php echo $work['detail']; ?></p>
</div>
<?php // TODO: 画像表示方法を工夫する ?>
<?php // 画像一覧 ?>
<h4 class="py-0 my-4 page-title">画像</h4>
<div id="carouselIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php for ($i = 0; $i < count($work_images); $i++): ?>
      <li data-target="#carouselIndicators" data-slide-to="<?php echo $i; ?>" <?php if ($i === 0) echo 'class="active"'?>></li>
    <?php endfor; ?>
  </ol>
  <div class="carousel-inner">
    <?php foreach($work_images as $i => $image): ?>
      <div class="carousel-item<?php if ($i === 0) echo ' active'; ?>">
        <img src="data:image/png;base64,<?php echo $image['content']; ?>" alt="work-image" class="d-block w-80 img-thumbnail rounded">
      </div>
    <?php endforeach; ?>
  </div>
  <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php // TODO: リポジトリとかOpenProcessingの表示方法を工夫する ?>
<?php // リンク ?>
<div class="my-4">
  <h4 class="py-0 my-4 page-title">リンク</h4>
  <?php if (empty($work['github_link']) && empty($work['openprocessing_link']) && empty($work['link'])): ?>
    <p>リンクはありません</p>
  <?php else: ?>
    <?php if (!empty($work['github_link'])): ?>
      <h5 class="py-0 mt-4 page-title">Github</h5>
      <a href="<?php echo $work['github_link']; ?>">
        <p><?php echo $work['github_link']; ?></p>
      </a>
    <?php endif; ?>
    <?php if (!empty($work['openprocessing_link'])): ?>
      <h5 class="py-0 mt-4 page-title">OpenProcessing</h5>
      <a href="<?php echo $work['openprocessing_link']; ?>">
        <p><?php echo $work['openprocessing_link']; ?></p>
      </a>
    <?php endif; ?>
    <?php if (!empty($work['link'])): ?>
      <h5 class="py-0 mt-4 page-title">その他</h5>
      <a href="<?php echo $work['link']; ?>">
        <p><?php echo $work['link']; ?></p>
      </a>
    <?php endif; ?>
  <?php endif; ?>
</div>
<?php // コメント表示 ?>
<h3 class="my-4 page-title">コメント</h3>
<?php // コメント投稿 ?>
<div class="row pb-3">
  <div class="col-xs-12 col-sm-8 my-2">
    <input type="text" name="content" id="commentInput" class="form-control" placeholder="コメントを入力してください">
  </div>
  <button class="btn btn-primary mx-0 px-0 py-1 my-2 col-xs-10 col-sm-2" id="postComment" data-workid='<?php echo $work_id; ?>'>
    送信
  </button>
</div>
<div id="comments">
  <?php foreach ($comments as $comment): ?>
    <div class="card my-2">
      <div class="card-header py-1 d-flex justify-content-between">
        <div>
          <a class="comment-header" href="../user/show.php?id=<?php echo $comment['user_id']; ?>">
            <img class="work-avatar lazy" src="../assets/images/no_image.png" data-src="<?php echo $comment['user_avatar']; ?>">
            <p class="work-username text-dark d-inline align-middle"><?php echo $comment['user_name']; ?></p>
          </a>
        </div>
        <div>
          <?php if ($current_user_id === $comment['user_id']): ?>
            <button class="btn btn-sm btn-outline-danger mx-0 px-2 py-0" id="destroyComment" data-commentid='<?php echo $comment['id']; ?>'>
              削除
            </button>
          <?php endif; ?>
        </div>
      </div>
      <div class="card-body py-2">
        <?php echo $comment['content']; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php // 削除ボタン ?>
<?php if ($current_user_id === $work['user_id']): ?>
  <div class="mt-3 py-5">
    <a href="destroy.php?id=<?php echo $work_id; ?>" onClick="return confirm('削除してもよろしいですか？');" class="btn btn-danger px-4">
      この作品を削除する
    </a>
  </div>
<?php endif; ?>
<?php include('../partial/bottom_layout.php'); ?>
