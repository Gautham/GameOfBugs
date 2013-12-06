<?php
require_once("includes/global.php");
	if (!isset($_SESSION['teamid'])) header("Location: login.php") && die();
//	elseif ($_SESSION['status'] < 2) header("Location: index.php") && die();
//	elseif (!isset($_SESSION['stage'])) header("Location: index.php") && die();
	if (!isset($_POST['op'])) {
		metadetails();
		echo '</head>';
		echo '<body>';
		$res = $mysqli->query("SELECT * FROM `stages` WHERE `stageid` = '{$_SESSION['stage']}'");
		$res = $res->fetch_assoc();
		$_SESSION['questionid'] = 1;
		if ($res['type'] == "syntax" || $res['type'] == "logic1" || $res['type'] == "obfuscate") {			
		?>
			<div id="content" class="box" style="width: 70%; height: 400px; top: 50px; "></div>
			<div id="paginator" class="pagination">	
				<ul>	
					<li onclick="GetQuestion('question.php', '<?php echo $_SESSION['stage']; ?>', '1', ace.edit('content').getValue());"><a href="#">1</a></li>  
					<li onclick="GetQuestion('question.php', '<?php echo $_SESSION['stage']; ?>', '2', ace.edit('content').getValue());"><a href="#">2</a></li>
					<?php
						if ($_SESSION['stage'] != '3a' && $_SESSION['stage'] != '3b') echo "<li onclick=\"GetQuestion('question.php', '{$_SESSION['stage']}', '3', ace.edit('content').getValue());\"><a href=\"#\">3</a></li>";  
						if ($_SESSION['stage'] == '1a' || $_SESSION['stage'] == '1b') echo "<li onclick=\"GetQuestion('question.php', '{$_SESSION['stage']}', '4', ace.edit('content').getValue());\"><a href=\"#\">4</a></li>";

					?>
				</ul>  
			</div>

			<?php
				if ($_SESSION['stage'] != '3a' && $_SESSION['stage'] != '3b')  {
					echo "<button id=\"resetAnswer\" onclick=\"ResetAns('question.php', '{$_SESSION['stage']}')\" class=\"btn btn-large btn-danger\" style=\"position: absolute; right: 1%; bottom: 5%; width: 200px;\" >Reset Answer</button>";
					echo "<button id=\"submitsol\" onclick=\"SubmitAns('question.php', '{$_SESSION['stage']}')\" class=\"btn btn-large btn-success\" style=\"width: 200px;\" >Submit Solutions</button>";
				}
				if ($_SESSION['stage'] == '2a' || $_SESSION['stage'] == '2b') {
					echo "<button id=\"compilesol\" onclick=\"CompileCheck()\" class=\"btn btn-large btn-success\" style=\"width: 200px;\" >Compile & Check</button>";	
				}
			?>
			<button id="timer" class="btn btn-large btn-warning" style="position: absolute; left: 1%; bottom: 5%; width: 200px;" ><div id="timer_count">A</div></button>
			<script src="src/ace.js" type="text/javascript" charset="utf-8"></script>
			<script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					timer_active = false,
					timer_count = 0;

					function timer() { 
						var sec_num = timer_count;
						var hours   = Math.floor(sec_num / 3600);
					    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
					    var seconds = sec_num - (hours * 3600) - (minutes * 60);
					    if (hours == 0) {
					    	if (minutes == 0) $('#timer_count').html("Time Left: " + seconds + "s");
					    	else $('#timer_count').html("Time Left: " + minutes + "m " + seconds + "s");
					    } else $('#timer_count').html("Time Left: " + hours + "h " + minutes + "m " + seconds + "s");
						if (timer_count > 0) {
							setTimeout(function () { timer(); }, 1000);
							timer_count -= 1;
						} else timer_end(true);
					}

					function start_timer(wait_time) {
						if (timer_active) return;
						timer_count = wait_time;
						timer();
						timer_active = true;
					 }

					function timer_end(go) {
						SubmitAns('question.php', '<?php echo $_SESSION['stage']; ?>', 3);
					}
					start_timer(<?php echo $res['time'] * 60; ?>);
				});
			</script>
			<script>
				function Ace() {
					var editor = ace.edit("content");
					editor.setTheme("ace/theme/textmate");
					editor.getSession().setMode("ace/mode/h");					
				};

				function GetQuestion(a, b, c, d) {
					$.post(a,
						  {
						    stage : b,
						    q : c,
						    ans : d,
						    op : 1
						  },
						  function(data){
						  	val1 = data.getElementById
							ace.edit('content').setValue(data);
  					});
				}

				<?php 
					if ($_SESSION['stage'] != '3a' && $_SESSION['stage'] != '3b') {
				?>
				function ResetAns(a, b) {
					$.post(a,
						  {
						    stage : b,
						    op : 2
						  },
						  function(data){
							ace.edit('content').setValue(data);
  					});
				}

				function SubmitAns(a, b, c) {
					if (!c) var r=confirm("Are you sure you want to submit ? You cannot edit any answers after this!");						
					else r = true;

					if (r == true) {
						$.post(a,
								  {
								    stage : b,
								    ans : ace.edit('content').getValue(),
								    op : 3
								  },
								  function(){
									$(location).attr('href','index.php');
		  					});
					}
				}
				<?php
					}
					if ($_SESSION['stage'] == '2a' || $_SESSION['stage'] == '2b') {
				?>
						function CompileCheck() {
							$.post('question.php',
								  {
								    ans : ace.edit('content').getValue(),
								    op : 4
								  },
								  function(data){
								  	alert(data);								
		  					});
						}
				<?php
					}
				?>
				GetQuestion('question.php', '<?php echo $_SESSION['stage'] ?>', '1', '');
			</script>
		<?php
			
		}			
		echo '</body>';
		echo '</html>';
	} else {
		if ($_POST['op'] == 1) {
			$res = $mysqli->query("SELECT * FROM `answers` WHERE `teamid` = '{$_SESSION['teamid']}' AND `stageid` = '{$_POST['stage']}' AND `questionid` = '{$_POST['q']}'");
			if ($res->num_rows == 0) {
				$res = $mysqli->query("SELECT * FROM `questions` WHERE `stageid` = '{$_POST['stage']}' AND `questionid` = '{$_POST['q']}'");
				$res = $res->fetch_assoc();
				echo $res['question'];
			} else {
				$res = $res->fetch_assoc();
				echo $res['ans'];
			}
			if ($_POST['ans'] != '') $mysqli->query("INSERT INTO `answers` (teamid, stageid, questionid, ans) VALUES('{$_SESSION['teamid']}', '{$_SESSION['stage']}', '{$_SESSION['questionid']}', '".$mysqli->real_escape_string($_POST['ans'])."')
	ON DUPLICATE KEY UPDATE teamid = VALUES(teamid), stageid = VALUES(stageid), questionid = VALUES(questionid), ans = VALUES(ans)");
			$_SESSION['questionid'] = $_POST['q'];		
		}
		elseif ($_POST['op'] == 2) {
			$res = $mysqli->query("SELECT * FROM `questions` WHERE `stageid` = '{$_POST['stage']}' AND `questionid` = '{$_SESSION['questionid']}'");
			$res = $res->fetch_assoc();
			echo $res['question'];
			$mysqli->query("INSERT INTO `answers` (teamid, stageid, questionid, ans) VALUES('{$_SESSION['teamid']}', '{$_SESSION['stage']}', '{$_SESSION['questionid']}', '".$mysqli->real_escape_string($res['question'])."')
			ON DUPLICATE KEY UPDATE teamid = VALUES(teamid), stageid = VALUES(stageid), questionid = VALUES(questionid), ans = VALUES(ans)");
		}
		elseif ($_POST['op'] == 3) {
			$mysqli->query("INSERT INTO `answers` (teamid, stageid, questionid, ans) VALUES('{$_SESSION['teamid']}', '{$_SESSION['stage']}', '{$_SESSION['questionid']}', '".$mysqli->real_escape_string($_POST['ans'])."')
	ON DUPLICATE KEY UPDATE teamid = VALUES(teamid), stageid = VALUES(stageid), questionid = VALUES(questionid), ans = VALUES(ans)");
			$_SESSION['status'] = 1;
			$_SESSION['questionid'] = 0;
			if ($_SESSION['stage'] == '3a' || $_SESSION['stage'] == '3b') $_SESSION['status'] = '3';
			if ($_SESSION['stage'] == '2a') $_SESSION['stage'] = '3a';
			if ($_SESSION['stage'] == '2b') $_SESSION['stage'] = '3b';
			if ($_SESSION['stage'] == '1a') $_SESSION['stage'] = '2a';
			if ($_SESSION['stage'] == '1b') $_SESSION['stage'] = '2b';
			$mysqli->query("UPDATE `teams` SET `stage` = '{$_SESSION['stage']}', `status` = '{$_SESSION['status']}' WHERE `teamid` = '{$_SESSION['teamid']}'");
		}
		elseif ($_POST['op'] == 4) {
			if ($_SESSION['language'] == 1) $filename = $_SESSION['teamid'].'_'.$_SESSION['questionid'].'.c';
			else $filename = $_SESSION['teamid'].'_'.$_SESSION['questionid'].'.cpp';
			file_put_contents($filename, $_POST['ans']);
			$output = shell_exec('./run.sh '.$filename);
			$output = file_get_contents($filename.'.log');
			echo $output;
		}
	}

?>
