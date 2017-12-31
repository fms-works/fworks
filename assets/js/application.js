// preview image
$('.workImageInput').on('change', function() {
  var selectedFile = this.files[0];
  var fileReader = new FileReader();
  var $output = $(this).parent().find('.workImageOutput');

  fileReader.onload = function(e) {
    var loadedImage = e.target.result;
    $output.css(
      'background-image', 'url(' + loadedImage + ')'
    );
  };
  fileReader.readAsDataURL(selectedFile);
});

function appendComment(data) {
  let commentElement = `
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

// コメント投稿
$("#postComment").on("click", function(e) {
  let $commentInput = $("#commentInput");
  $work_id = $(this).data('workid');
  $content = $commentInput.val();
  $(this).prop("disabled", false);
  if ($work_id === '' || $content === '') {
    return false;
  }

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

function changeLikeIcon(name, id) {
  let $heart = $('img.work-heart');
  $heart.attr('id', id);
  $heart.attr(
    'src', `../assets/images/${name}`
  );
}

// いいね
$(document).on('click', '#like', function() {
  let $work_id = $(this).data('workid');
  $.ajax({
    type: 'POST',
    url: './like/create.php',
    data: { work_id : $work_id }
  }).done(function(data) {
    if (data === 'like success') {
      changeLikeIcon('heart.png', 'unlike');
      $likesCountElement = $('#likesCount');
      $count = Number($likesCountElement.text()) + 1;
      $likesCountElement.text($count);
    }
  });
  return false;
});

// いいね取り消し
$(document).on('click', '#unlike', function() {
  let $work_id = $(this).data('workid');
  $.ajax({
    type: 'POST',
    url: './like/destroy.php',
    data: { work_id: $work_id }
  }).done(function(data) {
    if (data === 'unlike success') {
      changeLikeIcon('noheart.svg', 'like');
      $likesCountElement = $('#likesCount');
      $count = Number($likesCountElement.text()) - 1;
      $likesCountElement.text($count);
    }
  });
  return false;
});
