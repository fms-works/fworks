<?php
session_start();

require_once('../common.php');

$path = '../';
$title = '作品投稿';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: ../user/login.php');
  exit();
}
?>
<?php include('../partial/top_layout.php'); ?>
<div class="container">
  <h1 class="py-3 my-4 page-title">作品を投稿する</h1>
  <form method="post" action="post.php" enctype="multipart/form-data"></form>
    <div class="form-group py-2">
      <label for="title">タイトル <span class="note">*必須</span></label>
      <input type="text" name="title" id="title" class="form-control" aria-describedby="titleHelp" placeholder="例) FMS Works">
      <small id="titleHelp" class="form-text text-muted">作品の魅力が伝わるようなタイトルをつけましょう！</small>
    </div>
    <div class="form-group py-2 main_image">
      <h3>メイン画像 <span class="note">*必須</span></h3>
      <input id="workImageInputMain" class="workImageInput" type="file" name="main_image" accept="image/jpg">
      <label for="workImageInputMain" class="workImageOutput" aline="center" aria-describedby="mainImageHelp"></label>
      <small id="mainImageHelp" class="form-text text-muted">いい感じの写真をつけましょう！</small>
    </div>
    <div class="form-group py-2 sub_images">
      <h3>サブ画像</h3>
      <div class="mr-2 sub_image">
        <input id="workImageInputSub1" class="workImageInput" type="file" name="sub_image1" accept="image/jpg">
        <label for="workImageInputSub1" class="workImageOutput" aline="center"></label>
      </div>
      <div class="mr-2 sub_image">
        <input id="workImageInputSub2" class="workImageInput" type="file" name="sub_image2" accept="image/jpg">
        <label for="workImageInputSub2" class="workImageOutput" aline="center"></label>
      </div>
      <div class="mr-2 sub_image">
        <input id="workImageInputSub3" class="workImageInput" type="file" name="sub_image3" accept="image/jpg">
        <label for="workImageInputSub3" class="workImageOutput" aline="center"></label>
      </div>
      <small id="subImageHelp" class="form-text text-muted">写真が多いほうが魅力的です！</small>
    </div>
    <div class="form-group py-2">
      <label for="github-link">Githubリポジトリ</label>
      <input type="text" name="github-link" id="link" class="form-control" aria-describedby="githubHelp" placeholder="例) https://github.com/user/repository">
      <small id="githubHelp" class="form-text text-muted">自分の作品はどんどんGithubで全世界の人に公開しましょう！ → <a href="https://github.com" class="text-muted">https://github.com</a></small>
    </div>
    <div class="form-group py-2">
      <label for="openprocessing-link">OpenProcessingのリンク</label>
      <input type="text" name="openprocessing-link" id="link" class="form-control" placeholder="例) https://www.openprocessing.org/sketch/000000">
      <small id="githubHelp" class="form-text text-muted">OpenProcessingを使うと、processingの作品をWeb上で動かして公開することができます！ → <a href="https://www.openprocessing.org/sketch/110105" class="text-muted">https://www.openprocessing.org/sketch/110105</a></small>
    </div>
    <div class="form-group py-2">
      <label for="link">リンク</label>
      <input type="text" name="link" id="link" class="form-control" placeholder="例) https://www.abcdef.com">
      <small id="githubHelp" class="form-text text-muted">Webサービスとして公開してみましょう！</small>
    </div>
    <div class="form-group py-2">
      <label for="detail">詳細 <span class="note">*必須</span></label>
      <textarea name="detail" id="detail" class="form-control" rows="5" placeholder="例) これはFMSの学生が自分の作品を自由に投稿してコメントし合えるSNSです。概要は..."></textarea>
      <small id="detailbHelp" class="form-text text-muted">この作品がどんなものなのか、どういうところにこだわったのか説明しましょう！</small>
    </div>
    <button type="submit" class="btn btn-primary px-4 mb-5">投稿する</button>
  </form>
</div>
<?php include('../partial/bottom_layout.php'); ?>
