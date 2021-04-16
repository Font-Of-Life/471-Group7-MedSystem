<?php
session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");

    // using SERVER to check if the user has clicked on the post button (if request method = POST)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html section below
        //Ingredient_Name	Drug/Ingredient_Alt	Drug/Ingredient_Usage
        $healthcard = $_POST['healthcard'];
        $Ingredient_Name = $_POST['Ingredient_Name'];
		//$DrugIngredient_Alt = $_POST['Drug/Ingredient_Alt'];
        //$DrugIngredient_Usage = $_POST['Drug/Ingredient_Usage'];

        $message = "";

        // if not empty and it is valid, then do the following
        if (!empty($Ingredient_Name)) {
            $conditionalQuery = "select * from patient_profile where Gov_HealthCard_Num = '$healthcard'";
            $CondQueryRes = mysqli_query($conn, $conditionalQuery);

            if(mysqli_num_rows($CondQueryRes) > 0){
                $conditionalQuery1 = "select * from drug/ingredient_allergies where Ingredient_Name = '$Ingredient_Name'";
                $CondQueryRes1 = mysqli_query($conn, $conditionalQuery1);

                $queryRes = "insert into can_have (Ingredient_Name,Gov_HealthCard_Num) values ('$Ingredient_Name','$healthcard')";
                //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                mysqli_query($conn, $queryRes);

                header("Location: viewAllergyDetails.php");
                exit;

//                 if (mysqli_num_rows($CondQueryRes1) > 0) {
//                     $queryRes = "insert into can_have (Ingredient_Name,Gov_HealthCard_Num) values ('$Ingredient_Name','$healthcard')";
//                     //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
//                     mysqli_query($conn, $queryRes);
//
//                     header("Location: viewAllergyDetails.php");
//                     exit;
//                 }
//                 else {
// //                     $queryRes0 = "insert into drug/ingredient_allergies (Ingredient_Name, Drug/Ingredient_Alt, Drug/Ingredient_Usage) values ('$Ingredient_Name','$DrugIngredient_Alt', '$DrugIngredient_Usage')";
// //                     mysqli_query($conn, $queryRes0);
// //
// //                     $queryRes = "insert into can_have (Ingredient_Name,Gov_HealthCard_Num) values ('$Ingredient_Name','$healthcard')";
// //                     //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
// //                     mysqli_query($conn, $queryRes);
// //
// //                     header("Location: viewAllergyDetails.php");
// //                     exit;
//                     $message = "Allergen does not exists, try again.";
//                 }
            }
            else{
                //echo "Gov. Health card already exists, try again.";
                $message = "Gov. Health card does not exists, try again.";
            }
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "You must provide an allergen, try again.";
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
                                <label>Government Health Card Number:</label>
                                <input type="text" id="textbox" name="healthcard"/>
                            </p>
                            <p>
                                <label>Ingredient Name:</label>
                                <input type="text" id="textbox" name="Ingredient_Name"/>
                            </p>

                            <input type="submit" value="Register"/>
                            <br>
                    </form>
            </div>
    </body>
</html>
