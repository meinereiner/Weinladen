<?php
include "./auth/session.php";
include "./classes/mysql.class.php";
include "./common/head.html";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST['check_list']))
	{
		$_SESSION['warenkorb'] = $_POST['check_list'];
	}
}
$sql = new mysql();
$sql->login("Simon","qwertz");
if(!empty($_SESSION['warenkorb'])) 
{
	echo '<form action="common/bestellungAbschicken.php" method="post">'; 
	$sql->winelistbyname($_SESSION['warenkorb']);
	echo '<input id="Bestellbutton" type="submit" value="Bestellung abschicken" />';
	echo "</form>";
	echo '<form action="common/warenkorbLeeren.php" method="post">';
	echo '<input id="leerenButton" type="submit" value="Warenkorb leeren" />';
	echo "</form>";
}
else echo '<p>Warenkorb ist leer.</p>';
$sql->close_connect();

include "./common/navigationFooter.php";
?>