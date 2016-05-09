<!DOCTYPE html>
<!-- Kevin Hinterlong May 2, 2016 Quarter 4 Project -->
<html>
<?php
    session_start();
    if(isset($_SESSION['username']) && $_POST["action"] == "logout") {
	session_destroy();
    }
    if(!isset($_SESSION['username'])){
	header("Location:index.php");
    }
    include("config.php");


?>
    <head>
	<title>
	    <?php echo $companyName ?> - Play
	</title>

	<link rel="stylesheet" type="text/css" href="gameStyle.css">
	<script src="game.js"></script>
	<script>
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
	    
	</script>
    </head>

    <body onload="initialize()">
	<h1>Game of Craps</h1>
	<h2>Welcome, <?php echo $_SESSION["username"] ?> </h2>
	<div id="menuBar">
	    <a href="game.php">Home</a>
<!-- add personal leaderboards/history -->
	    <a href="leaderboards.php">Leaderboards</a>
	    <a href="instructions.php">Instructions</a>
	    <div id="logout"> 
		    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
			<input style="display:none;" type="text" value="logout" name="action">
			<input type="button" value="Logout" onclick="logout()">
		    </form>
	    </div>
	</div>
	
<!-- thing for the input  -->
	<div id="gameInput">
	    <h2 id="gameCounter">Current Game</h2>
	    <form id="gameForm">
		Games to play: <input type="text" placeholder="1" name="gamesToPlay"> <br />
		Roll 1: <input type="text" name="dice1" disabled> <br />
		Roll 2: <input type="text" name="dice2" disabled> <br />
		Sum: <input type="text" name="sum" disabled> <br />
		First Roll Sum: <input type="text" name="firstRollSum" disabled> <br />
		<input type="button" value="Start Game" name="submit">
	    <form>
	</div>

	<div id="game">
	    <canvas id="gameCanvas" height="300" width="400"></canvas>
	</div>
	
<!-- one thing for the stats  -->
	<div id="gameStats">
	    <canvas id="statsCanvas"></canvas>
	</div>

	<div id="instructions">
	    <canvas id="instructionsCanvas"></canvas>
	</div>
    </body>
</html>
