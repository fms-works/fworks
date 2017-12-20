<?php
session_start();

require_once 'common.php';
require_once 'twitteroauth-0.7.4/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

// access_tokenが存在しない場合、ログイン画面に遷移
if (empty($_SESSION['access_token'])) {
  header('Location: user/login.php');
  exit();
}
// access_tokenをセットする
$access_token = $_SESSION['access_token'];

$connection = new TwitterOAuth(
  CONSUMER_KEY,
  CONSUMER_SECRET,
  $access_token['oauth_token'],
  $access_token['oauth_token_secret']);

// stdClass型でuserオブジェクトを管理する
$user = $connection->get('account/verify_credentials');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>nkmr</title>
</head>
<body>
  <header></header>

  <div class="container">
    <?php if (!empty($_SESSION['access_token'])) { ?>
      <a href="user/logout.php">ログアウトする</a>
    <?php } ?>
  </div>

  <footer></footer>
</body>
</html>
<?php $mysqli->close(); ?>
