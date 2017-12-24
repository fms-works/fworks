<?php
session_start();

require_once '../common.php';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ../user/login.php');
  exit();
}

// 現在のユーザーのIDを取得
$current_user_id = $_SESSION['current_user_id'];

// 表示する作品のIDを取得
$work_id = !empty($_GET['id']) ? h($_GET['id']) : 0;
// 作品を取得する
try {
  $sql = $pdo->prepare("
    SELECT * FROM works
    WHERE id=?
  ");
  $sql->execute(array($work_id));
  $work = $sql->fetch();
} catch (PDOException $e) {
  echo $e;
  exit();
}

// 存在しない作品を選択したらメイン画面に戻る
if (empty($work)) {
  header("Location: ../index.php");
  exit();
}

// 作品の画像を取得
try {
  $sql = $pdo->prepare("
    SELECT content
    FROM work_images
    WHERE work_id=?
  ");
  $sql->execute(array($work_id));
  $work_images = $sql->fetch();
} catch (PDOExctption $e) {
  echo $e;
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/template.min.css">
  <link href="../assets/css/style.css" rel="stylesheet">
  <title>作品</title>
</head>
<body>
  <header>
    <a href="../index.php">メインページ</a>
    <?php if (!empty($_SESSION['current_user_id'])) { ?>
      <a href="logout.php">ログアウトする</a>
    <?php } ?>
  </header>

  <div class="container">
    <?php // 作品表示 ?>
    <div>
      <div>
        <?php // 自分の作品を編集する　?>
        <?php if ($current_user_id === $work['user_id']) { ?>
          <a href="../work/edit.php?id=<?php echo $work_id; ?>">編集する</a>
        <?php } ?>
        <p><?php echo $work['title']; ?></p>
        <?php foreach($work_images as $image) { ?>
          <p><?php echo $image; ?></p>
        <?php } ?>
      </div>
    </div>
  </div>

  <footer></footer>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <!-- bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../assets/js/template.min.js"></script>
  <script src="../assets/js/application.js"></script>
</body>
</html>
