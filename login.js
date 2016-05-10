function logout() {
    //get game stats?
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
	window.location.replace("game.php");
    }
}

function hasWhiteSpace(s) {
    return /\s/g.test(s);
}

