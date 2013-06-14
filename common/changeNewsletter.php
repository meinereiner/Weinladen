<?php
	include "../classes/mysql.class.php";
	
	$message = $_GET['nachricht'];
	$sql = new mysql();
	$sql->login("Max","Max");
	$sql->invertnewsletter();
	$sql->close_connect();
?>