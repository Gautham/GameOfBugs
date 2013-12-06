<?php
require_once("includes/global.php");
	if (!isset($_SESSION['teamid'])) header("Location: login.php") && die();
		if ($_SESSION['status'] == 1 && $_SESSION['stage'] == '0') {
			if ($_SESSION['language'] == "1") $_SESSION['stage'] = "1a";
			else $_SESSION['stage'] = "1b";
	}
	$_SESSION['status'] = $_SESSION['status'] + 1;
	$_SESSION['questionid'] = 1;
	$mysqli->query("UPDATE `teams` SET `stage` = '{$_SESSION['stage']}', `status` = '{$_SESSION['status']}' WHERE `teamid` = '{$_SESSION['teamid']}'");
	header("Location: question.php");
?>