<?php
session_start();
require_once('../common.php');

$title = 'ログイン';
$path = '../';
?>
<?php include('../partial/head.php'); ?>
<?php include('../partial/header.php'); ?>
<div class="container-fluid login-body">
  <h1 class="py-5 login-title">FWorks</h1>
  <p class="py-2 text-white">FMSの学生のための作品公開SNSです。</p>
  <p class="py-2 text-white">自分の作品を見てもらい、みんなで創作意欲を高めていきましょう！</p>
  <a href="login_request.php" class="d-block my-5">
    <button type="button" class="btn btn-info btn-raised">
      Twitterで新規登録/ログイン
    </button>
  </a>
<?php include('../partial/bottom_layout.php'); ?>
