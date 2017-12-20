<?php
session_start();

require_once '../common.php';

// user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['user_id'])) {
  header('Location: ../user/login.php');
  exit();
}


// $picture=file_get_contents($_FILES["picture"]["tmp_name"]);
// $title=h($_POST["title"]);
// $development=h($_POST["development"]);
// $day=h($_POST["day"]);
// $comment=h($_POST["comment"]);

// if(isset($_POST["toukou"])){
//   $mysqli->query("INSERT INTO work(picture,title,development,day,comment) VALUES('".$picture."','".$title."','".$development."','".$day."','".$comment."')");
// }


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link href="../assets/css/style.css" rel="stylesheet">
  <title>投稿</title>
</head>
<body>
  <header>
    <a href="../index.php">メインページ</a>
    <?php if (!empty($_SESSION['user_id'])) { ?>
      <a href="../user/logout.php">ログアウトする</a>
    <?php } ?>
    <a href="../user/profile.php">プロフィール</a>
  </header>

  <div class="container">
    <form method="post" action="post.php" enctype="multipart/form-data">
      <div class="main_image">
        <input id="workImageInputMain" class="workImageInput" type="file" name="main_image" accept="image/jpg">
        <label for="workImageInputMain" class="workImageOutput" aline="center"></label>
      </div>
      <div>
        <div class="sub_image">
          <input id="workImageInputSub1" class="workImageInput" type="file" name="sub_image_1" accept="image/jpg">
          <label for="workImageInputSub1" class="workImageOutput" aline="center"></label>
        </div>
        <div class="sub_image">
          <input id="workImageInputSub2" class="workImageInput" type="file" name="sub_image_2" accept="image/jpg">
          <label for="workImageInputSub2" class="workImageOutput" aline="center"></label>
        </div>
        <div class="sub_image">
          <input id="workImageInputSub3" class="workImageInput" type="file" name="sub_image_3" accept="image/jpg">
          <label for="workImageInputSub3" class="workImageOutput" aline="center"></label>
        </div>
      </div>
      <div>
        <label for="title">タイトル</label>
        <input type="text" name="title" rows="1">
      </div>
      <div class="development">
        <label for="development">開発環境</label>
        <input type="text" name="place" rows="1">
      </li>
      <div>
        <label for="day">日付</label>
        <input type="date" name="day">
      </div>
      <div>
        <label for="comment">コメント</label>
        <textarea name="comment"></textarea>
      </div>

      <input type="submit" value="投稿する">
    </form>
  </div>

  <footer></footer>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <!-- bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <script src="../assets/js/application.js"></script>
</body>
</html>
