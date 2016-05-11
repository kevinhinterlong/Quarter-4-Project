<!DOCTYPE html>
<!-- Kevin Hinterlong May 2, 2016 Shows the leaderboards for the game of craps -->
<html>
<?php
    //start the session
    session_start();
    if(isset($_SESSION['username']) && $_POST["action"] == "logout") { //logout
	session_destroy();
    }
    include("config.php");
?>
    <head>
	<title>
	   <?php echo $companyName ?> - Leaderboards
	</title>

	<link rel="stylesheet" type="text/css" href="gameStyle.css">
	
	<script type="text/javascript" src="login.js"></script>
    </head>

    <body>
	<h1>Game of Craps</h1>
	<?php 
	    if(isset($_SESSION["username"])) {
		include("menuBar.php");
	    } else {
		include("nonUserMenuBar.php");
	    }
	?>	

	<?php
	    include("scores.php");
	    $conn = getConnection();    
	    $sqlconfig = include("sql_config.php");
	    $sql = "SELECT * FROM {$sqlconfig["leaderboardsTable"]} ORDER BY `gamesPlayed` DESC";
	    $result = $conn->query($sql);
	    if($result->num_rows > 0) {
		//prints out the header for the table
		echo '<table id="leaderboards">';
		echo "<tr>";
		echo '<th class="position"> ' . "position" . "</th>";
		echo '<th class="username"> ' . "username" . "</th>";
		echo '<th class="wins"> ' . "wins" . "</th>";
		echo '<th class="losses"> ' . "losses" . "</th>";
		echo '<th class="gamesPlayed"> ' . "games played" . "</th>";
		echo "</tr>"; 
		$i=1;
		//print out all the users
		while($row = $result->fetch_assoc()) {
		    //highlight if current user is on the leaderboard
		    $class = "";
		    if(isset($_SESSION["username"])) {
			$class = $_SESSION["username"] == $row["userName"] ? "currentUser" : "";
		    }
		    echo "<tr class='$class'>";
		    echo '<td class="position"> ' . $i++ . "</td>";
		    echo '<td class="username"> ' . $row["userName"] . "</td>";
		    echo '<td class="wins"> ' . $row["wins"] . "</td>";
		    echo '<td class="losses"> ' . $row["losses"] . "</td>";
		    echo '<td class="gamesPlayed"> ' . $row["gamesPlayed"] . "</td>";
		    echo "</tr>"; 
		}
		echo "</table>";
	    } else {
		echo "<h2>No scores have been saved yet. Be the first!</h2>";
	    }

	?>
    </body>
</html>
