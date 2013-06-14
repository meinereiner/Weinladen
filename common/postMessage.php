<?php
	include "../classes/mysql.class.php";
	
	$message = $_GET['nachricht'];
	$sql = new mysql();
	$sql->addnote($message);
	$sql->close_connect();
?>