<?php
session_start();
$_SESSION['warenkorb'] = [];
$hostname = $_SERVER['HTTP_HOST'];
$path = dirname(dirname($_SERVER['PHP_SELF']));
header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/home.php');
exit;
?>