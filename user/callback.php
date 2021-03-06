<?php
session_start();
require_once('../common.php');

// twitteroauthを利用
require_once('../twitteroauth-0.7.4/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

// トークンをセット
$request_token = array();
$request_token['oauth_token']        = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

// トークンが一致するか確認
if (isset($_REQUEST['oauth_token']) &&
  $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
  die('Error');
}

// インスタンス化
$connection = new TwitterOAuth(
  CONSUMER_KEY, CONSUMER_SECRET,
  $request_token['oauth_token'],
  $request_token['oauth_token_secret']
);

// アクセストークンを利用
$access_token = $connection->oauth(
  'oauth/access_token',
  array('oauth_verifier' => $_REQUEST['oauth_verifier'])
);

// ユーザー情報取得用のインスタンス作成
$new_connection = new TwitterOAuth(
  CONSUMER_KEY, CONSUMER_SECRET,
  $access_token['oauth_token'],
  $access_token['oauth_token_secret']
);

// ユーザー情報取得
$user = $new_connection->get('account/verify_credentials', array());
$screen_name  = $user->screen_name;
$name         = $user->name;
$token        = $access_token['oauth_token'];
$token_secret = $access_token['oauth_token_secret'];
$avatar       = $user->profile_image_url_https;

// ユーザー一覧取得
$users = $pdo->query('SELECT * FROM users')->fetchAll();

$selected_user = null;
foreach($users as $user) {
  // 登録されているユーザーなら、ログインする
  if ($user['token'] === $token) {
    $selected_user = $user;
    // アバターをアップデート
    try {
      $sql = $pdo->prepare(
      "UPDATE users SET avatar=?
        WHERE id=?"
      );
      $sql->execute(array($avatar, $user['id']));
    } catch (PDOException $e) {
      echo 'MySQL connection failed: ' . $e->getMessage();;
      exit();
    }
    $_SESSION['current_user_id'] = $selected_user['id'];
    break;
  }
}

// 登録されていないユーザーなら登録してログインする
if ($selected_user === null) {
  $date = date("Y-m-d H:i:s");
  try {
    $sql = $pdo->prepare(
    "INSERT INTO users
        (token, token_secret, screen_name, name, avatar, created_at)
      VALUES
        (?, ?, ?, ?, ?, ?)"
    );
    $sql->execute(
      array($token, $token_secret, $screen_name, $name, $avatar, $date)
    );
  } catch (PDOException $e) {
    echo 'MySQL connection failed: ' . $e->getMessage();
    exit();
  }
  $_SESSION['current_user_id'] = $pdo->lastInsertId('id');
}

// セッションを作成
session_regenerate_id();

header('Location: ../index.php');
?>
