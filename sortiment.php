<?php
include "./auth/session.php";
include "./classes/mysql.class.php";
include "./common/head.html";

echo'
<h3>Sortiment</h3>
';
$sql = new mysql();
$sql->login("Simon","qwertz");
$sql->winelist();
$sql->close_connect();
		  
include "./common/navigationFooter.php";
?>