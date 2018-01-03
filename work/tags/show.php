<?php
session_start();
require_once('../../common.php');

define('WORKS_PER_PAGE', 16);

$path = '../../';
$title = 'タグの作品';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ../../user/login.php');
  exit();
}

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);

// タグIDを取得
$tag_id = !empty($_GET['id']) ? h($_GET['id']) : 0;

// 指定されたタグIDの作品が存在するかどうか
try {
  $sql = $pdo->prepare(
   "SELECT * FROM tags
    WHERE id=?"
  );
  $sql->execute(array($tag_id));
  $tag = $sql->fetch();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
// タグが指定されていないor存在しない物を参照していたらリダイレクトする
if ($tag_id === 0 || empty($tag)) {
  header('Location: ../../index.php');
  exit();
}

// 作品数を取得
try {
  $sql = $pdo->prepare(
   "SELECT count(*) AS count
    FROM work_tags
    WHERE tag_id=?"
  );
  $sql->execute(array($tag_id));
  $works_count = $sql->fetch()['count'];
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
  header('Location: ../../index.php');
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
      ( SELECT count(*) FROM comments
        WHERE comments.work_id=works.id
      ) AS comments_count,
      ( SELECT count(*) FROM likes
        WHERE likes.work_id=works.id
      ) AS likes_count
    FROM works
    LEFT OUTER JOIN users ON works.user_id=users.id
    LEFT OUTER JOIN work_tags ON works.id=work_tags.work_id
    WHERE tag_id=:tagid
    ORDER BY works.created_at DESC
    LIMIT :offset, :per"
  );
  $sql->bindValue(':tagid', $tag_id, PDO::PARAM_INT);
  $sql->bindValue(':offset', $offset, PDO::PARAM_INT);
  $sql->bindValue(':per', WORKS_PER_PAGE, PDO::PARAM_INT);
  $sql->execute();
  $works = $sql->fetchAll();
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
  exit();
}
?>
<?php include('../../partial/top_layout.php'); ?>
<div class="pt-3 pb-1 my-4 d-flex justify-content-start">
  <div class="px-0 col-3 mr-2">
    <a href="show.php?id=<?php echo $tag['id']; ?>" class="px-0">
      <button type="button" class="w-100 px-0 py-1 btn btn-outline-info">
        <?php echo $tag['name']; ?>
      </button>
    </a>
  </div>
  <p class="py-1 text-secondary">タグが付けられた作品</p>
</div>
<?php include('_works.php'); ?>
<?php include('../../partial/bottom_layout.php'); ?>
