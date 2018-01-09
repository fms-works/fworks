<?php // タイトル ?>
<div class="form-group py-2">
  <label for="title">タイトル <span class="note">*必須</span></label>
  <input type="text" name="title" id="title" class="form-control" aria-describedby="titleHelp" required placeholder="例) FWorks"
    <?php if(!empty($work['title'])) echo 'value="' . $work['title'] . '"'; ?>>
  <small id="titleHelp" class="form-text text-muted">作品の魅力が伝わるようなタイトルをつけましょう！</small>
</div>
<?php // 詳細 ?>
<div class="form-group py-2">
  <label for="detail">詳細 <span class="note">*必須</span></label>
  <textarea name="detail" id="detail" class="form-control" rows="5" required placeholder="例) これはFMSの学生が自分の作品を自由に投稿してコメントし合えるSNSです。概要は..."><?php if(!empty($work['detail'])) echo h($work['detail']); ?></textarea>
  <small id="detailbHelp" class="form-text text-muted">この作品がどんなものなのか、どういうところにこだわったのか簡単に説明しましょう！</small>
</div>
<?php // タグ ?>
<div class="form-group py-2">
  <label for="tags">タグ</label>
  <div class="row mx-0">
    <input type="text" name="tag1" class="col-xs-12 col-sm-10 col-md-4 form-control" placeholder="例) processing"
      <?php if (!empty($tags[0])) echo 'value="' . $tags[0]['name'] . '"'; ?>>
    <input type="text" name="tag2" class="col-xs-12 col-sm-10 col-md-4 form-control" placeholder="例) music"
      <?php if (!empty($tags[1])) echo 'value="' . $tags[1]['name'] . '"'; ?>>
    <input type="text" name="tag3" class="col-xs-12 col-sm-10 col-md-4 form-control" placeholder="例) 3D"
      <?php if (!empty($tags[2])) echo 'value="' . $tags[2]['name'] . '"'; ?>>
  </div>
  <small id="detailbHelp" class="form-text text-muted">タグを3つまでつけることができます！</small>
</div>
<?php // メイン画像 ?>
<div class="form-group py-2 main_image">
  <h3>メイン画像 <span class="note">*必須</span></h3>
  <input id="workImageInputMain" class="workImageInput" type="file" name="main_image" accept="image/jpg">
  <label for="workImageInputMain" class="workImageOutput" aline="center" aria-describedby="mainImageHelp"
    <?php if (!empty($main_image)) echo "style='background-image: url(data:image/jpg;base64," . $main_image['content'] . ");'"; ?>></label>
  <small id="mainImageHelp" class="form-text text-muted">いい感じの写真をつけましょう！</small>
</div>
<?php // サブ画像 ?>
<div class="form-group py-2 sub_images">
  <h3>サブ画像</h3>
  <div class="mr-2 sub_image">
    <input id="workImageInputSub1" class="workImageInput" type="file" name="sub_image1" accept="image/jpg">
    <label for="workImageInputSub1" class="workImageOutput" aline="center"
      <?php if (!empty($sub_images[0])) echo "style='background-image: url(data:image/jpg;base64," . $sub_images[0]['content'] . ");'"; ?>></label>
  </div>
  <div class="mr-2 sub_image">
    <input id="workImageInputSub2" class="workImageInput" type="file" name="sub_image2" accept="image/jpg">
    <label for="workImageInputSub2" class="workImageOutput" aline="center"
      <?php if (!empty($sub_images[1])) echo "style='background-image: url(data:image/jpg;base64," . $sub_images[1]['content'] . ");'"; ?>></label>
  </div>
  <div class="mr-2 sub_image">
    <input id="workImageInputSub3" class="workImageInput" type="file" name="sub_image3" accept="image/jpg">
    <label for="workImageInputSub3" class="workImageOutput" aline="center"
      <?php if (!empty($sub_images[2])) echo "style='background-image: url(data:image/jpg;base64," . $sub_images[2]['content'] . ");'"; ?>></label>
  </div>
  <small id="subImageHelp" class="form-text text-muted">写真が多いほうが魅力的です！</small>
</div>
<?php // Githubリポジトリ ?>
<div class="form-group py-2">
  <label for="github-link">Githubリポジトリ</label>
  <input type="text" name="glink" id="github-link" class="form-control" aria-describedby="githubHelp" placeholder="例) https://github.com/user/repository"
    <?php if(!empty($work['github_link'])) echo 'value="' . $work['github_link'] . '"'; ?>>
  <small id="githubHelp" class="form-text text-muted">自分の作品はどんどんGithubにあげて公開しましょう！ → <a href="https://github.com" class="text-muted">https://github.com</a></small>
</div>
<?php // OpenProcessingリンク ?>
<div class="form-group py-2">
  <label for="openprocessing-link">OpenProcessingのリンク</label>
  <input type="text" name="oplink" id="openprocessing-link" class="form-control" placeholder="例) https://www.openprocessing.org/sketch/000000"
    <?php if(!empty($work['openprocessing_link'])) echo 'value="' . $work['openprocessing_link'] . '"'; ?>>
  <small id="githubHelp" class="form-text text-muted">OpenProcessingを使うと、processingの作品をWeb上で動かして公開することができます！ → <a href="https://www.openprocessing.org/sketch/110105" class="text-muted">https://www.openprocessing.org/sketch/110105</a></small>
</div>
<?php // YouTubeリンク ?>
<div class="form-group py-2">
  <label for="youtube-link">YouTubeのリンク</label>
  <input type="text" name="ytlink" id="youtube-link" class="form-control" placeholder="例) https://www.youtube.com/embed/xxxxxxx"
    <?php if(!empty($work['youtube_link'])) echo 'value="' . $work['youtube_link'] . '"'; ?>>
  <small id="youtubeHelp" class="form-text text-muted">YouTubeに動画をアップしてみましょう！ → <a href="https://www.youtube.com/?hl=ja&gl=JP" class="text-muted">https://www.youtube.com/?hl=ja&gl=JP</a></small>
</div>
<?php // リンク ?>
<div class="form-group py-2">
  <label for="link">リンク</label>
  <input type="text" name="link" id="link" class="form-control" placeholder="例) https://www.abcdef.com"
    <?php if(!empty($work['link'])) echo 'value="' . $work['link'] . '"'; ?>>
  <small id="githubHelp" class="form-text text-muted">Webサービスとして公開してみましょう！</small>
</div>
