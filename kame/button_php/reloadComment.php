<?php
// 作品ページのコメントリロード
// ajaxButton.jsからのajax

require_once("../common.php");

$work_id = !empty($_GET["work_id"]) ? h($_GET["work_id"]) : null;

//commentsから$work_idのコメントをとってくる
try {
    $sql = $pdo->prepare(
        "SELECT * FROM comments WHERE work_id=?"
        );
    $sql->execute( array($work_id) );
    $comments = $sql->fetch();
} catch (PDOException $e) {
    echo $e;
    exit();
}

// //テスト用配列
// $sql = array(
//     array(
//         'id' => 134,
//         'content' => "kkek",
//         'user_id' => 4134,
//         'work_id' => $work_id,
//         'created_at' => 1234566
//     ),
//     array(
//         'id' => 532,
//         'content' => "ddk",
//         'user_id' => 5121,
//         'work_id' => $work_id,
//         'created_at' => 9876543
//     )
// );

$comments = array();

// while($row = $sql->fetch(PDO::FETCH_ASSOC)){
foreach($sql as $row) {
    array_push(
        $comments,
        array(
            'id' => $row['id'],
            'content' => $row['content'],
            'user_id' => $row['user_id'],
            'work_id' => $row['work_id'],
            'created_at' => $row['created_at']
        )
    );
}

header('Content_type: application/json');
echo json_encode($comments);
exit();
?>