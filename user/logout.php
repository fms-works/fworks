<?php
session_start();

require_once '../common.php';

session_destroy();

header('Location: ../index.php')
?>
