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
		$phone = $_POST['phone'];

        $covidStat = $_POST['covidstat'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $address = $_POST['address'];
        $providerNotes = $_POST['notes'];
        $email = $_POST['email'];

        $message = "";

        // if not empty and it is valid, then do the following
        if (!empty($address) && !empty($phone) && !empty($weight) && !empty($height)) {
            if(is_numeric($phone)){
                $conditionalQuery = "select * from patient_profile where Gov_HealthCard_Num = '$healthcard'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);
                    
                if(mysqli_num_rows($CondQueryRes) > 0){ 
                    //reference used for updating values in SQL: https://www.tutorialrepublic.com/php-tutorial/php-mysql-update-query.php
                    //Reference used for prepare statements in PHP: https://www.tutorialrepublic.com/php-tutorial/php-mysql-prepared-statements.php
                    //reference used for updating SQL Database with check statements: https://www.wdb24.com/php-mysqli-procedural-prepared-statements-beginners/
                    $sqlQuery = "UPDATE `patient_profile` SET `COVID_Test_Result` = '$covidStat', `Weight` = '$weight', `Height` = '$height', `Phone_Number` = '$phone', `Address` = '$address', `Provider_Notes` = '$providerNotes', `Email` = '$email' WHERE `patient_profile`.`Gov_HealthCard_Num` = $healthcard";
                    //$sqlQuery = "UPDATE `patient_profile` SET `Weight` = ?, `Height` = ?, `Address` = ?, `Provider_Notes` = ?, `Email` = ?, `COVID_Test_Result` = $covidStat, `Phone` = $phone, WHERE `patient_profile`.`Gov_HealthCard_Num` = $healthcard";
                    mysqli_query($conn, $sqlQuery);
                    $_SESSION['Gov_HealthCard_Num'] = $healthcard;
                    header("Location: viewPatientDetails.php");
                    exit;
                    /* if($check = mysqli_prepare($conn, $sqlQuery)){
                        mysqli_stmt_bind_param($check, "sssss", $weight, $height, $address, $providerNotes, $email);
                        mysqli_stmt_execute($check);

                        mysqli_query($conn, $sqlQuery);
                        $_SESSION['Gov_HealthCard_Num'] = $healthcard;
                        header("Location: viewPatientDetails.php");
                        exit;

                    } else {
                        $message = "Invalid input try again.";
                    } */
                    
                }
                else{
                    //echo "Gov. Health card already exists, try again.";
                    $message = "Info could not be updated. Patient not found in database.";
                }
            } 
            else {
                //echo "TechID, Phone number, health card number were not numerical values, try again.";
                $message = "Phone number is not numerical values, try again.";
            }
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "The only empty fields allowed are provider notes and email, try again.";
        }
        mysqli_stmt_close($check);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Patient Edit</title>
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
                    <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Patient <?php echo $healthcard?> Edit</div>
                    <p><?php echo $message?></p>
                    <form method="post">
                            <p>
                                <label>Address:</label>
                                <input type="text" id="textbox" name="address"/>
                            </p>
                            <p>
                                <label>Weight:</label>
                                <input type="text" id="textbox" name="weight"/>
                            </p>
                            <p>
                                <label>Height:</label>
                                <input type="text" id="textbox" name="height"/>
                            </p>
                            <p>
                                <label>Phone:</label>
                                <input type="text" id="textbox" name="phone"/>
                            </p>
                            <p>
                                <label>Email:</label>
                                <input type="text" id="textbox" name="email"/>
                            </p>
                            <p>
                                <label>Provider Notes:</label>
                                <input type="text" id="textbox" name="notes"/>
                            </p>
                            
                            <p>
                                <label>Select COVID Status:</label>
                                <select name="covidstat">
                                    <option value="Pending">Pending</option>
                                    <option value="Negative">Negative</option>
                                    <option value="Positive">Positive</option>
                                </select>
                            </p>

                            <input id="buttonStuff" type="submit" value="Save Changes"/>
                            <br>
                    </form>
            </div>
    </body>
</html>