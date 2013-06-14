<?php
include "./auth/session.php";
include "./classes/mysql.class.php";

$sql = new mysql();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$sql->invertnewsletter($_SESSION['username']);
}

include "./common/head.html";

echo'
	<p>
';

echo '
</p>';

echo'
	<p>
	<h3>Newsletter</h3>';
	if(isset($_SESSION['administrator']) && $_SESSION['administrator'] == true)
	{
		echo "<h3>Liste aller Newsletterabonennten</h3>";
		$sql->allnewsuser();
	}
	else
	{
		echo '<form method="post" action="newsletter.php">';
		if($sql->getnewsletterstatus($_SESSION['username']))
			echo '<form><input type="submit"  value="Newsletter abbestellen" />';
		else
			echo '<input type="submit"  value="Newsletter bestellen" />';	
		}
		echo '</form>';
echo'</p>';
$sql->close_connect();		  
include "./common/navigationFooter.php";
?>