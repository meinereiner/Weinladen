<?php
include "./auth/session.php";
include "./classes/mysql.class.php";
include "./common/head.html";

echo'
	<p>
';
$sql = new mysql();

echo '
</p>';

echo'
	<p>
	<h3>Newsletter</h3>';
	if($_SESSION['administrator'] == true)
	{
		echo "<h3>Liste aller Newsletterabonennten</h3>";
		$sql->allnewsuser();
	}
	else
	{
		if($sql->getnewsletterstatus())
			echo '<form><input type="button"  value="Newsletter abbestellen" onclick="window.location.reload();changeNewsletter()" />';
		else
			echo '<input type="button"  value="Newsletter bestellen" onclick="window.location.reload();changeNewsletter()" /></form>';	
		}
echo'</p>';
$sql->close_connect();		  
include "./common/navigationFooter.php";
?>