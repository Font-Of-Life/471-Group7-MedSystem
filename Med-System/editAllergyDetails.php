<?php
session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");
    $healthcard = $_SESSION['HC'];

    // using SERVER to check if the user has clicked on the post button (if request method = POST)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html section below
        //Ingredient_Name	Drug/Ingredient_Alt	Drug/Ingredient_Usage
        $Ingredient_Name = $_POST['Ingredient_Name'];
        $DrugIngredient_Alt = $_POST['Ingredient_AltName'];
        $DrugIngredient_Usage = $_POST['Ingredient_Usage'];

        $message = "";

        // if not empty and it is valid, then do the following
        if (!empty($Ingredient_Name) && !empty($DrugIngredient_Usage) && !empty($DrugIngredient_Alt)) {
            if(is_numeric($healthcard)){
                $conditionalQuery = "select * from patient_profile where Gov_HealthCard_Num = '$healthcard'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);

                if(mysqli_num_rows($CondQueryRes) > 0){
                    $conditionalQuery1 = "select * from drug/ingredient_allergies where Ingredient_Name = '$Ingredient_Name'";
                    $CondQueryRes1 = mysqli_query($conn, $conditionalQuery1);

                    if(mysqli_num_rows($CondQueryRes1) > 0){
                        $checkCanHave = "select * from can_have where Gov_HealthCard_Num = '$healthcard' and Ingredient_Name = '$Ingredient_Name'";
                        $canHaveStat = mysqli_query($checkCanHave);

                        if(mysqli_num_rows($canHaveStat) < 0){
                            $condQuery1 = "UPDATE `can_have` SET `Ingredient_Name` = '$Ingredient_Name' WHERE `can_have`.`Gov_HealthCard_Num` = $healthcard";
                            mysqli_query($conn, $condQuery1);
                            $_SESSION['Gov_HealthCard_Num'] = $healthcard;
                            header("Location: viewPatientDetails.php");
                            exit;
                        } 
                        else {
                            $message = "Patient's allergy already exists in database.";
                        }
                    } 
                    else {
                        $queryRes = "insert into drug/ingredient_allergies (Ingredient_Name, Drug/Ingredient_Alt, Drug/Ingredient_Usage) values ('$Ingredient_Name','$DrugIngredient_Alt','$DrugIngredient_Usage')";
                        //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                        mysqli_query($conn, $queryRes);

                        $queryRes2 = "insert into can_have (Ingredient_Name, Gov_HealthCard_Num) values ('$Ingredient_Name','$healthcard')";
                        mysqli_query($conn, $queryRes2);
                        $_SESSION['Gov_HealthCard_Num'] = $healthcard;
                        header("Location: viewPatientDetails.php");
                        exit;
                    }
                }
                else{
                    //echo "Gov. Health card already exists, try again.";
                    $message = "Gov. Health card does not exists, try again.";
                } 
            }
            
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "Cannot have a empty field, try again.";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Patient Allergy Edit</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
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
            margin: 0 auto;
            background-color: whitesmoke;
            border-radius: 2px;
            border: 3px solid black;
            width: 25%;
            padding: 5%;
        }

        body{
            background-color: lightgrey;
        }
    </style>
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
                    <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Patient <?php echo $healthcard?> Allergy Edit:</div>
                    <p><?php echo $message?></p>
                    <form method="post">
                            <p><?php echo $message?></p>
                            <p>
                                <label>Ingredient Name:</label>
                                <input type="text" id="textbox" name="Ingredient_Name"/>
                            </p>
                            <p>
                                <label>Ingredient Alt Name:</label>
                                <input type="text" id="textbox" name="Ingredient_AltName"/>
                            </p>
                            <p>
                                <label>Ingredient Usage:</label>
                                <input type="text" id="textbox" name="Ingredient_Usage"/>
                            </p>

                            <input type="submit" value="Save" id="buttonStuff"/>
                            <br>
                    </form>
            </div>
    </body>
</html>