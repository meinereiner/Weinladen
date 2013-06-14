<?php
include "./auth/session.php";
include "./classes/mysql.class.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST['warenkorb']))
	{
		$sql = new mysql();
		$sql->login("Simon","qwertz");
		$sql->createorder($_SESSION['username'], $_SESSION['warenkorb']); 
		$_SESSION['warenkorb'] = [];
		$sql->close_connect();
	}
}
$hostname = $_SERVER['HTTP_HOST'];
$path = dirname(dirname($_SERVER['PHP_SELF']));
header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/home.php');
exit;
?>