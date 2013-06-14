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
echo "<a href='./common/excel.php' target='_self'><img src='./images/excel.png' width='80' height='80' border='0' alt='excel'></a>";
$sql->close_connect();
		  
include "./common/navigationFooter.php";
?>