<?php include('_pagination.php'); ?>
<div class="row">
  <?php foreach($works as $work): ?>
    <div class="px-1 py-3 col-xs-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card card-shadow">
        <a class="card-link" href="../../work/show.php?id=<?php echo $work['id']; ?>">
          <img class="card-img-top lazy" src="../../assets/images/no_image.png" data-src="data:image/png;base64,<?php echo $work['first_work_image']; ?>" alt="work image">
        </a>
        <div class="card-body">
          <h4 class="card-title"><?php echo $work['title']; ?></h4>
          <p class="card-detail"><?php echo $work['detail']; ?></p>
          <p><?php echo $work['likes_count']; ?>いいね</p>
          <a class="card-user-link" href="../../user/show.php?id=<?php echo $work['user_id']; ?>">
            <img class="work-avatar lazy" src="../../assets/images/no_image.png" data-src="<?php echo $work['user_avatar']; ?>">
            <p class="work-username text-dark"><?php echo $work['user_name']; ?></p>
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php include('_pagination.php'); ?>
