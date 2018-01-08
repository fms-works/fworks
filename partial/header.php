<?php if (empty($path)) $path = ''; ?>
<nav class="navbar navbar-expand-lg navbar-light bg-white header-border sticky-top">
  <a href="<?php echo $path; ?>index.php" class="navbar-brand">
    <h3 class="title-color">FWorks</h3>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse flex-row-reverse" id="navbarSupportedContent">
    <div class="navbar-nav">
      <?php if (!empty($_SESSION['current_user_id'])): ?>
        <div class="nav-item">
          <a class="nav-link text-dark d-inline align-middle" href="<?php echo $path; ?>work/new.php">投稿する</a>
        </div>
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="nav-avatar align-top lazy" src="<?php echo $path; ?>assets/images/no_image.png" data-src="<?php echo $user_data['avatar']; ?>">
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item text-dark" href="<?php echo $path; ?>user/show.php">マイページ</a>
            <a class="dropdown-item text-dark" href="<?php echo $path; ?>user/likes.php">いいねした作品</a>
            <a class="dropdown-item text-secondary" href="<?php echo $path; ?>user/logout.php">ログアウト</a>
          </div>
        </div>
      <?php else: ?>
        <div class="nav-item">
          <a class="nav-link text-dark d-inline align-middle" href="<?php echo $path; ?>user/login.php">ログインする</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>
