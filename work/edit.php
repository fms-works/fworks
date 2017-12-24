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

// 編集する作品のIDを取得
$work_id = !empty($_GET['id']) ? h($_GET['id']) : 0;

// 作品を取得
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

// 指定されたIDの作品が存在しない or 指定された作品が自分のではない場合リダイレクトする
if (empty($work) || $work['user_id'] !== $current_user_id) {
  header('Location: ../index.php');
  exit();
}

// 作品の画像を取得
try {
  $sql = $pdo->prepare("
    SELECT *
    FROM work_images
    WHERE work_id=?
  ");
  $sql->execute(array($work_id));
  $work_images = $sql->fetchAll();
} catch (PDOException $e) {
  echo $e;
  exit();
}

// メイン画像とサブ画像を分類
$main_image = '';
$sub_images = [];
foreach($work_images as $image) {
  if ($image['main'] === '1') {
    $main_image = $image;
  } else {
    array_push($sub_images, $image);
  }
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
  <title>作品編集</title>
</head>
<body>
  <header>
    <a href="../index.php">メインページ</a>
    <?php if (!empty($_SESSION['current_user_id'])) { ?>
      <a href="../user/logout.php">ログアウトする</a>
    <?php } ?>
    <a href="../user/show.php">プロフィール</a>
  </header>

  <div class="container">
    <form method="post" action="update.php" enctype="multipart/form-data">
      <input type="hidden" name="work_id" value="<?php echo $work_id; ?>">
      <div>
        <label for="title">タイトル</label>
        <input type="text" name="title" id="title" value="
          <?php echo $work['title']; ?>
         ">
        <?php if($_SESSION['empty_title']) { ?>
          <p>タイトルを入力してください</p>
        <?php } ?>
      </div>
      <div class="main_image">
        <h2>メイン</h2>
        <input id="workImageInputMain" class="workImageInput" type="file" name="main_image" accept="image/jpg">
        <?php // TODO: 画像を表示 ?>
        <label for="workImageInputMain" class="workImageOutput" aline="center" style="
          background-image: <?php echo $main_image; ?>
        "></label>
      </div>
      <div>
        <h2>サブ</h2>
        <div class="sub_image">
          <input id="workImageInputSub1" class="workImageInput" type="file" name="sub_image1" accept="image/jpg">
          <?php // TODO: 画像を表示 ?>
          <label for="workImageInputSub1" class="workImageOutput" aline="center" style="
            background-image: <?php echo $sub_images[0]; ?>
          "></label>
        </div>
        <div class="sub_image">
          <input id="workImageInputSub2" class="workImageInput" type="file" name="sub_image2" accept="image/jpg">
          <?php // TODO: 画像を表示 ?>
          <label for="workImageInputSub2" class="workImageOutput" aline="center" style="
            background-image: <?php echo $sub_images[1]; ?>
          "></label>
        </div>
        <div class="sub_image">
          <input id="workImageInputSub3" class="workImageInput" type="file" name="sub_image3" accept="image/jpg">
          <?php // TODO: 画像を表示 ?>
          <label for="workImageInputSub3" class="workImageOutput" aline="center" style="
            background-image: <?php echo $sub_images[2]; ?>
          "></label>
        </div>
      </div>
      <div>
        <label for="link">リンク</label>
        <input type="text" name="link" id="link" value="
          <?php echo $work['link']; ?>
         ">
      </div>
      <div>
        <label for="detail">詳細</label>
        <textarea name="detail" id="detail" row="20" col="10">
          <?php echo $work['detail']; ?>
        </textarea>
        <?php if($_SESSION['empty_detail']) { ?>
          <p>詳細を入力してください</p>
        <?php } ?>
      </div>
      <input type="submit" value="更新する">
    </form>
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
