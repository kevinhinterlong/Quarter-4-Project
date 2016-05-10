<?php 
    //start session
    session_start();

    //extract and initialize variables
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sqlconfig = include("sql_config.php");

    //get a connection to the database
    $conn = getConnection(); 
    $username = $conn->real_escape_string($username); //escape username
    $userDetails = getUser($conn,$username); //retrieve details for user if they exist
    $row = $userDetails->fetch_array(MYSQLI_ASSOC);

    if($_POST["method"] == "logout") {//check if user wants to logout
	session_destroy();
	echo "success";
	//maybe log something
    } else if($_POST["method"] == "attemptRegister") { //if no results then see if the account is available
	if($userDetails->num_rows == 0 && trim($username) != "" && ctype_space($username) == false) {
	    echo "That account is available. Would you like to register it?";
	} else {
	    echo "Unfortunately that account has already been taken.";
	}
    } else if($_POST["method"] == "register"){ //check if the account is being registered
	if($userDetails->num_rows == 0 && trim($username) != "" && ctype_space($username) == false) {
	    register($conn,$username,$password);
	    login($conn,$username,$password); //login the user to set the session variables
	} else {
	    echo "Your username is bad or that account already exists. sorry";
	}
    } else if($userDetails->num_rows == 1) { //if no results login
	login($conn,$username,$password);
    } else {
	echo "No account found! Please register";
    }
    
    //close connection
    $conn->close();


//insert the user into the database
function register($conn, $username, $password) {
    $sqlconfig = include("sql_config.php");
    if(getUser($conn,$username)->num_rows == 0 ) {
	$hash = password_hash($password, PASSWORD_BCRYPT);
	$hash = $conn->real_escape_string($hash);
	$sql = "INSERT INTO " . $sqlconfig["table"] . "(`userName`, `userHash`) VALUES ('$username','$hash')";
	$result = $conn->query($sql);
    }
    echo "REGISTERED";
}

//attempt to log the user in to the website
function login($conn,$username,$password) {
    $row = getUser($conn,$username)->fetch_array(MYSQLI_ASSOC);
    //if computed hash = stored hash then allow the user to login
    if( password_verify($password, $row["userHash"])) {
	echo "success";
	$_SESSION['username'] = $username;
    } else {
	echo "fail";
    }
}

//return the details of the user currently in the database
function getUser($conn,$username) {
    $sqlconfig = include("sql_config.php");
    $sql = "SELECT * FROM {$sqlconfig["table"]} WHERE userName='$username'";
    $result = $conn->query($sql);
    return $result;
}

//attempt to get a connection to the mysql database and create database/table if needed
function getConnection() {
    $sqlconfig = include("sql_config.php");
    //connect to database
    $failed = false;
    $conn = new mysqli($sqlconfig["servername"], $sqlconfig["username"], $sqlconfig["password"], $sqlconfig["database"]); // Create connection	
    if ($conn->connect_error) { // Check connection
	$failed = true;
	initializeDatabase(); //create table if not exists
    }
    $conn = new mysqli($sqlconfig["servername"], $sqlconfig["username"], $sqlconfig["password"], $sqlconfig["database"]); // Create connection	
    if ($conn->connect_error) { // Check connection
	die("Connection failed: " . $conn->connect_error);
    }
    $tableExists = $conn->query("SELECT 1 FROM {$sqlconfig["table"]} LIMIT 1");
    if($tableExists == false) {
	initializeTable();
    }
    return $conn;	
}

//create database if not exists
function initializeDatabase() {
    $sqlconfig = include("sql_config.php");
    $conn = new mysqli($sqlconfig["servername"], $sqlconfig["username"], $sqlconfig["password"]); // Create connection	
    $sql= "CREATE DATABASE IF NOT EXISTS {$sqlconfig["database"]}";
    if ($conn->query($sql) === TRUE) {
	echo "db created successfully";
    } else {
	echo "Error creating db: " . $conn->error;
    }
    $conn->query("USE {$sqlconfig["database"]}");
}

//create table if not exists
function initializeTable() {
    $sqlconfig = include("sql_config.php");
    $conn = new mysqli($sqlconfig["servername"], $sqlconfig["username"], $sqlconfig["password"], $sqlconfig["database"]); // Create connection	
    $sql = "CREATE TABLE IF NOT EXISTS " . $sqlconfig["table"] . " (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    userName VARCHAR(30) NOT NULL,
    userHash VARCHAR(100) NOT NULL
    )";
    if ($conn->query($sql) === TRUE) {
	echo "Table created successfully";
    } else {
	echo "Error creating table" . $sqlconfig["table"] . ": " . $conn->error;
    }
}
