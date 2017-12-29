<?php
session_start();

require_once('../common.php');

$path = '../';
$title = 'ユーザー詳細';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: login.php');
  exit();
}

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];

// 表示するユーザーのIDを取得
$user_id = !empty($_GET['id']) ? h($_GET['id']) : $current_user_id;

// 現在のユーザーを取得
try {
  $sql = $pdo->prepare("
    SELECT name, github_account, profile, avatar
    FROM users
    WHERE id=?
  ");
  $sql->execute(array($user_id));
  $user_data = $sql->fetch();
} catch (PDOException $e) {
  echo $e;
  exit();
}

// 存在しないユーザーを選択したら自分のプロフィールページに遷移する
if (empty($user_data)) {
  header("Location: show.php?id=$current_user_id");
  exit();
} else {
  $user = $user_data;
}

// 作品一覧を表示する
try {
  $works = $pdo->query("
    SELECT
      works.*,
      (
        SELECT content FROM work_images
        WHERE work_id=works.id AND work_images.main=1
        LIMIT 1
      ) AS first_work_image
    FROM works
    WHERE works.user_id=$user_id
  ")->fetchAll();
} catch (PDOException $e) {
  echo $e;
  exit();
}
?>
<?php include('../partial/top_layout.php'); ?>
<div class="container py-3">
  <?php // プロフィール ?>
  <div>
    <image src="hoge.jpg"></image>
    <?php if ($current_user_id === $user_id) { ?>
      <a href="edit.php" class="btn btn-info">編集する</a>
    <?php } ?>
    <p><?php echo !empty($user['name']) ? $user['name'] : '登録されていません'; ?></p>
    <p><?php echo !empty($user['github_account']) ? $user['github_account'] : '登録されていません'; ?></p>
    <p><?php echo !empty($user['profile']) ? $user['profile'] : '登録されていません'; ?></p>
    <p><?php echo $user['avatar']; ?></p>
  </div>
  <?php // 作品一覧 ?>
  <div>
    <h3 class="py-3">作品一覧</h3>
    <div class="row">
      <?php if (empty($works)) { ?>
        <p>まだ作品がありません</p>
      <?php } ?>
      <?php $index = 0; // TODO: 消す ?>
      <?php foreach($works as $work) { ?>
        <div class="px-1 py-3 col-xs-12 col-sm-6 col-md-4 col-lg-3">
          <div class="card card-shadow">
            <a class="card-link" href="../work/show.php?id=<?php echo $work['id']; ?>">
              <img class="card-img-top" src="
                <?php
                  // TODO: $index関係を消す
                  if ($index % 3 === 0) {
                    echo '../assets/images/bb8avatar.jpg';
                  } else if ($index % 3 === 1) {
                    echo '../assets/images/sw.jpg';
                  } else if ($index % 3 === 2) {
                    echo '../assets/images/chara1.png';
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
                <img class="work-avatar" src="../assets/images/barbie.jpg">
                <p class="work-username text-dark"><?php echo $user['name']; ?></p>
              </a>
              <?php if ($current_user_id === $user_id) { ?>
                <div class="w-100 justify-content-end">
                  <a href="../work/edit.php?id=<?php echo $work['id']; ?>" class="btn btn-info btn-sm">編集する</a>
                  <a href="../work/destroy.php?id=<?php echo $work['id']; ?>" onClick="return confirm('削除してもよろしいですか？');" class="btn btn-danger btn-sm">削除する</a>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <?php // Danger zone ?>
  <div class="py-3">
    <a href="destroy.php" onClick="return confirm('ユーザー情報を復元することはできません。本当に退会しますか？');" class="btn btn-danger px-4">
      退会する
    </a>
  </div>
</div>
<?php include('../partial/bottom_layout.php'); ?>
