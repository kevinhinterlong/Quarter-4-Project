<!DOCTYPE html>
<!-- Kevin Hinterlong May 2, 2016 Quarter 4 Project -->
<html>
<?php
    //start session
    session_start();
    if(isset($_SESSION['username']) && $_POST["action"] == "logout") { //logout
	session_destroy();
    }
    include("config.php");


?>
    <head>
	<title>
	    <?php echo $companyName ?> - Home
	</title>

	<link rel="stylesheet" type="text/css" href="gameStyle.css">
	<script type="text/javascript" src="login.js"></script>
    </head>

    <body onload="initialize()">
	<h1>Home</h1>
	<?php 
	    if(isset($_SESSION["username"])) {
		echo '<h2>Welcome, ' . $_SESSION["username"] . '</h2>';
	    }
	?> 
	<?php 
	    if(isset($_SESSION["username"])) {
		include("menuBar.php");
	    } else {
		include("nonUserMenuBar.php");
	    }
	?>	
	<!-- Include more information about the game, the website, etc -->
	<p>There are currently <span id="userCount"></span> users registered on the site.</p>

	<p>This site hosts the Game of Craps and allows users to save their scores on the leaderboard and compete against their friends.</p>
	<p>The <a href="https://en.wikipedia.org/wiki/Craps">Game of Craps</a> has been around for a long time and requires very little equipment/training to play the game. This game is based on luck so when competing against friends the game is equal; however, in the case of a casino, all bets have a house advantage</p>
    </body>
</html>

