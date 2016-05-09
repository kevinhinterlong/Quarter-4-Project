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
	    <?php echo $companyName ?> - Home
	</title>

	<link rel="stylesheet" type="text/css" href="gameStyle.css">
	<script type="text/javascript" src="login.js"></script>
    </head>

    <body onload="initialize()">
	<h1>Home</h1>
	<h2>Welcome, <?php echo $_SESSION["username"] ?> </h2>
	<?php 
	    include("menuBar.php");
	?>	
	
    </body>
</html>

