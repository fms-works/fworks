<?php
session_start();

require_once '../common.php';
require_once '../twitteroauth-0.7.4/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

// インスタンス化
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
// callbackURLをセット
$request_token = $connection->oauth(
  'oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

// callback.phpで使用する
$_SESSION['oauth_token']        = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

// 認証画面のURLを取得
$url = $connection->url(
  'oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

// 認証画面にリダイレクト
header('Location: ' . $url);
?>
