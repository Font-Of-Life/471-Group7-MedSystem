
<?php
    session_start();

    include("connections.php");
    include("LoginChecker.php");

    $userDataSessions = isLoggedIn($conn);
    $patientHealthCardNum = $_SESSION['Gov_HealthCard_Num'];
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
        </div>
        <div>
            <center><h1>Patient <?php echo $patientHealthCardNum?></h1></center>
        </div>
        <div>
            <form>
                <label>Edit:</label>
                <select name="edit">
                    <option value="PatientProfile">Patient Profile</option>
                    <option value="Dependent">Dependent</option>
                    <option value="Insurance">Insurance</option>
                    <option value="DrugPres">Drug Prescription</option>
                    <option value="Allergies">Allergies</option>
                </select>
                <input type="submit" name="submit" value="Edit">
            </form>
            
        </div>
    </body>
</html>

<?php
    //does nothing so far/doesnt work, figure out how to get the edit button to work corresponding to each dropdown option
    //the html section for it just control f the word "edit" in this document and that section corresponds to the one being responded by this
    /* if($_SERVER['REQUEST_METHOD'] == "POST"){
        $editChoice = $_POST['edit'];
        if($editChoice == "PatientProfile"){
            $_SESSION['Gov_HealthCard_Num'] = $patientHealthCardNum;
            header("Location: editPatientProfile.php");
            die;
        }
    } */
    //gets the query data from the sql database of the current selected patient in the patient profile table 
    $queryPatientGet = "select * from patient_profile where Gov_HealthCard_Num = '$patientHealthCardNum'";
    $queryPatientRes = mysqli_query($conn, $queryPatientGet);

    //checks to see if the query returned is not empty
    if(mysqli_num_rows($queryPatientRes) > 0){
        //if it isnt, then it fetches the data on that patient retrieved from the sql database
        $PatientData = mysqli_fetch_assoc($queryPatientRes);
        
        //reference:
        //php printing stuff: https://code-boxx.com/display-php-variables-in-html/
        
        //saving the following things into variables from the sql database
        $color="black";
        $healthcard = $PatientData['Gov_HealthCard_Num'];
        $name = $PatientData['First_Name']." ".$PatientData['Last_Name'];
        $covidStat = $PatientData['COVID_Test_Result'];
        $weight = $PatientData['Weight'];
        $height = $PatientData['Height'];
        $prefLang = $PatientData['Preferred_Language'];
        $sex = $PatientData['Sex'];
        $phone = $PatientData['Phone_Number'];
        $Address = $PatientData['Address'];
        $ProviderNotes = $PatientData['Provider_Notes'];
        $email = $PatientData['Email'];
        $birthday = $PatientData['Day_Of_Birth'];
        $userid = $PatientData['UserID'];

        //checks to see if the email variable is null if it is assign it to be equal to none
        if($email == NULL){
            $email = "none";
        }

        //checks to see if the ProviderNotes variable is null if it is assign it to be equal to none
        if($ProviderNotes == NULL){
            $ProviderNotes = "None";
        }

        //checks to see if the covid status of the current patient is positive, if it is save the value of lime to it.
        if($covidStat == "Positive"){
            $color = "lime";
        } 
        //checks to see if the covid status of the current patient is negative, if it is save the value of red to it.
        else if($covidStat == "Negative"){
            $color = "red";
        }
        //else it means it is pending, so save the value of yellow to it.
        else{
            $color = "yellow";
        }
        
        //displays the data to the html
        echo "<p>Patient Health Card Number: $healthcard</p>";
        echo "<p>Patient Name: $name</p>";
        //reference for text outline/shadow for COVID Status: https://stackoverflow.com/questions/4919076/outline-effect-to-text
        echo "<p style='color:$color; text-weight: bold; text-shadow: -1px -1px 0 #000, 0.8px -1px 0 #000, -1px 0.8px 0 #000, 0.8px 0.8px 0 #000;'> COVID Status: $covidStat</p>";
        echo "<p>Sex: $sex</p>";
        echo "<p>Birthday: $birthday</p>";
        echo "<p>Weight: $weight</p>";
        echo "<p>Height: $height</p>";
        echo "<p>Preferred Language: $prefLang</p>";
        echo "<p>Address: $Address</p>";
        echo "<p>Phone: $phone</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Provider Notes: $ProviderNotes</p>";
        echo "<p>UserID of User Who created this profile: $userid</p>";

        //displays the allergy section of the patient
        echo "<h2>Allergy List</h2>";
        //gets the allergy data of the patient from the sql database
        $getAllergy = "select * from can_have where Gov_HealthCard_Num = '$healthcard'";
        $allergyQueryRes = mysqli_query($conn, $getAllergy);
        
        //checks to see if the query retrieved is not empty
        if(mysqli_num_rows($allergyQueryRes)>0){
            //loops through all the entries in the table to display all the allergies of the patient
            while($row = mysqli_fetch_assoc($allergyQueryRes)){
                $allergicTo = $row['Ingredient_Name'];
                echo "<p>$allergicTo</p>";
            }        
        } 
        else {
            //else this means the patient has no allergies so display a message saying none.
            echo "<p>None</p>";
        }

        //displays the drug prescription section of the patient
        echo "<h2>Drug Prescription List</h2>";
        //retrieve the drug prescriptions the patient has from the sql database
        $getDrugPresription = "select * from drug_prescription where Patient_HealthCard_Num = '$healthcard'";
        $drugPrescriptionQuery = mysqli_query($conn,$getDrugPresription);
        
        //checks to see if the query recieved is not empty
        if(mysqli_num_rows($drugPrescriptionQuery)>0){
            //if it isnt loops through all the patient's drug prescription entries, and prints it out onto the html
            while($row = mysqli_fetch_assoc($drugPrescriptionQuery)){
                //saves the data from the table into these variables
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

                //prints out the data saved in the variables into the html
                echo "<p>Prescribed By Doctor: $PrescriberName</p>";
                echo "<p>Prescriber Doctor License Number: $DocLicenseNum</p>";
                echo "<p>Pharmacist ID who gives prescription: $PharmID</p>";
                echo "<p>Pharmacist License Number: $PharmLicenseNumber</p>";
                echo "<p>Date Recieved: $Date_Recieved</p>";
                echo "<p>Drug ID: $DIN</p>";
                echo "<p>RX_Number: $RX_Number</p>";
                echo "<p>Fill Status: $FillStat</p>";
                echo "<p>Date Last Filled: $DateLastFilled</p>";
                echo "<p>Amount Last Filled: $AmountLastFilled</p>";
                echo "<p>Instructions: $Instruction</p>";
            }
        } 
        else {
            //else this means the patient has no current drug prescriptions, so displays that message to the html
            echo "<p>No Drug Prescriptions.</p>";
        }

        //retrieves and displays the information of the patient's dependents
        echo "<h2>Dependent List</h2>";
        //retrieve the data of the patient's dependents from the sql database
        $getPatientDependents = "select * from dependent where Parent_HealthCard_Num = '$healthcard'";
        $patientDependentQuery = mysqli_query($conn, $getPatientDependents);

        //checks to see if the table returned by the sql database is empty
        if(mysqli_num_rows($patientDependentQuery) > 0){
            //if it isnt loops through all the rows of the table retrieved from the sql database on that patient's dependents
            while($row = mysqli_fetch_assoc($patientDependentQuery)){
                //saves the data to these variables to print them
                $depName = $row['First_Name']." ".$patientDependentQuery['Last_Name'];
                $DepRelationship = $row['Relationship'];

                //displays the information from the variables onto the html
                echo "<p>Dependent Name: $depName</p>";
                echo "<p>Dependent Relationship: $DepRelationship</p>";
            }
        }
        else{
            //else this means that the patient has no dependents, so prints a message to the html about it
            echo "<p>No Dependents</p>";
        }
        
        //displays the insurance section of the patient
        echo "<h2>Insurance</h2>";
        //retrieves the data regarding the patient's insurance from the sql database
        $getPatientInsurance = "select * from `insurance plan` where Policy_Holder_Health_Num ='$healthcard'";
        $insuranceQueryRes = mysqli_query($conn, $getPatientInsurance);
        
        //checks to see if the recieved table from the sql database is empty
        if(mysqli_num_rows($insuranceQueryRes)>0){
            //if it isnt saves the data from the table into the following variables
            $policyNum = $insuranceQueryRes['Policy_Number'];
            $InsCompanyName = $insuranceQueryRes['Company'];
            $Start_Date = $insuranceQueryRes['Start_Date'];
            $EndDate = $insuranceQueryRes['End_Date'];

            //displays the information stored in each variable onto the html
            echo "<p>Insurance Policy Number: $policyNum</p>";
            echo "<p>Insurance Company Name: $InsCompanyName</p>";
            echo "<p>Start Date: $Start_Date</p>";
            echo "<p>End Date: $EndDate</p>";
        }
        else{
            //else this means the patient has no insurance so display a message about it.
            echo "<p>No insurance Plan</p>";
        }
    } 
    else {
        //else this means something has happened with that patient's data, so display a error message regarding not able to find it.
        echo"<p>There was an problem retrieving this information.</p>";
    }
?>