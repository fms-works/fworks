<?php
session_start();

require_once '../common.php';
require_once '../twitteroauth-0.7.4/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

// トークンをセット
$request_token = [];
$request_token['oauth_token']        = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

// トークンが一致するか確認
if (isset($_REQUEST['oauth_token']) &&
  $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
  die('Error');
}

// インスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY,
                               CONSUMER_SECRET,
                               $request_token['oauth_token'],
                               $request_token['oauth_token_secret']);

// アクセストークンを利用
$_SESSION['access_token'] = $connection->oauth(
  'oauth/access_token',
  array('oauth_verifier' => $_REQUEST['oauth_verifier']));

// セッションを作成
session_regenerate_id();

header('Location: ../index.php');
?>
