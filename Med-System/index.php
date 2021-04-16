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
    <style>
        body{
            background-color: lightgrey;
        }
        .title{
            color: white;
            font-size: 20px;
            text-align: center;
            margin: 0;
            float: center;
            line-height: 1.5;
            padding-left: 45px;
            text-align: center;
            font-style: italic;
            font: arial;
            font-weight: bold;
        }

        .titleClass{
            width: 100%;
            height: 60px;
            background-color: mediumseagreen;
        }
        .navigationBar{
            background-color: mediumseagreen;
            overflow: hidden;
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }

        .navigationBar a{
            float: left;
            padding-left:  20px;
            padding-right: 20px;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
            color: black;
        }

        .navigationBar a:hover{
            background-color: lime;
        }
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
        text-align: center;
        vertical-align: center;
        margin: 0 auto;
        background-color: whitesmoke;
        border-radius: 2px;
        border: 3px solid black;
        width: 25%;
        padding: 5%;
    }
    </style>
    <body>
        <div class="titleClass">
            <h1 class="title">Insert Title of medical insitute</h1>
        </div>
        <div class = "navigationBar"><a href="LogOut.php">Log Out</a></div>
        <div id = "formbox">
            <h1 style="text-align: center;">Welcome <?php echo $UserSession['First_Name'] . " " . $UserSession['Last_Name'];?></h1>
            <br>
            <p>What would you like to do?</p>
            <!--  List options to do the other stuff here  in div classes-->
            <div id="buttonStuff"> <a href="patientSearch.php" style="text-weight: bold; color: black; font-size: 16px;">Go to patient profiles</a> </div><br><br>
            <div id="buttonStuff"> <a href="drugSearch.php" style="text-weight: bold; color: black; font-size: 16px;">Go to drug profiles</a> </div><br><br>
            <div id="buttonStuff"> <a href="LogOut.php" style="text-weight: bold; color: black; font-size: 16px;">Log Out</a> </div><br>
            
        </div>
        
    </body>
</html>