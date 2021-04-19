<?php
session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");
    $fileName = 'jsonfile2.json';
    $dataArr = array();

    // using SERVER to check if the user has clicked on the post button (if request method = POST)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html section below
        // First_Name	Last_Name	Parent_HealthCard_Num	Relationship
        $Policy_Number = $_POST['Policy_Number'];
        $Policy_Holder_Health_Num = $_POST['Policy_Holder_Health_Num'];
        $Company = $_POST['Company'];
        $Start_Date = $_POST['Start_Date'];
        $End_Date = $_POST['End_Date'];

        // Policy_Number	Policy_Holder_Health_Num	Company	Start_Date	End_Date
        $message = "";

        // if not empty and it is valid, then do the following
        if (!empty($Policy_Holder_Health_Num) && !empty($Policy_Number)) {
            if(is_numeric($Policy_Holder_Health_Num)){
                $conditionalQuery = "select * from patient_profile where Gov_HealthCard_Num = '$Policy_Holder_Health_Num'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);
                // Policy_Number	Policy_Holder_Health_Num	Company	Start_Date	End_Date
                if(mysqli_num_rows($CondQueryRes) > 0){
                    //register the following values into the user table
                    $queryRes = "insert into insurance_plan (Policy_Number, Policy_Holder_Health_Num, Company, Start_Date, End_Date) values ('$Policy_Number','$Policy_Holder_Health_Num','$Company', '$Start_Date', '$End_Date')";
                    //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                    mysqli_query($conn, $queryRes);

                    $dataArr["Patient Insurance Info ".$Policy_Holder_Health_Num] = array(
                        "Policy Holder Health Card Number: " => $Policy_Holder_Health_Num,
                        "policyNum: " => $Policy_Number,
                        "Insurance Company Name: " => $Company,
                        "Start_Date: " => $Start_Date,
                        "EndDate: " => $End_Date
                    );

                    $encodeJson = json_encode($dataArr);
                    file_put_contents($fileName,$encodeJson);
                    header("Location: viewInsuranceDetails.php");
                    exit;
                }
                else{
                    //echo "Gov. Health card already exists, try again.";
                    $message = "Gov. Health card does not exists, try again.";
                    $encodeJson = json_encode($message);
                    file_put_contents($fileName,$encodeJson);
                }
            } 
            else {
                //echo "TechID, Phone number, health card number were not numerical values, try again.";
                $message = "Health card only takes integer, try again.";
                $encodeJson = json_encode($message);
                file_put_contents($fileName,$encodeJson);
            }
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "You must provide the Policy holder's health card number and the Policy Number, try again.";
            $encodeJson = json_encode($message);
            file_put_contents($fileName,$encodeJson);
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
                                <label>Policy_Number:</label>
                                <input type="text" id="textbox" name="Policy_Number"/>
                            </p>
                            <p>
                                <label>Policy Holder HC #:</label>
                                <input type="text" id="textbox" name="Policy_Holder_Health_Num"/>
                            </p>
                            <p>
                                <label>Company:</label>
                                <input type="text" id="textbox" name="Company"/>
                            </p>
                            <p>
                                <label>Start Date:</label>
                                <input type="text" id="textbox" name="Start_Date"/>
                            </p>
                            <p>
                                <label>End Date:</label>
                                <input type="text" id="textbox" name="End_Date"/>
                            </p>

                            <input type="submit" value="Register" id="buttonStuff"/>
                            <br>
                    </form>
            </div>
    </body>
</html>
