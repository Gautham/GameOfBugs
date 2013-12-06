<?php
require_once("includes/global.php");
if (isset($_SESSION['teamid']) && ($_GET['key'] != "M1112AER")) header("Location: index.php") && die();
	metadetails();
?>
  </head>
  <body>
    <div id="form-signin-container">
      <form id="form-signin" class="box" action="">
        <h2 id="form-signin-heading">Please Sign In</h2>
        <div class="input-prepend">
			<span class="add-on">DEB</span>
			<input class="span2" name="teamid" id="teamid" type="text" placeholder="Team ID">
		</div>
        <input type="password" id="password" name="password" class="input-block-level" placeholder="Password">
        <button class="btn btn-large btn-primary centerh" style="width: 100px;" id="btn-login" type="submit">Sign in</button>
      </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script>
		$("#btn-login").click(function() {
			$("#alertdiv").remove();
			var tid = $("#teamid").val();
			var pass = $("#password").val();
			if (tid.length !=  3 || pass.length < 6) { 
				$('#form-signin-container').append('<div id="alertdiv" class="alert alert-error"> <button type="button" class="close" data-dismiss="alert">&times;</button><strong>Ooops!</strong>Looks like the ID or password you entered is not of correct length!</div>');
				setTimeout(function() { $("#alertdiv").remove(); }, 5000);
			}
			else
				$.ajax({  
					type: "POST", url: "trylogin.php", data: 'teamid=DEB'  + tid + '&password=' + $("#password").val(),  
					success: function(data) {
												p = $(data).html();
												if (p == "YES") window.location.href = 'index.php';
												else {
													$('#form-signin-container').append('<div id="alertdiv" class="alert alert-error"> <button type="button" class="close" data-dismiss="alert">&times;</button><strong>Ooops!</strong>Looks like the ID or password you entered is incorrect!</div>');
													setTimeout(function() { $("#alertdiv").remove(); }, 5000);							
												}
											},
					error: function() {
						$('#form-signin-container').append('<div id="alertdiv" class="alert alert-error"> <button type="button" class="close" data-dismiss="alert">&times;</button><strong>Ooops!</strong>Something went wrong. Try Again!</div>');
						setTimeout(function() { $("#alertdiv").remove(); }, 5000);
					}
				});
			return false;  
		} );
    </script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>