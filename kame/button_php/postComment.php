<?php
require_once("../common.php");

// $_GET[]が定義されて入れば変数に格納
$content = !empty($_GET["content"]) ? h($_GET["content"]) : null;
$user_id = !empty($_GET["user_id"]) ? h($_GET['user_id']) : null;
$work_id = !empty($_GET["work_id"]) ? h($_GET['work_id']) : null;

if( empty($content) || empty($user_id) || empty($work_id) ){
    echo "failed, some GET values are empty.";
    exit();
}

$date = date("Y-m-d H:i:s");

// commentsにINSERTする
try {
    $sql = $pdo->prepare(
        "INSERT INTO comments (
            content, user_id, work_id, created_at
        ) VALUES (
            ?, ?, ?, ?
        )"
        );
    $sql->execute( 
        array($content, $user_id, $work_id, $date) 
        );
    echo "success";
    exit();
} catch (PDOException $e) {
    echo $e;
    exit();
}
?>