<?php
session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");

    $patientHealthCardNum = $_SESSION['Gov_HealthCard_Num'];

    // using SERVER to check if the user has clicked on the post button (if request method = POST)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html section below
        $healthcard = $_POST['healthcard'];
        $pharmLicNum = $_POST['pharmLicNum'];
        $pharmID = $_POST['pharmID'];
        $docLicNum = $_POST['docLicNum'];
        $prescibeName = $_POST['prescibeName'];
        $DINum = $_POST['DINum'];
        $rxNum = $_POST['rxNum'];
        $fillStatus = $_POST['fillStatus'];
        $recDate = $_POST['recDate'];
        $instruct = $_POST['instruct'];
        $lastFillDate = $_POST['lastFillDate'];
        $lastFillQuantity = $_POST['lastFillQuantity'];

        $message = "before first if statement";

        //Patient_HealthCard_Num, PharmLicense_Num, PharmID, DocLicense_Num, Prescriber_Name, DIN, RX_Number, Fill_Status, Date_Recieved,
        //Instruction, Date_Last_Filled, Amount_Last_Filled
        // $pharmLicNum, $pharmID, $docLicNum, $prescibeName, $DINum, $rxNum, $fillStatus, $recDate, $instruct, $lastFillDate, $lastFillQuantity

        // if not empty and it is valid, then do the following
        //if (!empty($DINum) && !empty($drugName) && !empty($drugGenericName)) {//&& !empty($drugPackSize) && !empty($drugSellPrice) && !empty($drugBuyPrice) && !empty($drugInventory) && !empty($drugStrength) && !empty($drugCreation) && !empty($userid)) {
        if (!empty($DINum)) {
            $message = "Passed first if statement";
            if(is_numeric($DINum)) {//&& is_numeric($userid) && is_numeric($drugPackSize) && is_numeric($drugSellPrice) && is_numeric($drugBuyPrice) && is_numeric($drugInventory) && is_numeric($drugStrength)){
                $conditionalQuery = "select * from drug_profile where DIN = '$DINum'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);

                $queryPatientGet = "select * from patient_profile where Gov_HealthCard_Num = '$patientHealthCardNum'";
                $queryPatientRes = mysqli_query($conn, $queryPatientGet);

                $conditionalQuery2 = "select * from pharmacist where PharmLicense_Num = '$pharmLicNum'";
                $CondQueryRes2 = mysqli_query($conn, $conditionalQuery2);

                $conditionalQuery3 = "select * from doctor where Doctor_LicenseNum = '$docLicNum'";
                $CondQueryRes3 = mysqli_query($conn, $conditionalQuery3);

                if(mysqli_num_rows($CondQueryRes) <= 0){
                      //echo "Gov. Health card already exists, try again.";
                      $message = "Drug does not exist, try again.";
                }
                else{
                    if((mysqli_num_rows($CondQueryRes2) > 0) || (mysqli_num_rows($CondQueryRes3) > 0)){
                        if (mysqli_num_rows($queryPatientRes) > 0) {
                            //$PatientData = mysqli_fetch_assoc($queryPatientRes);

                            //register the following values into the user table
                            $queryRes = "insert into drug_prescription (Patient_HealthCard_Num, PharmLicense_Num, PharmID, DocLicense_Num, Prescriber_Name, DIN, RX_Number, Fill_Status, Date_Recieved, Instruction, Date_Last_Filled, Amount_Last_Filled) values ('$healthcard', '$pharmLicNum', '$pharmID', '$docLicNum', '$prescibeName', '$DINum', '$rxNum', '$fillStatus', '$recDate', '$instruct', '$lastFillDate', '$lastFillQuantity')";
                            //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                            mysqli_query($conn, $queryRes);

                            header("Location: viewPatientDetails.php");
                            exit;
                        }
                        else{
                            $message = "Patient does not exist, try again.";
                        }
                    }
                    else {
                        //echo "userID does not exist, try again.";
                        $message = "Prescriber is not in the system, try again.";
                    }
                }
            } 
            else {
                //echo "TechID, Phone number, health card number were not numerical values, try again.";
                $message = "DIN, Pack Size, Sell Price, Buy Price, Inventory, Drud Schedule and Drug Strength were not numerical values, try again.";
            }
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "The only empty fields allowed is Drug Image, try again.";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
            <title>Drug Registration</title>
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
            <a href="drugSearch.php">Search Drug Profile</a>
            
        </div>
            <div id="formbox">
                    <form method="post">
                            <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Drug Registration</div>
                            <p><?php echo $message?></p>
                            //Patient_HealthCard_Num, PharmLicense_Num, PharmID, DocLicense_Num, Prescriber_Name, DIN, RX_Number, Fill_Status, Date_Recieved,
                            //Instruction, Date_Last_Filled, Amount_Last_Filled
                            // pharmLicNum, pharmID, docLicNum, prescibeName, DINum, rxNum, fillStatus, recDate, instruct, lastFillDate, lastFillQuantity
                            <p>
                                <label>Health Care Card Number:</label>
                                <input type="text" id="textbox" name="healthcard"/>
                            </p>
                            <p>
                                <label>Pharmacist License Number:</label>
                                <input type="text" id="textbox" name="pharmLicNum"/>
                            </p>
                            <p>
                                <label>Pharmacist ID:</label>
                                <input type="text" id="textbox" name="pharmID"/>
                            </p>
                            <p>
                                <label>Doctor License Number:</label>
                                <input type="text" id="textbox" name="docLicNum"/>
                            </p>
                            <p>
                                <label>Prescriber Name :</label>
                                <input type="text" id="textbox" name="prescibeName"/>
                            </p>
                            <p>
                                <label>Drug Identification Number DIN:</label>
                                <input type="text" id="textbox" name="DINum"/>
                            </p>
                            <p>
                                <label>Prescription Number:</label>
                                <input type="text" id="textbox" name="rxNum"/>
                            </p>
                            <p>
                                <label>Fill Status :</label>
                                <select name="fillStatus">
                                    <option value="1">Filled</option>
                                    <option value="2">Unfilled</option>
                                </select>
                            </p>
                            <p>
                                <label>Date Received :</label>
                                <input type="text" id="textbox" name="recDate"/>
                            </p>
                            <p>
                                <label>Prescriber Instructions :</label>
                                <input type="text" id="textbox" name="instruct"/>
                            </p>
                            <p>
                                <label>Last Fill Date :</label>
                                <input type="text" id="textbox" name="lastFillDate"/>
                            </p>
                            <p>
                                <label>Last Fill Quantity :</label>
                                <input type="text" id="textbox" name="lastFillQuantity"/>
                            </p>


                            <input type="submit" value="Add"/>
                            <br>
                    </form>
            </div>
    </body>
</html>
