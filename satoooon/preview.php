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
        <!-- ファイル入力のためのinput -->
        <input id="inputNode" type="file" name="picture" accept="image/jpg">

        <!-- プレビュー画像を出力するためのdiv -->
        <div id="outputWrapper"></div>

        <!-- ここからデータ取得のスクリプト -->
        <script src="http://code.jquery.com/jquery.min.js">// jQueryの読み込み</script>
        <script>
        $( '#inputNode' ).change( function () { // 入力をフックにデータ取得を実行
          var selectedFile = this.files[0];
          // ここまではFile APIを使わない場合と同じ

          // ↓"FileReader"オブジェクトを生成し変数fileReaderに格納
          var fileReader = new FileReader();

          // ↓fileReaderにファイルが読み込まれた後（ onload ）の動作を定義
          fileReader.onload = function( event ) {
            // ロード時の各種情報はonloadの引数（この場合はevent）に格納される
            // ロードされた画像ファイルのData URIスキームは event.target.result に格納される
            // ↓変数loadedImageUriに格納
            var loadedImageUri = event.target.result;

            // ↓取得した画像ファイルのData URIスキームを元に画像を表示（imgのsrcに指定するだけ！）
            $( '#outputWrapper' ).html( '<img src="' + loadedImageUri + '">' );
          };

          // ↓画像読み込みを実行。"FileReader"の"readAsDataURL"関数を使う
          // 引数はユーザーが入力したファイルのオブジェクト（＝ selectedFile ＝ this.files[0]）
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
        <input type="text" name="day" rows="1" />
      </li>
      <li>
        <label for="comment">コメント</label>
        <textarea name="comment"></textarea>
      </li>
      <li>
        <input type="submit" value="投稿" name="toukou" /><br />
      </li>
    </ul>
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
   $mysqli->query("INSERT INTO work(category,title,place,day,comment,lat,lng,picture) VALUES('".$category."','".$title."','".$place."','".$day."','".$comment."',$lat,$lng,'".$picture."')");
 }

 $mysqli->close();

 ?>


</body>
</html>
