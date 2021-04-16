<?php
session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");

    // using SERVER to check if the user has clicked on the post button (if request method = POST)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html section below
        // First_Name	Last_Name	Parent_HealthCard_Num	Relationship
        $First_Name = $_POST['First_Name'];
		$Last_Name = $_POST['Last_Name'];
        $Parent_HealthCard_Num = $_POST['Parent_HealthCard_Num'];

        $Relationship = $_POST['Relationship'];

        $message = "";

        // if not empty and it is valid, then do the following
        if (!empty($Parent_HealthCard_Num) && !empty($Relationship)) {
            if(is_numeric($Parent_HealthCard_Num)){
                $conditionalQuery = "select * from patient_profile where Gov_HealthCard_Num = '$Parent_HealthCard_Num'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);
                    
                if(mysqli_num_rows($CondQueryRes) > 0){
                    //register the following values into the user table
                    $queryRes = "insert into dependent (First_Name, Last_Name, Parent_HealthCard_Num, Relationship) values ('$First_Name','$Last_Name','$Parent_HealthCard_Num', '$Relationship')";
                    //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                    mysqli_query($conn, $queryRes);

                    header("Location: viewDependentsDetails.php");
                    exit;
                }
                else{
                    //echo "Gov. Health card already exists, try again.";
                    $message = "Gov. Health card does not exists, try again.";
                }
            } 
            else {
                //echo "TechID, Phone number, health card number were not numerical values, try again.";
                $message = "Health card only takes integer, try again.";
            }
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "You must provide the Parent health card number and relationship, try again.";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
            <title>Patient Registration</title>
            <link rel="stylesheet" href="style.css" type="text/css">
    </head>

    <style>
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

        body{
            background-color: lightgrey;
        }

        .navigationBar{
            background-color: mediumseagreen;
            overflow: hidden;
            text-align: center;
            color: white;
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
            background-color: lightgreen;
        }
    </style>

    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <body>
        <div class="titleClass">
            <h1 class="title">Insert Title of medical insitute</h1>
        </div>

        <div class="navigationBar">
            <a href="LogOut.php">Log Out</a>
            <a href="index.php">Home</a>
            <a href="patientSearch.php">Search Patient Profile</a>
            
        </div>
            <div id="formbox">
                    <form method="post">
                            <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Patient Registration</div>
                            <p><?php echo $message?></p>

                            <p>
                                <label>First Name:</label>
                                <input type="text" id="textbox" name="First_Name"/>
                            </p>
                            <p>
                                <label>Last Name:</label>
                                <input type="text" id="textbox" name="Last_Name"/>
                            </p>
                            <p>
                                <label>Parent Health Card Number:</label>
                                <input type="text" id="textbox" name="Parent_HealthCard_Num"/>
                            </p>
                            <p>
                                <label>Relationship:</label>
                                <input type="text" id="textbox" name="Relationship"/>
                            </p>

                            <input type="submit" value="Register"/>
                            <br>
                    </form>
            </div>
    </body>
</html>
