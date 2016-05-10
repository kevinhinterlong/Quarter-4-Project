<!DOCTYPE html>
<!-- Kevin Hinterlong May 2, 2016 Quarter 4 Project -->
<html>
<?php
    session_start();
    if(isset($_SESSION['username']) && $_POST["action"] == "logout") {
	session_destroy();
    }
    include("config.php");
?>
    <head>
	<title>
	   <?php echo $companyName ?> - Leaderboards
	</title>

	<link rel="stylesheet" type="text/css" href="gameStyle.css">
	<link rel="stylesheet" type="text/css" href="leaderboards.css">
	
	<script type="text/javascript" src="login.js"></script>
    </head>

    <body>
	<h1>Game of Craps</h1>
	<?php 
	    include("menuBar.php");
	?>	

	<?php
	    include("scores.php");
	    $conn = getConnection();    
	    $sqlconfig = include("sql_config.php");
	    $sql = "SELECT * FROM {$sqlconfig["leaderboardsTable"]} ORDER BY `gamesPlayed` ASC";
	    $result = $conn->query($sql);
	    if($result->num_rows > 0) {
		echo '<table id="leaderboards">';
		echo "<tr>";
		echo '<td class="position"> ' . "position" . "</td>";
		echo '<td class="username"> ' . "username" . "</td>";
		echo '<td class="wins"> ' . "wins" . "</td>";
		echo '<td class="losses"> ' . "losses" . "</td>";
		echo '<td class="gamesPlayed"> ' . "games played" . "</td>";
		echo "</tr>"; 
		$i=1;
	        while($row = $result->fetch_assoc()) {
		    echo "<tr>";
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
<!-- 
    create database if not exists leaderboards
    use database
    create table if not exists
    select * from table asc
    for each value, print name and score
    maybe show stats about leaderboards?    
-->
    </body>
</html>
