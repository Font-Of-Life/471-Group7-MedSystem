
<?php
    session_start();

    include("connections.php");
    include("LoginChecker.php");

    $userDataSessions = isLoggedIn($conn);
    $healthcard = $_SESSION['Gov_HealthCard_Num'];
    if($healthcard == NULL){
        $healthcard = $_GET['Gov_HealthCard_Num'];
    }
    $idGetter = $userDataSessions['UserID'];
    $queryChecker = "select * from pharmacist where PharmID = '$idGetter'";
    $queryCheckResult = mysqli_query($conn, $queryChecker);
    if(mysqli_num_rows($queryCheckResult) > 0) {
        $isPharm = true;
    }  
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>View Patient Prescriptions</title>
        <link rel="stylesheet" type="text/css" href = "style.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
            <a href="patientSearch.php">Patient Search</a>
            <a href="registerPatient.php">Add Patient Profile</a>
            <a href="drugSearch.php">Drug Search</a>
            <?php if($isPharm){
                ?>
            <a href="registerDrug.php">Add Drug Profile</a>
            <a href="registerPrescriptions.php">Add Prescriptions</a>
            <?php } ?>
        </div>
        <div>
            <center><h1>Patient <?php echo $drugDIN?> Prescription: </h1></center>
        </div>
        <div>

    </div>
    </body>
</html>

<?php
    $fileName = 'jsonfile.json';
    $dataArr = array();
    //gets the query data from the sql database of the current selected drug in the drug profile table
    $getDrugPresription = "select * from drug_prescription where Patient_HealthCard_Num = '$healthcard'";
    $drugPrescriptionQuery = mysqli_query($conn,$getDrugPresription);

    //checks to see if the query recieved is not empty
    if(mysqli_num_rows($drugPrescriptionQuery)>0){
        //if it isnt loops through all the patient's drug prescription entries, and prints it out onto the html
        echo "<h2 style='text-align: center;'>Prescriptions List</h2>";
        $PrescriptionData = mysqli_fetch_assoc($drugPrescriptionQuery);
        $counter = 0;
        while($row = mysqli_fetch_assoc($drugPrescriptionQuery)){
            $counter += 1;
            $DIN = $row['DIN'];
            $PharmLicenseNumber = $row['PharmLicense_Num'];
            $PharmID = $row['PharmID'];
            $PrescriberName = $row['Prescriber_Name'];
            $RX_Number = $row['RX_Number'];
            $FillStat = $row['Fill_Status'];
            $Date_Recieved = $row['Date_Recieved'];
            $Instruction = $row['Instruction'];
            $DateLastFilled = $row['Date_Last_Filled'];
            $AmountLastFilled = $row['Amount_Last_Filled'];
            $DocLicenseNum = $row['DocLicense_Num'];

            $dataArr["Patient Prescription ".$counter.": "] = array(
                "DIN: " => $row['DIN'],
                "PharmLicenseNumber: " => $row['PharmLicense_Num'],
                "PharmID: " => $row['PharmID'],
                "PrescriberName: " => $row['Prescriber_Name'],
                "RX_Number: " => $row['RX_Number'],
                "FillStat: " => $row['Fill_Status'],
                "Date_Recieved: " => $row['Date_Recieved'],
                "Instruction: " => $row['Instruction'],
                "DateLastFilled: " => $row['Date_Last_Filled'],
                "AmountLastFilled: " => $row['Amount_Last_Filled'],
                "DocLicenseNum: " => $row['DocLicense_Num']
            );

            //prints out the data saved in the variables into the html
            echo "<p style='text-align: center;  font-size: 16px;'>Prescribed By Doctor: $PrescriberName</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Prescriber Doctor License Number: $DocLicenseNum</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Pharmacist ID who gives prescription: $PharmID</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Pharmacist License Number: $PharmLicenseNumber</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Date Recieved: $Date_Recieved</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Drug ID: $DIN</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>RX_Number: $RX_Number</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Fill Status: $FillStat</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Date Last Filled: $DateLastFilled</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Amount Last Filled: $AmountLastFilled</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Instructions: $Instruction</p>";
        }
        $encodeJson = json_encode($message);
        file_put_contents($fileName,$encodeJson);
    } 
    else {
        //else this means the patient has no current drug prescriptions, so displays that message to the html
        echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>No Drug Prescriptions.</p>";
        $encodeJson = json_encode("No Drug Prescriptions.");
        file_put_contents($fileName,$encodeJson);
    }
?>
