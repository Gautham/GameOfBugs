<?php
	require_once("config.php");
	$mysqli = new mysqli($server, $sqlid, $sqlpass, $dbase);
	if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();			
?>
