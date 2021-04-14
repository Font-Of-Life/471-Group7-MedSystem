<?php
    
    //checks to see if the user is logged in or not
    session_start();
    //includes the following files
    include("connections.php");
    include("LoginChecker.php");
    
    //goes to the isLoggedIn function in loginChecker to see if user is logged in
    $UserSession = isLoggedIn($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
    </head>
    <body>
        <a href="LogOut.php">Log Out</a>
        <h1>Welcome <?php echo $UserSession['First_Name'] . " " . $UserSession['Last_Name'];?></h1>
        <br>
        <p>What would you like to do?</p>
        <!--  List options to do the other stuff here  in div classes-->
        <div><a href="patientSearch.php">Go to patient profiles</a> </div>
        <div> Go to drug profiles </div>
        <div> Go to drug prescription </div>
    </body>
</html>
