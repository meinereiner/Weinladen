<?php
include "./auth/session.php";
include "./classes/mysql.class.php";
include "./common/head.html";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	echo'
		<h3>Suche</h3>
		';
	$sql = new mysql();
	$sql->login("Simon","qwertz");
	$sql->winesorted($_POST['typ'], $_POST['land'], $_POST['preis']);
	$sql->close_connect();
	
	echo "</form>";
	}
		  
include "./common/navigationFooter.php";
?>