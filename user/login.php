<?php
session_start();

require_once('../common.php');

$title = 'ログイン';
$path = '../';
?>
<?php $path='../'; include('../partial/top_layout.php'); ?>
<div class="container-fluid login-body">
  <h1>FMS Works Published Service</h1>
  <p>FMSの学生のための作品公開用SNSです。</p>
  <p>自分の作品を見てもらい、みんなで創作意欲を高めていきましょう！</p>
  <a href="login_request.php">
    <button type="button" class="btn btn-info btn-raised">
      Twitterで新規登録/ログイン
    </button>
  </a>
</div>
<?php include('../partial/bottom_layout.php'); ?>
