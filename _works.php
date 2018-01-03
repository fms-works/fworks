<h4 class="py-0 mt-3 page-title">全ての投稿</h4>
<div class="row">
  <?php foreach($works as $work): ?>
    <div class="px-1 py-3 col-xs-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card card-shadow pb-1">
        <a class="card-link" href="work/show.php?id=<?php echo $work['id']; ?>">
          <img class="card-img-top lazy" src="assets/images/no_image.png" data-src="data:image/png;base64,<?php echo $work['first_work_image']; ?>" alt="work image">
        </a>
        <div class="card-body pb-0">
          <h4 class="card-title text-dark"><?php echo $work['title']; ?></h4>
          <p class="card-detail text-secondary"><?php echo $work['detail']; ?></p>
          <div class="d-flex justify-content-between pt-4">
            <a class="card-user-link" href="user/show.php?id=<?php echo $work['user_id']; ?>">
              <img class="work-avatar lazy" src="assets/images/no_image.png" data-src="<?php echo $work['user_avatar']; ?>">
              <p class="work-username text-secondary"><?php echo $work['user_name']; ?></p>
            </a>
            <div>
              <img class="card-comment" src="assets/images/comment.svg">
              <span class="text-secondary mr-1"><?php echo $work['comments_count']; ?></span>
              <img class="card-heart" src="assets/images/heart.png">
              <span class="text-danger"><?php echo $work['likes_count']; ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php include('work/_pagination.php'); ?>
