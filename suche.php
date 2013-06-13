<?php
include "./auth/login_header.php";
include "./common/head.html";

echo'
<div id="divSuche">
	<h3>Weinsuche</h3>
	<form action="suchanfrage.php" method="post">
		<input type="text" id="typ" name="typ"/> Typ <br />
		<input type="text" id="land" name="land"/> Land <br />
		<input type="text" id="preis" name="preis" /> Maximalpreis <br />
		<input id="suchButton" type="submit" value="Suchen"/>
	</form>
</div>';
  
include "./common/navigationFooter.php";
?>