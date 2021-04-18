<?php
session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");

    $patientHealthCardNum = $_SESSION['HC'];
    $pharmID = $_SESSION['UserID'];


    // using SERVER to check if the user has clicked on the post button (if request method = POST)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html section below
        $docLicNum = $_POST['docLicNum'];
        $prescibeName = $_POST['prescibeName'];
        $DINum = $_POST['DINum'];
        $rxNum = $_POST['rxNum'];
        $fillStatus = $_POST['fillStatus'];
        $recDate = $_POST['recDate'];
        $instruct = $_POST['instruct'];
        $lastFillDate = $_POST['lastFillDate'];
        $lastFillQuantity = $_POST['lastFillQuantity'];
        // $healthcard = $_POST['healthcard'];
        //$pharmLicNum = $_POST['pharmLicNum'];
        //$pharmID = $_POST['pharmID'];

        $message = "before first if statement";

        //Patient_HealthCard_Num, PharmLicense_Num, PharmID, DocLicense_Num, Prescriber_Name, DIN, RX_Number, Fill_Status, Date_Recieved,
        //Instruction, Date_Last_Filled, Amount_Last_Filled
        // $pharmLicNum, $pharmID, $docLicNum, $prescibeName, $DINum, $rxNum, $fillStatus, $recDate, $instruct, $lastFillDate, $lastFillQuantity

        // if not empty and it is valid, then do the following
        //if (!empty($DINum) && !empty($drugName) && !empty($drugGenericName)) {//&& !empty($drugPackSize) && !empty($drugSellPrice) && !empty($drugBuyPrice) && !empty($drugInventory) && !empty($drugStrength) && !empty($drugCreation) && !empty($userid)) {
        if (!empty($DINum)&&!empty($patientHealthCardNum)&& !empty($rxNum)) {
            //$message = "Passed first if statement";
            if(is_numeric($DINum)&&is_numeric($patientHealthCardNum)&&is_numeric($rxNum)) {//&& is_numeric($userid) && is_numeric($drugPackSize) && is_numeric($drugSellPrice) && is_numeric($drugBuyPrice) && is_numeric($drugInventory) && is_numeric($drugStrength)){
                $conditionalQuery = "select * from drug_profile where DIN = '$DINum'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);

                $queryPatientGet = "select * from patient_profile where Gov_HealthCard_Num = '$patientHealthCardNum'";
                $queryPatientRes = mysqli_query($conn, $queryPatientGet);

                $conditionalQuery3 = "select * from doctor where Doctor_LicenseNum = '$docLicNum'";
                $CondQueryRes3 = mysqli_query($conn, $conditionalQuery3);

                $conditionalQuery5 = "select * from prescriber where Prescriber_Name = '$prescibeName'";
                $CondQueryRes5 = mysqli_query($conn, $conditionalQuery5);

                $conditionalQuery6 = "select * from drug_prescription where RX_Number = '$rxNum'";
                $CondQueryRes6 = mysqli_query($conn, $conditionalQuery6);

                $message='Patient'.$patientHealthCardNum;

                if(mysqli_num_rows($CondQueryRes6)>0){
                    $message = "rx Number already exist, cannot add duplicate prescription";
                }
                else{
                    $erro = 0;
                    if(mysqli_num_rows($CondQueryRes) <= 0){
                        $message .= "Drug does not exist, try again.\n";
                        $error=1;
                    }
                    if((mysqli_num_rows($queryPatientRes) <= 0)){
                        $message .= "Patient does not exist, try again.\n";
                        $error=1;

                    }

                    if((!empty($docLicNum) && (mysqli_num_rows($CondQueryRes3) <= 0))){
                        $message .= "Doctor License number does not exist, try again.\n";
                        $error=1;
                    }
                    if((!empty($prescibeName) && (mysqli_num_rows($CondQueryRes5) <= 0)) ){
                        $message .= "Prescriber does not exist, try again.\n";
                        $error=1;
                    }

                    if($error == 0){
                        //get user's pharmacy license number
                        $queryPharmLicnsenGet = "select PharmLicense_Num from pharmacist where PharmID = '$pharmID'";
                        $queryPharmLicnsenRes = mysqli_query($conn, $conditionalQuery4);
                        $pharmLicNum = mysqli_fetch_assoc($queryPharmLicnsenRes)['PharmLicense_Num'];
        
                        //Set to null if empty form
                        $docLicNum = !empty($docLicNum) ? "'$docLicNum'" : "NULL";
                        $prescibeName = !empty($prescibeName) ? "'$prescibeName'" : "NULL";
                        $recDate = !empty($recDate) ? "'$recDate'" : "NULL";
                        $lastFillDate = !empty($lastFillDate) ? "'$lastFillDate'" : "NULL";
                        $lastFillQuantity = !empty($lastFillQuantity) ? "'$lastFillQuantity'" : "NULL";



                        //register the following values into the prescrption table
                        //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                        $checkQuery = "select * from drug_prescription where Patient_HeathCard_Num = '$patientHealthCardNum'";
                        $getCheckQuery = mysqli_query($conn, $checkQuery);
                        if(mysqli_num_rows($getCheckQuery) > 0){
                            $queryRes = "update drug_prescription set PharmLicense_Num = '$pharmLicNum', PharmID ='$pharmID', DocLicense_Num = '$docLicNum', Prescriber_Name = '$prescibeName', DIN = '$DINum', RX_Number = '$rxNum', Fill_Status = '$fillStatus', Date_Recieved = '$recDate' , Instruction = '$instruct', Date_Last_Filled = '$lastFillDate', Amount_Last_Filled = '$lastFillQuantity' where Patient_HealthCard_Num ='$patientHealthCardNum'";
                            mysqli_query($conn, $queryRes);
                        }
                        else{
                            $queryRes = "insert into drug_prescription (Patient_HealthCard_Num, PharmLicense_Num, PharmID, DocLicense_Num, Prescriber_Name, DIN, RX_Number, Fill_Status, Date_Recieved, Instruction, Date_Last_Filled, Amount_Last_Filled) values ('$patientHealthCardNum', $pharmLicNum, $pharmID, $docLicNum, $prescibeName, '$DINum', '$rxNum', '$fillStatus', $recDate,'$instruct', $lastFillDate, $lastFillQuantity)";
                            mysqli_query($conn, $queryRes);
                        }
                        
                        header("Location: viewPatientDetails.php");
                        exit;
                    }else{
                        $message = "Error in submitting data";
                    }


                }
            } 
            else {
                //echo "TechID, Phone number, health card number were not numerical values, try again.";
                $message = "Prescription Number, DIN, Health Care card Number were not numerical values, try again.";
            }
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "Prescription Number, DIN, Health Care card Number can't be empty";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
            <title>Prescription Edit</title>
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
            width: 30%;
            padding: 3%;
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
                            <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Prescription Edit</div>
                            <p><?php echo $pharmLicNum, 'Presecription for patient with health card number: ', $patientHealthCardNum?></p>
                            <p>
                                <label>Prescription Number:</label>
                                <input type="text" id="textbox" name="rxNum"/>
                            </p>
                            <p>
                                <label>Drug Identification Number DIN:</label>
                                <input type="text" id="textbox" name="DINum"/>
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


                            <input type="submit" value="Add" id="buttonStuff"/>
                            <br>
                    </form>
            </div>
    </body>
</html>
