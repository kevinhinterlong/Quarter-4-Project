<!DOCTYPE html>
<!-- Kevin Hinterlong May 4, 2016 Attempting to create a login page for a website -->
<html>
    <head>
	<?php include("config.php") ?>
	<title>
	<?php echo $companyName . " - Home" ?>
	</title>

	<style>
	    #topBar {
		background-color: #8080ff;
		margin: 0;
		padding: 1em;
	    }

	    #login input {
		display: block;
	    }
	</style>
	<script>
	    function attemptLogin() {
		var username = document.getElementById("usernameInput").value;
		var password = document.getElementById("passwordInput").value;
                var xhttp = new XMLHttpRequest();
		var result = "";
                xhttp.onreadystatechange = function() {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
			result = xhttp.responseText;
			if(result === "success") {
			    window.location.replace("game.php");
			} else {
			    document.getElementById("response").innerHTML = "Failed to log in. Please try again";
			}
                    }
                };
                xhttp.open("POST", "login.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("username=" + username + "&password=" + password);
            }
	    
	</script>
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
		</form>
	    </div>
	</div>
    
	<div id="content"> 
	    <div id="response">
	    </div>
	</div>
    </body>
</html>
