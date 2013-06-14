<?php
	include "./auth/session.php";
	include "../classes/mysql.class.php";
	
	$message = $_GET['nachricht'];
	$sql = new mysql();
	$sql->invertnewsletter($_SESSION['username']);
	$sql->close_connect();
?>