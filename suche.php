<?php
include "./auth/login_header.php";
include "./common/head.html";
$sql = new mysql();
$sql->login("Simon","qwertz");
echo'
<div id="divSuche">
	<h3>Weinsuche</h3>
	<form action="suchanfrage.php" method="post">
		<select type="text" id="typ" name="typ"/>';
		echo "			<option value=''>Bitte Typ wählen</option>\n";
		$typesarray = $sql->gettypes();
		foreach ($typesarray as $arr) 
		{
			echo"			<option>" . $arr . "</option>\n";
		}
echo'
		</select><br />
		<select type="text" id="land" name="land"/>';
		echo "			<option value=''>Bitte Land wählen</option>\n";
		$typesarray = $sql->getlands();
		foreach ($typesarray as $arr) 
		{
			echo"			<option>" . $arr . "</option>\n";
		}
echo '	</select><br />
		<select type="text" id="preis" name="preis" />
			<option value="">Bitte Preis wählen</option>
			<option value="3">bis 3€</option>
			<option value="5">bis 5€</option>
			<option value="7">bis 7€</option>
			<option value="10">bis 10€</option>
		</select><br />
		<input id="suchButton" type="submit" value="Suchen"/>
	</form>
</div>';
  
$sql->close_connect();  
include "./common/navigationFooter.php";
?>