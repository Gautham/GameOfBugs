<?php
require_once("includes/global.php");
	if ($_SESSION['status'] == 0) {
		$_SESSION['status'] = 1;
		if ($_GET['lang'] == 'c') {
			$_SESSION['language'] = 1;
			$mysqli->query("UPDATE `teams` SET `language` = '1', `status` = '1' WHERE `teamid` = '{$_SESSION['teamid']}'");
			echo('<h2>printf("%s","Hey C Coders!");</h2><br/>');
			GetInstructions('c');
		}
		else {
			$_SESSION['language'] = 2;
			$mysqli->query("UPDATE `teams` SET `language` = '2', `status` = '1' WHERE `teamid` = '{$_SESSION['teamid']}'");
			echo('<h2>cout<<"Howdy C++ Aficionados!";</h2><br/>');
			GetInstructions('cpp');
		}			
	}
?>