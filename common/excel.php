<?php
include("mysql.class.php");
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Dateiname.csv");
$sql = new mysql();
echo $sql->csv();
$sql->close_connect();
?>