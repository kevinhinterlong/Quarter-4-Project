<?php
    session_start();
    if(isset($_SESSION['username']) && $_POST["action"] == "logout") {
	session_destroy();
    }
    if(!isset($_SESSION['username'])){
	header("Location:index.php");
    }
    $wins = $_POST["wins"];
    $losses = $_POST["losses"];
    $gamesPlayed = $_POST["gamesPlayed"];
    $method = $_POST["method"];

    $conn = getConnection();
    $sqlconfig = include("sql_config.php");
    if($method == "submitScores") {
	submitScores($conn,$_SESSION["username"],$wins,$losses,$gamesPlayed);
    }

    $conn->close();

function submitScores($conn, $username, $wins,$losses,$gamesPlayed) {
	$sqlconfig = include("sql_config.php");
	$exists = false;
	$oldScores = getOldScores($conn,$username,$exists);
	$wins = $conn->real_escape_string($wins + $oldScores["wins"]);
	$losses = $conn->real_escape_string($losses + $oldScores["losses"]);
	$gamesPlayed = $conn->real_escape_string($gamesPlayed + $oldScores["gamesPlayed"]);
	if($exists) {
	    $sql = "UPDATE `{$sqlconfig["leaderboardsTable"]}` SET `wins` = '$wins', `losses` = '$losses', `gamesPlayed` = '$gamesPlayed' WHERE `scores`.`username` = '$username'";
	} else {
	    $sql = "INSERT INTO " . $sqlconfig["leaderboardsTable"] . "(`userName`, `wins`, `losses`, `gamesPlayed`) VALUES ('$username','$wins','$losses','$gamesPlayed')";
	}
	$result = $conn->query($sql);
	// echo "saved";
    }

function getOldScores($conn,$username,&$exists) {
    $sqlconfig = include("sql_config.php");
    $sql = "SELECT * FROM " . $sqlconfig["leaderboardsTable"] . " WHERE userName='$username'";
    $result = $conn->query($sql);
    $arr = $result->fetch_array(MYSQLI_ASSOC);
    if($result->num_rows == 0) {
	$arr = array(
	    "wins" => "0",
	    "losses" => "0",
	    "gamesPlayed" => "0",
	);
    } else {
	$exists=true;
    }
    return $arr;
}

    function getConnection() {
	$sqlconfig = include("sql_config.php");
	//connect to database
	$failed = false;
        $conn = new mysqli($sqlconfig["servername"], $sqlconfig["username"], $sqlconfig["password"], $sqlconfig["database"]); // Create connection	
	if ($conn->connect_error) { // Check connection
	    $failed = true;
	    initializeDatabase(); //create db if not exists
	}

	$conn = new mysqli($sqlconfig["servername"], $sqlconfig["username"], $sqlconfig["password"], $sqlconfig["database"]); // Create connection	
	if ($conn->connect_error) { // Check connection
	    die("Connection failed: " . $conn->connect_error);
	}
	$tableExists = $conn->query("SELECT 1 FROM {$sqlconfig["leaderboardsTable"]} LIMIT 1");
	if($tableExists == false) {
	    initializeTable();
	}
	return $conn;	
    }
    
    function initializeDatabase() {
	$sqlconfig = include("sql_config.php");
        $conn = new mysqli($sqlconfig["servername"], $sqlconfig["username"], $sqlconfig["password"]); // Create connection	
	//create database if not exists
	$sql= "CREATE DATABASE IF NOT EXISTS {$sqlconfig["database"]}";
	if ($conn->query($sql) === TRUE) {
	    echo "db created successfully";
	} else {
	    echo "Error creating db: " . $conn->error;
	}
	$conn->query("USE {$sqlconfig["database"]}");
    }

    function initializeTable() {
	$sqlconfig = include("sql_config.php");
	//create table if not exists
        $conn = new mysqli($sqlconfig["servername"], $sqlconfig["username"], $sqlconfig["password"], $sqlconfig["database"]); // Create connection	
	$sql = "CREATE TABLE IF NOT EXISTS " . $sqlconfig["leaderboardsTable"] . " (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	userName VARCHAR(30) NOT NULL,
	wins INT(6) UNSIGNED NOT NULL,
	losses INT(6) UNSIGNED NOT NULL,
	gamesPlayed INT(6) UNSIGNED NOT NULL
	)";

	if ($conn->query($sql) === TRUE) {
	    echo "Table created successfully";
	} else {
	    echo "Error creating table" . $sqlconfig["table"] . ": " . $conn->error;
	}

    }




