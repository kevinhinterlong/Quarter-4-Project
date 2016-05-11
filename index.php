<!DOCTYPE html>
<!-- Kevin Hinterlong May 4, 2016 login page for the game of craps -->
<html>
    <head>
	<?php include("config.php") ?>
	<title>
	<?php echo $companyName; ?> - Login
	</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

	<script type="text/javascript"  src="login.js"></script>
	<link rel="stylesheet" type="text/css" href="gameStyle.css">
    </head>

    <body>
	<div id="topBar">
	    <h1>Welcome to <?php echo $companyName ?> </h1>
	    
	    <div id="login">
		<form>
		    <p>Login here or <a href="register.php">Register</a> now.</p>
		    <input type="text" placeholder="username" name="username" id="usernameInput">
		    <input type="password" placeholder="password" name="password" id="passwordInput">
		    <input type="button" value="Submit" onclick="attemptLogin()">
		    <input type="button" id="register" value="Register" onclick="attemptRegister('register')">
		</form>
	    </div>
	</div>
    
	<div id="content"> 
	    <div id="response">
	    </div>
	</div>
	<script>
	    $( document ).ready(function() {
                    $('#register').hover(function(){
			var username = document.getElementById("usernameInput");
			var cleanVal = username.value.toLowerCase().trim();
			username.value = cleanVal;
                        if(username.value !== "" && hasWhiteSpace(username.value) == false) {
			    checkName(); //check if this has been used already
			} else {
			    document.getElementById("response").innerHTML = "";
			}
                        
                    });
                });
	</script>

    </body>
</html>
