<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>FMS投稿作品</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- BootstrapのCSS読み込み -->
  <link href="css/main.82cfd66e.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/stylesheet.css" rel="stylesheet">
  <!-- jQuery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- BootstrapのJS読み込み -->
  <script src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="./js/main.85741bff.js"></script>
</head>

<body>
  <header>
    <div class="title">
      <h2>投稿ページ</h2>
    </div>
  </header>
  <form method="POST" action="home.php" enctype="multipart/form-data">
      <ul>
        <li>
          <input id="inputNode" type="file" name="picture" accept="image/jpg">
          <div id="outputWrapper" aline="center" style="width:400px; height:300px"></div>

          <script src="http://code.jquery.com/jquery.min.js"></script>
          <script>
          $( '#outputWrapper' ).html( '<img src="http://design-ec.com/d/e_others_50/l_e_others_500.png" border="1" width="400" height="400">' );
          $( '#inputNode' ).change( function () {
            var selectedFile = this.files[0];
            var fileReader = new FileReader();

            fileReader.onload = function( event ) {
              var loadedImageUri = event.target.result;
              $( '#outputWrapper' ).html( '<img src="' + loadedImageUri + '" border="1" width="400" height="400">' );
            };

            fileReader.readAsDataURL( selectedFile );
          } );
          </script>
        </li><br /><br /><br /><br /><br />
        <li class="title" >
          <label  for="title">タイトル</label>
          <input type="text" name="title" rows="1" />
        </li>
        <li class="development" >
          <label  for="development">開発環境</label>
          <input type="text" name="place" rows="1" />
        </li>
        <li class="day" >
          <label  for="day">日付</label>
          <input type="date" name="day"/>
        </li>
        <li>
          <label for="comment">コメント</label>
          <textarea name="comment"></textarea>
        </li>
      </ul>
    <input type="submit" value="投稿" name="toukou" /><br />
  </form>

  <?php
  function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
  }

  $picture=file_get_contents($_FILES["picture"]["tmp_name"]);
  $title=h($_POST["title"]);
  $development=h($_POST["development"]);
  $day=h($_POST["day"]);
  $comment=h($_POST["comment"]);

  var_dump($picture);
  $mysqli = new mysqli("localhost","nakamura-lab","n1k2m3r4fms");
  $mysqli->select_db("cmp_2017_b_db");
  $mysqli->set_charset("utf8");

  if(isset($_POST["toukou"])){
    $mysqli->query("INSERT INTO work(picture,title,development,day,comment) VALUES('".$picture."','".$title."','".$development."','".$day."','".$comment."')");
  }

  $mysqli->close();

  ?>


</body>
</html>
