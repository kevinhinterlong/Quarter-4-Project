<!DOCTYPE HTML>
<html>
<!-- member only area of site -->
<?php
    session_start();
    if(isset($_SESSION['username']) && $_POST["action"] == "logout") {
	session_destroy();
    }
    if(!isset($_SESSION['username'])){
	header("Location:login.php");
    }
    include("config.php");


?>

<head>
    <title>
	<?php echo $companyName; ?>
    </title>

</head>

<body>

    <h1>Content for <?php echo $_SESSION['username']; ?></h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
	<input style="display:none;" type="text" value="logout" name="action">
        <input type="submit" value="logout" >
    </form>
</body>

</html>
