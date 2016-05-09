<!DOCTYPE html>
<!-- Kevin Hinterlong May 4, 2016 Attempting to create a login page for a website -->
<html>
    <head>
	<?php include("config.php") ?>
	<title>
	<?php echo $companyName . " - Register" ?>
	</title>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

	<style>
	    #login input {
		display: block;
	    }

	    #login {
		position:absolute;
		top:30%;
	        right:0;
	        left:40%;
		bottom:0;
		margin:auto;
	    }
	</style>
	<script>
	    //check if name is available
	    function checkName() {
		attemptRegister("attemptRegister");
	    }

	    //actually register
	    function register() {
		attemptRegister("register");
	    }

	    function attemptRegister(mode) {
		var username = document.getElementById("usernameInput").value;
		var password = document.getElementById("passwordInput").value;
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
			document.getElementById("response").innerHTML = xhttp.responseText;
                    }
                };
                xhttp.open("POST", "login.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("username=" + username + "&password=" + password + "&method=" + mode);
		if(mode == "register") {
		    window.location.replace("member_area.php");
		}
            }
	    
	    function hasWhiteSpace(s) {
		return /\s/g.test(s);
	    }

	</script>
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
