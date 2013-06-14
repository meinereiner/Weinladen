<?php
include "../auth/session.php";
include "../classes/mysql.class.php";

$sql = new mysql();
$sql->createorder($_SESSION['username'], $_SESSION['warenkorb']); 
$_SESSION['warenkorb'] = [];
$sql->close_connect();

$hostname = $_SERVER['HTTP_HOST'];
$path = dirname(dirname($_SERVER['PHP_SELF']));
header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/home.php');
exit;
?>