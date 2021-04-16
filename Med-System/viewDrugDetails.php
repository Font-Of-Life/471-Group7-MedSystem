
<?php
    session_start();

    include("connections.php");
    include("LoginChecker.php");

    $userDataSessions = isLoggedIn($conn);
    $drugDIN = $_SESSION['DIN'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Patient Details</title>
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
        </div>
        <div>
            <center><h1>Drug <?php echo $drugDIN?></h1></center>
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
    $queryDrugGet = "select * from drug_profile where DIN = '$drugDIN'";
    $queryDrugRes = mysqli_query($conn, $queryDrugGet);

    //checks to see if the query returned is not empty
    if(mysqli_num_rows($queryDrugRes) > 0){
        //if it isnt, then it fetches the data on that patient retrieved from the sql database
        $DrugData = mysqli_fetch_assoc($queryDrugRes);
        
        //reference:
        //php printing stuff: https://code-boxx.com/display-php-variables-in-html/
        
        //saving the following things into variables from the sql database
        $color="black";
        $DINum = $DrugData['DIN'];
        $drugName = $DrugData['Drug_Name'];
        $drugGenericName = $DrugData['Drug_Generic_Name'];
        $drugPackSize = $DrugData['Pack_Size'];
        $drugSellPrice = $DrugData['Sell_Price'];
        $drugBuyPrice = $DrugData['Bought_Price'];
        $drugInventory = $DrugData['Current_Inventory'];
        $drugSupplier = $DrugData['Supplier'];
        $drugImage = $DrugData['Drug_Image'];
        $drugSchedule = $DrugData['Schedule'];
        $drugStrength = $DrugData['Strength'];
        $drugCreation = $DrugData['Date_Created'];
        $userid = $DrugData['UserID'];

        //checks to see if the drug image variable is null if it is assign it to be equal to none
        if($drugImage == NULL){
            $drugImage = "none";
        }

        if($drugCreation == NULL){
            $drugCreation = "none";
        }
        
        //displays the data to the html
        echo "<p>Drug Identification Number (DIN): $DINum</p>";
        echo "<p>Drug Name: $drugName</p>";
//         //reference for text outline/shadow for COVID Status: https://stackoverflow.com/questions/4919076/outline-effect-to-text
//         echo "<p style='color:$color; text-weight: bold; text-shadow: -1px -1px 0 #000, 0.8px -1px 0 #000, -1px 0.8px 0 #000, 0.8px 0.8px 0 #000;'> COVID Status: $covidStat</p>";
        echo "<p>Generic Name: $drugGenericName</p>";
        echo "<p>Drug Strength: $drugStrength</p>";
        echo "<p>Drug Schedule: $drugSchedule</p>";
        echo "<p>Drug Pack Size: $drugPackSize</p>";
        echo "<p>Drug Sell Price: $drugSellPrice</p>";
        echo "<p>Drug Bought Price: $drugBuyPrice</p>";
        echo "<p>Current Inventory: $drugInventory</p>";
        echo "<p>Supplier: $drugSupplier</p>";
        echo "<p>Drug Image: $drugImage</p>";
        echo "<p>Drug Profile Created: $drugCreation</p>";
        echo "<p>UserID of User Who created this drug profile: $userid</p>";

//         //displays the allergy section of the patient
//         echo "<h2>Allergy List</h2>";
//         //gets the allergy data of the patient from the sql database
//         //$getAllergy = "select * from can_have where Gov_HealthCard_Num = '$healthcard'";
//         $allergyQueryRes = mysqli_query($conn, $getAllergy);
        
//         //checks to see if the query retrieved is not empty
//         if(mysqli_num_rows($allergyQueryRes)>0){
//             //loops through all the entries in the table to display all the allergies of the patient
//             while($row = mysqli_fetch_assoc($allergyQueryRes)){
//                 $allergicTo = $row['Ingredient_Name'];
//                 echo "<p>$allergicTo</p>";
//             }
//         }
//         else {
//             //else this means the patient has no allergies so display a message saying none.
//             echo "<p>None</p>";
//         }

        //displays the drug prescription section of the patient
//        echo "<h2>Drug Prescription List</h2>";
        //retrieve the drug prescriptions the patient has from the sql database
        //$getDrugPresription = "select * from drug_prescription where Patient_HealthCard_Num = '$healthcard'";
        //$drugPrescriptionQuery = mysqli_query($conn,$getDrugPresription);
        
        //checks to see if the query recieved is not empty
//         if(mysqli_num_rows($drugPrescriptionQuery)>0){
//             //if it isnt loops through all the patient's drug prescription entries, and prints it out onto the html
//             while($row = mysqli_fetch_assoc($drugPrescriptionQuery)){
//                 //saves the data from the table into these variables
//                 $DIN = $row['DIN'];
//                 $PharmLicenseNumber = $row['PharmLicense_Num'];
//                 $PharmID = $row['PharmID'];
//                 $PrescriberName = $row['Prescriber_Name'];
//                 $RX_Number = $row['RX_Number'];
//                 $FillStat = $row['Fill_Status'];
//                 $Date_Recieved = $row['Date_Recieved'];
//                 $Instruction = $row['Instruction'];
//                 $DateLastFilled = $row['Date_Last_Filled'];
//                 $AmountLastFilled = $row['Amount_Last_Filled'];
//                 $DocLicenseNum = $row['DocLicense_Num'];
//
//                 //prints out the data saved in the variables into the html
//                 echo "<p>Prescribed By Doctor: $PrescriberName</p>";
//                 echo "<p>Prescriber Doctor License Number: $DocLicenseNum</p>";
//                 echo "<p>Pharmacist ID who gives prescription: $PharmID</p>";
//                 echo "<p>Pharmacist License Number: $PharmLicenseNumber</p>";
//                 echo "<p>Date Recieved: $Date_Recieved</p>";
//                 echo "<p>Drug ID: $DIN</p>";
//                 echo "<p>RX_Number: $RX_Number</p>";
//                 echo "<p>Fill Status: $FillStat</p>";
//                 echo "<p>Date Last Filled: $DateLastFilled</p>";
//                 echo "<p>Amount Last Filled: $AmountLastFilled</p>";
//                 echo "<p>Instructions: $Instruction</p>";
//             }
//         }
//         else {
//             //else this means the patient has no current drug prescriptions, so displays that message to the html
//             echo "<p>No Drug Prescriptions.</p>";
//         }

        //retrieves and displays the information of the patient's dependents
//         echo "<h2>Dependent List</h2>";
//         //retrieve the data of the patient's dependents from the sql database
//         $getPatientDependents = "select * from dependent where Parent_HealthCard_Num = '$healthcard'";
//         $patientDependentQuery = mysqli_query($conn, $getPatientDependents);
//
//         //checks to see if the table returned by the sql database is empty
//         if(mysqli_num_rows($patientDependentQuery) > 0){
//             //if it isnt loops through all the rows of the table retrieved from the sql database on that patient's dependents
//             while($row = mysqli_fetch_assoc($patientDependentQuery)){
//                 //saves the data to these variables to print them
//                 $depName = $row['First_Name']." ".$patientDependentQuery['Last_Name'];
//                 $DepRelationship = $row['Relationship'];
//
//                 //displays the information from the variables onto the html
//                 echo "<p>Dependent Name: $depName</p>";
//                 echo "<p>Dependent Relationship: $DepRelationship</p>";
//             }
//         }
//         else{
//             //else this means that the patient has no dependents, so prints a message to the html about it
//             echo "<p>No Dependents</p>";
//         }
        
//         //displays the insurance section of the patient
//         echo "<h2>Insurance</h2>";
//         //retrieves the data regarding the patient's insurance from the sql database
//         $getPatientInsurance = "select * from `insurance plan` where Policy_Holder_Health_Num ='$healthcard'";
//         $insuranceQueryRes = mysqli_query($conn, $getPatientInsurance);
//
//         //checks to see if the recieved table from the sql database is empty
//         if(mysqli_num_rows($insuranceQueryRes)>0){
//             //if it isnt saves the data from the table into the following variables
//             $policyNum = $insuranceQueryRes['Policy_Number'];
//             $InsCompanyName = $insuranceQueryRes['Company'];
//             $Start_Date = $insuranceQueryRes['Start_Date'];
//             $EndDate = $insuranceQueryRes['End_Date'];
//
//             //displays the information stored in each variable onto the html
//             echo "<p>Insurance Policy Number: $policyNum</p>";
//             echo "<p>Insurance Company Name: $InsCompanyName</p>";
//             echo "<p>Start Date: $Start_Date</p>";
//             echo "<p>End Date: $EndDate</p>";
//         }
//         else{
//             //else this means the patient has no insurance so display a message about it.
//             echo "<p>No insurance Plan</p>";
//         }
    } 
    else {
        //else this means something has happened with that patient's data, so display a error message regarding not able to find it.
        echo"<p>There was an problem retrieving this information.</p>";
    }
?>
