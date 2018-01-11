<?php if (empty($path)) $path = ''; ?>
<?php if ($partial_from === 'popular') echo '<div class="col-xs-12 col-sm-6 col-md-4 py-1">'; ?>
<div class="card card-shadow">
  <a class="card-link" href="<?php echo $path; ?>work/show.php?id=<?php echo $work['id']; ?>">
    <img class="card-img-top lazy" src="<?php echo $path; ?>assets/images/no_image.png" data-src="data:image/png;base64,<?php echo $work['first_work_image']; ?>" alt="work image">
  </a>
  <div class="card-body px-2 py-0">
    <h4 class="card-title py-2"><?php echo $work['title']; ?></h4>
    <div class="d-flex justify-content-between pt-2 pb-0">
      <a class="card-user-link" href="<?php echo $path; ?>user/show.php?id=<?php echo $work['user_id']; ?>">
        <img class="work-avatar lazy" src="<?php echo $path; ?>assets/images/no_image.png" data-src="<?php echo $work['user_avatar']; ?>">
        <p class="work-username text-secondary mb-2"><?php echo $work['user_name']; ?></p>
      </a>
      <div class="py-0">
        <img class="card-comment" src="<?php echo $path; ?>assets/images/comment.svg">
        <span class="text-secondary mr-1"><?php echo $work['comments_count']; ?></span>
        <img class="card-heart" src="<?php echo $path; ?>assets/images/heart.png">
        <span class="text-danger"><?php echo $work['likes_count']; ?></span>
      </div>
    </div>
  </div>
  <?php if ($current_user_id === $work['user_id']): ?>
    <div class="card-footer px-2 py-2">
      <div class="w-100 d-flex justify-content-end">
        <a href="<?php echo $path; ?>work/edit.php?id=<?php echo $work['id']; ?>" class="btn btn-outline-success btn-sm mx-1 py-0">編集</a>
        <a href="<?php echo $path; ?>work/destroy.php?id=<?php echo $work['id']; ?>" onClick="return confirm('削除してもよろしいですか？');" class="btn btn-outline-danger btn-sm py-0">削除</a>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php if ($partial_from === 'popular') echo '</div>'; ?>
