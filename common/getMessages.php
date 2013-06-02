<?php
	include "../classes/mysql.class.php";
	
	$sql = new mysql();
	$sql->login("Simon","qwertz");
	$sql->newstopten();
	$sql->close_connect();
?>