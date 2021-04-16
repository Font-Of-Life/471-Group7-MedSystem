<?php

session_start();
    include("connections.php");
    include("LoginChecker.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Registration</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
    #buttonStuff{
        background-color: #0BDA51;
        color: black;
        padding: 0.5rem;
        font-size: 14px;
        font-weight: bold;
        border: 2px solid black;
        border-radius: 1px solid black;
        cursor: pointer;
    }

    #formbox{
        /*Reference for code used in vertical and horizontal aligment by user Mr Bullets: 
            -> https://stackoverflow.com/questions/19461521/how-to-center-an-element-horizontally-and-vertically */
        right: 50%;
        bottom: 50%;
        transform: translate(50%,50%);
        position: absolute;
        text-align: center;
        vertical-align: center;
        margin: 0 auto;
        background-color: whitesmoke;
        border-radius: 2px;
        border: 3px solid black;
        width: 25%;
        padding: 5%;
    }

    body{
        background-color: darkgrey;
    }
</style>
<body>
	<div id="formbox">
		<form method="post">
			<div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">User Registration</div>
			<div><a href="LoginPage.php" id="buttonStuff">Login</a></div><br><br>
			<div><a href="registerTechnican.php" id="buttonStuff">Register As Technican</a></div><br><br>
			<div><a href="registerPharmacist.php" id="buttonStuff">Register As Pharmacist</a></div><br>
			
			
            
		</form>
	</div>
</body>
</html>
