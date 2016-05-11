//Tell the server to logout the current user
function logout() {
    var xhttp = new XMLHttpRequest();
    var result = "";
    xhttp.onreadystatechange = function() {
	if (xhttp.readyState == 4 && xhttp.status == 200) {
	    result = xhttp.responseText;
	    if(result === "success") {
		window.location.replace("index.php");
	    }
	}
    };
    xhttp.open("POST", "login.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("method=logout");
}

//attempt to login the current username with the current password
//this is basically the same as attemptRegister() except that it redirects to game.php on successful login
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

//check with the server to see if a username is avialable
function checkName() {
    attemptRegister("attemptRegister");
}

//actually register the user
function register() {
    attemptRegister("register");
}

//used to see if a name is available and 
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
	window.location.replace("game.php");
    }
}

//check if a string has whitespace with regex
function hasWhiteSpace(s) {
    return /\s/g.test(s);
}

