<?php
    session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");
    
    $userDataSessions = isLoggedIn($conn);
    //placeholder document for now
    $healthcard = $_SESSION['HC'];

    // using SERVER to check if the user has clicked on the post button (if request method = POST)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html section below
		$Policy_Number = $_POST['Policy_Number'];
        //$Policy_Holder_Health_Num = $_POST['Policy_Holder_Health_Num'];
        $Company = $_POST['Company'];
        $Start_Date = $_POST['Start_Date'];
        $End_Date = $_POST['End_Date'];

        $message = "";

        // if not empty and it is valid, then do the following
        if (!empty($Policy_Number) && !empty($Company) && !empty($Start_Date) && !empty($End_Date)) {
            if(is_numeric($Policy_Number)){
                $conditionalQuery = "select * from insurance_plan where Policy_Holder_Health_Num = '$healthcard'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);

                if(mysqli_num_rows($CondQueryRes) > 0){
                    //reference used for updating values in SQL: https://www.tutorialrepublic.com/php-tutorial/php-mysql-update-query.php
                    //Reference used for prepare statements in PHP: https://www.tutorialrepublic.com/php-tutorial/php-mysql-prepared-statements.php
                    //reference used for updating SQL Database with check statements: https://www.wdb24.com/php-mysqli-procedural-prepared-statements-beginners/
                    $sqlQuery = "UPDATE `insurance_plan` SET `Policy_Number` = '$Policy_Number', `Company` = '$Company', `Start_Date` = '$Start_Date', `End_Date` = '$End_Date' WHERE `insurance_plan`.`Policy_Holder_Health_Num` = $healthcard";
                    //$sqlQuery = "UPDATE `patient_profile` SET `Weight` = ?, `Height` = ?, `Address` = ?, `Provider_Notes` = ?, `Email` = ?, `COVID_Test_Result` = $covidStat, `Phone` = $phone, WHERE `patient_profile`.`Gov_HealthCard_Num` = $healthcard";
                    mysqli_query($conn, $sqlQuery);
                    $_SESSION['Gov_HealthCard_Num'] = $healthcard;
                    header("Location: viewPatientDetails.php");
                    exit;

                }
                else{
                    $sqlQuery = "insert into `insurance_plan` (Policy_Number, Policy_Holder_Health_Num, Company, Start_Date, End_Date) values ('$Policy_Number','$healthcard','$Company','$Start_Date', '$End_Date')";
                    mysqli_query($conn, $sqlQuery);
                    $_SESSION['Gov_HealthCard_Num'] = $healthcard;
                    header("Location: viewPatientDetails.php");
                    exit;
                }
            }
            else {
                //echo "TechID, Phone number, health card number were not numerical values, try again.";
                $message = "Policy num is not a number.";
            }
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "No changes recorded, try again.";
        }
        mysqli_stmt_close($check);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Patient Insurance Edit</title>
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
                    <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Patient <?php echo $healthcard?> Insurance Edit</div>
                    <p><?php echo $message?></p>
                    <form method="post">
                            <p>
                                <label>Policy_Number:</label>
                                <input type="text" id="textbox" name="Policy_Number"/>
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

                            <input id="buttonStuff" type="submit" value="Save Changes"/>
                            <br>
                    </form>
            </div>
    </body>
</html>