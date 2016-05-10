<!DOCTYPE html>
<!-- Kevin Hinterlong May 4, 2016 This page allows people to register into the database so that they can log in -->
<html>
    <head>
	<?php include("config.php") ?>
	<title>
	<?php echo $companyName . " - Register" ?>
	</title>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script type="text/javascript" src="login.js"></script>

	<link rel="stylesheet" type="text/css" href="gameStyle.css">
    </head>

    <body>
	    <div id="login">
		<form>
		    <p>Register now:</p>
		    <input type="text" placeholder="username" name="username" id="usernameInput">
		    <input type="password" placeholder="password" name="password" id="passwordInput">
		    <input type="button" value="Register" onclick="register()">
		</form>
	    </div>
    
	    <div id="response">
	    </div>
	<script>
	    $( document ).ready(function() {
                    $('#usernameInput').keyup(function(){
			var valThis = $(this).val().toLowerCase().trim();
			document.getElementById("usernameInput").value = valThis;
                        if(valThis !== "" && hasWhiteSpace(valThis) == false) {
			    checkName(); //check if this has been used already
			} else {
			    document.getElementById("response").innerHTML = "";
			}
                        
                    });
                });
	</script>
    </body>
</html>
