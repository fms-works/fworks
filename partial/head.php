<?php
if (empty($path))  $path  = '';
// TODO: 共通のタイトルを決める
if (empty($title)) $title = 'タイトル';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <!-- tamplate -->
  <!-- <link rel="stylesheet" href="<?php echo $path; ?>assets/css/template.min.css"> -->
  <link rel="stylesheet" href="<?php echo $path; ?>assets/css/style.css">
  <title><?php echo $title; ?></title>
</head>
