<div id="menuBar">
    <a href="home.php">Home</a>
    <a href="game.php">Game</a>
<!-- add personal leaderboards/history -->
    <a href="leaderboards.php">Leaderboards</a>
    <div id="logout"> 
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
	    <input style="display:none;" type="text" value="logout" name="action">
	    <input type="button" value="Logout" onclick="logout()">
	</form>
    </div>
</div>
