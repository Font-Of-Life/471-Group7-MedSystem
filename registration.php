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
<body>
	<div id="formbox">
		<form method="post">
			<div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">User Registration</div>

			<a href="LoginPage.php">Login</a><br><br>
			<a href="registerTechnican.php">Register As Technican</a><br><br>
            <a href="registerPharmacist.php">Register As Pharmacist</a><br><br>
		</form>
	</div>
</body>
</html>