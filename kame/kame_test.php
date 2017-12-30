<?php
    //$user_id = $_SESSION["user_id"]:
    //$work_id = $_GET["work_id"];

    //テスト用変数宣言
    $user_id = "321";
    $work_id = "24";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Button Sample</title>
</head>
<body>
    <input type="text" id="inputComment"></input>
    <button id="postComment">post comment</button>

    <button id="reloadComment">reload comment</button>
    <br/>
    <span id="result"></span>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" id="ajaxButton" src="./assets/js/ajaxButton.js"
        data-userid='<?php echo json_encode($user_id); ?>'
        data-workid='<?php echo json_encode($work_id); ?>'
    ></script>
</body>
</html>