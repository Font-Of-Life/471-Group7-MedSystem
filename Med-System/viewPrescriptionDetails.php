
<?php
    session_start();

    include("connections.php");
    include("LoginChecker.php");

    $userDataSessions = isLoggedIn($conn);
    $healthcard = $_SESSION['Gov_HealthCard_Num'];
    if($healthcard == NULL){
        $healthcard = $_GET['Gov_HealthCard_Num'];
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
            <a href="registerDrug.php">Add Drug Profile</a>
            <a href="registerPrescriptions.php">Add Prescriptions</a>
        </div>
        <div>
            <center><h1>Patient <?php echo $drugDIN?> Prescription: </h1></center>
        </div>
        <div>

    </div>
    </body>
</html>

<?php
    //does nothing so far/doesnt work, figure out how to get the edit button to work corresponding to each dropdown option
    //the html section for it just control f the word "edit" in this document and that section corresponds to the one being responded by this
    /* if($_SERVER['REQUEST_METHOD'] == "POST"){
        $editChoice = $_POST['edit'];
        if($editChoice == "PatientProfile"){
            $_SESSION['Gov_HealthCard_Num'] = $drugDIN;
            header("Location: editPatientProfile.php");
            die;
        }
    } */
    //gets the query data from the sql database of the current selected drug in the drug profile table
    $getDrugPresription = "select * from drug_prescription where Patient_HealthCard_Num = '$healthcard'";
    $drugPrescriptionQuery = mysqli_query($conn,$getDrugPresription);

    //checks to see if the query recieved is not empty
    if(mysqli_num_rows($drugPrescriptionQuery)>0){
        //if it isnt loops through all the patient's drug prescription entries, and prints it out onto the html
        echo "<h2 style='text-align: center;'>Prescriptions List</h2>";
        $PrescriptionData = mysqli_fetch_assoc($drugPrescriptionQuery);

        $DIN = $PrescriptionData['DIN'];
        $PharmLicenseNumber = $PrescriptionData['PharmLicense_Num'];
        $PharmID = $PrescriptionData['PharmID'];
        $PrescriberName = $PrescriptionData['Prescriber_Name'];
        $RX_Number = $PrescriptionData['RX_Number'];
        $FillStat = $PrescriptionData['Fill_Status'];
        $Date_Recieved = $PrescriptionData['Date_Recieved'];
        $Instruction = $PrescriptionData['Instruction'];
        $DateLastFilled = $PrescriptionData['Date_Last_Filled'];
        $AmountLastFilled = $PrescriptionData['Amount_Last_Filled'];
        $DocLicenseNum = $PrescriptionData['DocLicense_Num'];

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
    else {
        //else this means the patient has no current drug prescriptions, so displays that message to the html
        echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>No Drug Prescriptions.</p>";
    }
?>
