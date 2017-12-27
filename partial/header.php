<?php
if (empty($path)) $path = '';
?>
<nav class="navbar navbar-expand-lg bg-white">
  <a href="<?php echo $path; ?>index.php" class="navbar-brand">
    <h3 class="title-color">FMS Works Published Service</h3>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
    <div class="navbar-nav">
      <?php if (!empty($_SESSION['current_user_id'])) { ?>
        <div class="nav-item">
          <a class="nav-link text-dark" style="height: 100%;" href="<?php echo $path; ?>work/new.php">投稿する</a>
        </div>
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php // TODO: 自分のアバターを表示する ?>
            <img class="nav-avatar" src="assets/images/barbie.jpg"></img>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="<?php echo $path; ?>user/show.php">マイページ</a>
            <a class="dropdown-item" href="<?php echo $path; ?>user/logout.php">ログアウト</a>
          </div>
        </div>
      <?php } else { ?>
        <div class="nav-item">
          <a class="nav-link" href="<?php echo $path; ?>user/login.php">ログインする</a>
        </div>
      <?php } ?>
    </div>
  </div>
</nav>
