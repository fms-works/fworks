<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>FMS投稿作品</title>
</head>
<header>

</header>
<body>
  <form method="POST" action="home.php" enctype="multipart/form-data">
    <ul>
      <li>
        <input id="inputNode" type="file" name="picture" accept="image/jpg">
        <div id="outputWrapper" aline="center" style="width:400px; height:300px"></div>
        <script src="http://code.jquery.com/jquery.min.js"></script>
        <script>
        $( '#inputNode' ).change( function () {
          var selectedFile = this.files[0];
          var fileReader = new FileReader();

          fileReader.onload = function( event ) {
            var loadedImageUri = event.target.result;
            $( '#outputWrapper' ).html( '<img src="' + loadedImageUri + '">' );
          };

          fileReader.readAsDataURL( selectedFile );
        } );
        </script>
      </li>
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

 $title=h($_POST["title"]);
 $development=h($_POST["development"]);
 $day=h($_POST["day"]);
 $comment=h($_POST["comment"]);

 var_dump($picture);
 $mysqli = new mysqli("localhost","nakamura-lab","n1k2m3r4fms");
 $mysqli->select_db("cmp_2017_b_db");
 $mysqli->set_charset("utf8");

 if(isset($_POST["sousin0"])){
   $mysqli->query("INSERT INTO work(picture,development,day,comment) VALUES('".$picture."','".$development."','".$day."','".$comment."')");
 }

 $mysqli->close();

 ?>


</body>
</html>
