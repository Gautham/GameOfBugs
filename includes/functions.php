<?php	
require_once("includes/config.php");


	function metadetails() {
		header('Content-type: text/html; charset=utf-8');
		echo <<<CONTENT
<!DOCTYPE html>
<html>
  <head>
    <title>Game Of Bugs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
CONTENT;
}

	function AjaxGet() {
		echo <<<CONTENT
		<script>
			function AjaxGet(a, b) {
				Req = new XMLHttpRequest();
				Req.onreadystatechange = function()
				{	if (Req.readyState == 4) {
						if (Req.status == 200 || Req.status == 304) {
							if (Req.responseText != "failed!") document.getElementById(b).innerHTML = Req.responseText;
							else alert("Failed!");
						} else alert("Failed!");
					}
  				}
				Req.open("GET", a, true);
				Req.send();
			}
		</script>
CONTENT;
	}

	function GetInstructions($lang) {
			echo <<<CONTENT
				<ul id="Rules">
					<li>The first round will be an offline round of 30 minutes.</li>
					<li>You will be given 4 questions with syntax errors.</li>
					<li>Use of Compilers is prohibited.</li>
					<li>Marks will be provided based on the time of completion and correctness of solution.</li>
					<li>All Answers will be locked and cannot be altered after 30 minutes.</li>
					<li><strong>Do NOT refresh the page or hit the Back button.</strong></li>
					<li>Any act of dishonesty will result in immediate disqualification.</li>
					<li>The Decision of the Judges is final & beyond reproach.</li>
				</ul>
				<button class="btn btn-large btn-primary centerh" onclick="window.location.href = 'starttest.php'" style="width: 150px;" id="btn-start">Lets Start!</button>
CONTENT;
	}
?>