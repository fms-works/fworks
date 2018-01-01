<?php
// .envから定数を読み込む
$config_variables = file(__DIR__ . '/.env');
define('ENV_REGEXP', '/^(.+)=\'(.*)\'$/');
foreach ($config_variables as $config) {
  $data = preg_match(ENV_REGEXP, $config, $matches);
  define($matches[1], $matches[2]);
}

// TODO: 本番サーバー用のOAuth登録をする

// 式展開用関数
$_ = function($s){return $s;};

// PDO定義
try {
  $pdo = new PDO(
    "mysql:host={$_(DB_HOST)};dbname={$_(DB_NAME)};{$_(MYSQL_SOCKET)}charset=utf8",
    MYSQL_USER, MYSQL_PASSWORD,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
  );
} catch (PDOException $e) {
  echo 'MySQL connection failed: ' . $e->getMessage();
}
// デフォルトのタイムゾーンを設定する
date_default_timezone_set('Asia/Tokyo');
// XSS対策
function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
// ユーザー取得
function get_user_data($pdo, $user_id) {
  // 現在のユーザーを取得
  try {
    $sql = $pdo->prepare(
      "SELECT * FROM users WHERE id=?"
    );
    $sql->execute(array($user_id));
    $user_data = $sql->fetch();
  } catch (PDOException $e) {
    echo 'MySQL connection failed: ' . $e->getMessage();
    exit();
  }
  return $user_data;
}
?>
