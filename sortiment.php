<?php
include "./auth/session.php";
include "./classes/mysql.class.php";
include "./common/head.html";

echo'
<h3>Sortiment</h3>
';
$sql = new mysql();
$sql->winelist();
echo "
<div id='excel'>
<h3>Weinliste als Excel Tabelle</h3>
<p>
<a href='./common/excel.php' target='_self'><img src='./images/excel.png' width='80' height='80' border='0' alt='excel'></a>
</p>
</div>";
$sql->close_connect();
		  
include "./common/navigationFooter.php";
?>