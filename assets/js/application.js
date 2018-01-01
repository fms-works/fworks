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
$("#postComment").on("click", function(e) {
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
      <div class="card-header py-1">
        <img class="work-avatar" src="${data.user_avatar}">
        <p class="work-username text-dark d-inline align-middle">${data.username}</p>
      </div>
      <div class="card-body py-2">
        ${data.content}
      </div>
    </div>
  `;
  $('#comments').append(commentElement);
}

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
