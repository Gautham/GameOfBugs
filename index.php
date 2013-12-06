<?php
require_once("includes/global.php");
session_start();
if (!isset($_SESSION['teamid'])) header("Location: login.php") && die();
elseif ($_SESSION['status'] == 2) header("Location: question.php") && die();
elseif ($_SESSION['status'] == 3) header("Location: done.php") && die();
	metadetails();
?>
  </head>
  <body>
  	<div id="main-content" class="box center">
  		<?php
  			if ($_SESSION['language'] == 1 || $_SESSION['language'] == 2) {
				if ($_SESSION['stage'] == '0') {
					if ($_SESSION['language'] == 1) {
						echo('<h2>printf("%s","Hey C Coders!");</h2><br/>');
						GetInstructions('c');	
					} else {
						echo('<h2>cout<<"Howdy C++ Aficionados!";</h2><br/>');
						GetInstructions('cpp');
					}
				} 
				elseif ($_SESSION['stage'] == '2a' || $_SESSION['stage'] == '2b') {
					echo '<h2>Welcome to Stage 2!!</h2><br/>';
					echo <<<CONTENT
						<ul id="Rules">
							<li>The second round will be an offline round of 30 minutes.</li>
							<li>You will be given 3 questions with logical errors.</li>
							<li>Use of Compilers is prohibited except the inline one provided.</li>
							<li>Marks will be provided based on the time of completion and correctness of solution.</li>
							<li>All Answers will be locked and cannot be altered after 30 minutes.</li>
							<li><strong>Do NOT refresh the page or hit the Back button.</strong></li>
							<li>Any act of dishonesty will result in immediate disqualification.</li>
							<li>The Decision of the Judges is final & beyond reproach.</li>
						</ul>
						<button class="btn btn-large btn-primary centerh" onclick="window.location.href = 'starttest.php'" style="width: 150px;" id="btn-start">Lets Start!</button>
CONTENT;
  				}
				elseif ($_SESSION['stage'] == '3a' || $_SESSION['stage'] == '3b') {
					echo '<h2>Welcome to Stage 3!!</h2><br/>';
					echo <<<CONTENT
						<ul id="Rules">
							<li>The second round will be an offline round of 1 hour.</li>
							<li>You will be given 2 questions with no errors.</li>
							<li>Your task is to analyze the code & explain the working of the code.</li>
							<li>Marks will be provided based on the time of completion and correctness of explanation.</li>
							<li>All Answers will be locked and cannot be altered after 1 hour.</li>
							<li><strong>Do NOT refresh the page or hit the Back button.</strong></li>
							<li>Any act of dishonesty will result in immediate disqualification.</li>
							<li>The Decision of the Judges is final & beyond reproach.</li>
						</ul>
						<button class="btn btn-large btn-primary centerh" onclick="window.location.href = 'starttest.php'" style="width: 150px;" id="btn-start">Lets Start!</button>
CONTENT;
  				}

  			} else {
  		?>
  		<h2>Welcome to Game Of Bugs !!</h2><br/>
  		<span style="font-size: 1.5em"> Are you ready to start ? Select your language of Choice to proceed to Rules & Instructions.</span></br/>
  		<div id="clang" onclick="AjaxGet('lang.php?lang=c', 'main-content');"></div>
  		<div id="cpplang" onclick="AjaxGet('lang.php?lang=cpp', 'main-content');"></div>
  	</div>

  	<?php }
  		AjaxGet();
  	?>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>