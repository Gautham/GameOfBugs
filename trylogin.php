<?php
require_once("includes/global.php");
if (!isset($_POST['teamid']) || !isset($_POST['password'])) header("Location: login.php") && die();
echo "<h2>";
	$stmt = $mysqli->prepare("SELECT `status`, `stage`, `language` FROM `teams` WHERE `teamid` = ? AND `password` = ?");
/**/	$teamid = $_POST['teamid'];
	$password = $_POST['password'];

/*	$teamid = 'DEB001';
	$password = 'thisrocks!'; */

	
	$stmt->bind_param("ss", $teamid, $password);
	$stmt->execute();
	$Status = "No";
	$stmt->store_result();
	$stmt->bind_result($status, $stage, $language);
	$stmt->fetch();
	if ($stmt->num_rows == 1) { 
		$_SESSION['teamid'] = $_POST['teamid'];
		$_SESSION['status'] = $status;
		$_SESSION['stage'] = $stage;
		$_SESSION['language'] = $language;
		$Status = "YES";
	}
	echo $Status;
echo "</h2>";
?>