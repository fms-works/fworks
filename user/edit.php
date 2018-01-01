<?php
session_start();
require_once('../common.php');

$path = '../';
$title = 'ユーザー編集';

// current_user_idが存在しない(ログインしていない)場合、ログイン画面に遷移
if (empty($_SESSION['current_user_id'])) {
  header('Location: login.php');
  exit();
}

// 現在のユーザーを取得
$current_user_id = $_SESSION['current_user_id'];
$user_data = get_user_data($pdo, $current_user_id);
?>
<?php include('../partial/top_layout.php'); ?>
<?php // ユーザー情報編集フォーム ?>
<h2 class="py-4">ユーザー編集</h2>
<form action="update.php" method="post">
  <div class="form-group py-2">
    <label for="name">ユーザーネーム <span class="note">*必須</span></label>
    <input type="text" id="name" name="name" class="form-control" aria-describedby="nameHelp" required value="<?php echo $user_data['name']; ?>" placeholder="例) 山田太郎">
    <small id="nameHelp" class="form-text text-muted">20文字以内で登録してください</small>
  </div>
  <div class="form-group py-2">
    <label for="github_account">Githubアカウント</label>
    <input type="text" name="github_account" id="github_account" class="form-control" aria-describedby="githubAcountHelp" value="<?php echo $user_data['github_account']; ?>" placeholder="例) abc">
    <small id="githubAcountHelp" class="form-text text-muted">Githunアカウントを登録しましょう！ → <a href="https://github.com" class="text-muted">https://github.com</a></small>
  </div>
  <div class="form-group py-2">
    <label for="profile">プロフィール</label>
    <textarea name="profile" id="profile" class="form-control" row="5" aria-describedby="profileHelp" placeholder="例) FMS B1の山田太郎です。3Dが好きです。よろしくお願いします！"><?php echo $user_data['profile']; ?></textarea>
    <small id="profileHelp" class="form-text text-muted">簡単に自己紹介しましょう！</small>
  </div>
  <div class="d-flex justify-content-start mt-4 mb-5">
    <a href="show.php" class="btn btn-warning text-dark mr-2">キャンセル</a>
    <input type="submit" class="btn btn-info" value="変更する">
  </div>
</form>
<?php include('../partial/bottom_layout.php'); ?>
