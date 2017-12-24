<?php
if (empty($path)) $path = '';
?>
<nav class="navbar navbar-expand-lg justify-content-between">
  <a href="<?php echo $path; ?>index.php" class="navbar-brand">FMS Works Published Service</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <?php if (!empty($_SESSION['current_user_id'])) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $path; ?>work/new.php">投稿する</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <!-- <?php // TODO: 自分のアバターを表示する ?>
            <div class="nav-avatar" style="background-image: url(assets/images/barbie.jpg)"></div> -->アバター
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="<?php echo $path; ?>user/show.php">マイページ</a>
            <a class="dropdown-item" href="<?php echo $path; ?>user/logout.php">ログアウト</a>
          </div>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $path; ?>user/login.php">ログインする</a>
        </li>
      <?php } ?>
    </ul>
  </div>
</nav>
