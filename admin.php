<?php
include "./auth/session.php";
include "./classes/mysql.class.php";
include "./common/head.html";

echo'
	<p>
	<h3>Weinliste</h3>
';
$sql = new mysql();
$sql->login("Simon","qwertz");
$sql->winetable();
$sql->close_connect();
echo '
</p>';

echo'
	<p>
	<h3>Nachricht Schreiben</h3>
	<form>
		<input type="text" id="nachricht" name="message"/> <br />
		<input type="reset" value="Abschicken" onclick="postMessage()" />
	</form>
	</p>';
		  
include "./common/navigationFooter.php";
?>