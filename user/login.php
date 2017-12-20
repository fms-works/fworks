<?php
session_start();

require_once '../common.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ログイン</title>
</head>
<body>
  <header></header>

  <div class="container">
    <a href="login_request.php">
      Twitterで認証する
    </a>
  </div>

  <footer></footer>
</body>
</html>
<?php $mysqli->close(); ?>
