/*
 * 画像の遅延ロード
 */
$(function(){
  $('img.lazy').lazyload();
});

/*
 * 画像プレビュー機能
 */
$('.workImageInput').on('change', function() {
  const selectedFile = this.files[0];
  const fileReader = new FileReader();
  // 画像の出力先
  const $output = $(this).parent().find('.workImageOutput');

  fileReader.onload = function(e) {
    const loadedImage = e.target.result;
    $output.css('background-image', `url(${loadedImage})`);
  };
  fileReader.readAsDataURL(selectedFile);
});

/*
 * コメント機能
 */
// コメント投
$("#postComment").on("click", function() {
  // コメント入力欄
  const $commentInput = $("#commentInput");
  $work_id = $(this).data('workid');
  $content = $commentInput.val();
  // ボタンを有効化
  $(this).prop("disabled", false);
  // 値が足りなければ実行しない
  if ($work_id === '' || $content === '') return false;

  // コメント作成リクエスト送信
  $.ajax({
    type: 'POST',
    url: './comment/create.php',
    data: {
      work_id: $work_id,
      content: $content
    }
  }).done(function(data) {
    if (data.user_avatar && data.username && data.content) {
      // 入力欄を空にする
      $commentInput.val('');
      appendComment(data);
    }
  });
  return false;
});

// コメントを挿入する関数
function appendComment(data) {
  const commentElement = `
    <div class="card my-2">
      <div class="card-header py-1 d-flex justify-content-between">
        <div>
          <a class="comment-header" href="../user/show.php?id=${data.user_id}">
            <img class="work-avatar" src="${data.user_avatar}">
            <p class="work-username text-dark d-inline align-middle">${data.username}</p>
          </a>
        </div>
        <div>
          <button class="btn btn-sm btn-outline-danger mx-0 px-2 py-0" id="destroyComment" data-commentid=${data.comment_id}>
            削除
          </button>
        </div>
      </div>
      <div class="card-body py-2">
        ${data.content}
      </div>
    </div>
  `;
  $(commentElement).appendTo($('#comments')).hide().fadeIn(1000);
}

// コメント削除
$(document).on("click", "#destroyComment", function() {
  // コメントIDを取得
  $comment_tag = $(this);
  $comment_id = $comment_tag.data('commentid');
  // ボタンを有効化
  $(this).prop("disabled", false);
  // コメントIDが指定されていなければ実行しない
  if ($comment_id === '') return false;

  // コメント削除リクエスト送信
  $.ajax({
    type: 'POST',
    url: './comment/destroy.php',
    data: { comment_id: $comment_id }
  }).done(function(data) {
    if (data === 'destroy success') {
      $comment_tag
        .parent().parent().parent()
        .fadeOut(1000).queue(function() {
        this.remove();
      });
    }
  });
  return false;
});

/*
 * いいね関連機能
 */
// いいね
$(document).on('click', '#like', function() {
  const $work_id = $(this).data('workid');

  // いいね登録リクエスト送信
  $.ajax({
    type: 'POST',
    url: './like/create.php',
    data: { work_id : $work_id }
  }).done(function(data) {
    if (data === 'like success') {
      changeLikeIcon('heart.png', 'unlike');
      // いいね数を増やす
      $likesCountElement = $('#likesCount');
      $count = Number($likesCountElement.text()) + 1;
      $likesCountElement.text($count);
    }
  });
  return false;
});

// いいね取り消し
$(document).on('click', '#unlike', function() {
  const $work_id = $(this).data('workid');

  // いいね取り消しリクエスト送信
  $.ajax({
    type: 'POST',
    url: './like/destroy.php',
    data: { work_id: $work_id }
  }).done(function(data) {
    if (data === 'unlike success') {
      changeLikeIcon('noheart.svg', 'like');
      // いいね数を減らす
      $likesCountElement = $('#likesCount');
      $count = Number($likesCountElement.text()) - 1;
      $likesCountElement.text($count);
    }
  });
  return false;
});

// いいねアイコンを変更する関数
function changeLikeIcon(name, id) {
  const $heart = $('img.work-heart');
  $heart.attr('id', id);
  $heart.attr('src', `../assets/images/${name}`);
}
