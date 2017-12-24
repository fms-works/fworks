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
  <form method="post" action="post.php" enctype="multipart/form-data">
    <div>
      <label for="title">タイトル</label>
      <input type="text" name="title" id="title">
      <?php if($_SESSION['empty_title']) { ?>
        <p>タイトルを入力してください</p>
      <?php } ?>
    </div>
    <div class="main_image">
      <h2>メイン</h2>
      <input id="workImageInputMain" class="workImageInput" type="file" name="main_image" accept="image/jpg">
      <label for="workImageInputMain" class="workImageOutput" aline="center"></label>
      <?php if($_SESSION['empty_main_image']) { ?>
        <p>メイン画像を登録してください</p>
      <?php } ?>
    </div>
    <div>
      <h2>サブ</h2>
      <div class="sub_image">
        <input id="workImageInputSub1" class="workImageInput" type="file" name="sub_image1" accept="image/jpg">
        <label for="workImageInputSub1" class="workImageOutput" aline="center"></label>
      </div>
      <div class="sub_image">
        <input id="workImageInputSub2" class="workImageInput" type="file" name="sub_image2" accept="image/jpg">
        <label for="workImageInputSub2" class="workImageOutput" aline="center"></label>
      </div>
      <div class="sub_image">
        <input id="workImageInputSub3" class="workImageInput" type="file" name="sub_image3" accept="image/jpg">
        <label for="workImageInputSub3" class="workImageOutput" aline="center"></label>
      </div>
    </div>
    <div>
      <label for="link">リンク</label>
      <input type="text" name="link" id="link">
    </div>
    <div>
      <label for="detail">詳細</label>
      <textarea name="detail" id="detail" row="20" col="10"></textarea>
      <?php if($_SESSION['empty_detail']) { ?>
        <p>詳細を入力してください</p>
      <?php } ?>
    </div>
    <input type="submit" value="投稿する">
  </form>
</div>
<?php include('../partial/bottom_layout.php'); ?>
