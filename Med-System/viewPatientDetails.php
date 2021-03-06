
<?php
    session_start();

    include("connections.php");
    include("LoginChecker.php");
    $fileName = 'jsonfile.json';

    $userDataSessions = isLoggedIn($conn);

    $patientHealthCardNum = $_SESSION['Gov_HealthCard_Num'];
    if($patientHealthCardNum == NULL){
        $patientHealthCardNum = isset($_GET['govID']) ? mysqli_real_escape_string($conn, $_GET['govID']) :  "";
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

        #buttonStuff{
            margin-left: 10px;
            background-color: #0BDA51;
            color: black;
            font-size: 14px;
            
            border: 2px solid black;
            border-radius: 1px solid black;
            cursor: pointer;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        #formbox{
            /*Reference for code used in vertical and horizontal aligment by user Mr Bullets: 
                -> https://stackoverflow.com/questions/19461521/how-to-center-an-element-horizontally-and-vertically */
            text-align: center;
            margin: 0 auto;
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
            <a href="<?php echo "viewPrescriptionDetails.php?Gov_HealthCard_Num=".urlencode($patientHealthCardNum)?>">View Patient Prescriptions</a>
            <a href="viewDependentsDetails.php">View Patient Dependents</a>
            <a href="viewAllergyDetails.php">View Patient Allergies</a>
            <a href="viewInsuranceDetails.php">View Insurance Details</a>
        </div>

        <div id="formbox">
            <form method="post" action="">
                <label>Edit:</label>
                <select name="edit">
                    <option value="<?php echo "PProf".$patientHealthCardNum;?>">Patient Profile</option>
                    <option value="<?php echo "Depen".$patientHealthCardNum;?>">Dependent</option>
                    <option value="<?php echo "Insur".$patientHealthCardNum;?>">Insurance</option>
                    <?php if($isPharm){?>
                    <option value="<?php echo "DrugP".$patientHealthCardNum;?>">Drug Prescription</option>
                    <option value="<?php echo "Aller".$patientHealthCardNum;?>">Allergies</option>
                    <?php }?>
                </select>

                <input id = "buttonStuff" type="submit" name="editButton" value="Edit">

                
            </form>
            
        </div>
        <h1 style="text-align: center;">Patient <?echo $patientHealthCardNum?> Details:</h1>
    </body>
</html>

<?php
    $dataArr = array();
    //does nothing so far/doesnt work, figure out how to get the edit button to work corresponding to each dropdown option
    //the html section for it just control f the word "edit" in this document and that section corresponds to the one being responded by this
    if (isset($_POST['editButton'])) {
        $optionSelected = substr(($_POST['edit']),0,5);
        $hcNum = substr(($_POST['edit']),5);

        $_SESSION['HC'] = $hcNum;
        $checkid = $userDataSessions['UserID'];
        
        $checkQuery = "select * from pharmacist where PharmID = '$checkid'";
        $checkQueryResult = mysqli_query($conn, $checkQuery);
        if($optionSelected == "PProf"){
            //set session variables for the property that was clicked
            // then redirect to viewProperty page
            header("Location: editPatientProfile.php");
            die;
        }
        else if($optionSelected == "Depen"){
            header("Location: editDependentDetails.php");
            die;
        }
        else if($optionSelected == "Insur"){
            //set session variables for the property that was clicked
            // then redirect to viewProperty page
            header("Location: editInsuranceDetails.php");
            die;
        }
        else if($optionSelected == "Aller"){
            //set session variables for the property that was clicked
            // then redirect to viewProperty page

            header("Location: editAllergyDetails.php");
            die;
        } 
        else {
              header("Location: editDrugPrescription.php");
              die;    
        }
		
    }
    //gets the query data from the sql database of the current selected patient in the patient profile table 
    $stmt = $conn->prepare('SELECT * FROM patient_profile WHERE Gov_HealthCard_Num = ?');
    $stmt->bind_param('i', $patientHealthCardNum); // 'i' specifies the variable type => 'integer'
    $stmt->execute();
    $queryPatientRes = $stmt->get_result();

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

        $dataArr["Patient Details: "] = array(
            "Government Healthcard Num: " => $healthcard,
            "first name: " => $PatientData['First_Name'],
            "last name: " => $PatientData['Last_Name'],
            "COVID Status: " => $covidStat,
            "Weight: " => $weight,
            "height: " => $height,
            "Preferred Language: " => $prefLang,
            "Sex: " => $sex,
            "Phone: " => $phone,
            "Address: " => $Address,
            "ProviderNotes: " => $ProviderNotes,
            "Email: " => $email,
            "birthday: " => $birthday,
            "userid: " => $userid
        );
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
            $color = "red";
        } 
        //checks to see if the covid status of the current patient is negative, if it is save the value of red to it.
        else if($covidStat == "Negative"){
            $color = "lime";
        }
        //else it means it is pending, so save the value of yellow to it.
        else{
            $color = "yellow";
        }
        
        //displays the data to the html
        echo "<p style='text-align: center;  font-size: 16px;'>Patient Health Card Number: $healthcard</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Patient Name: $name</p>";
        //reference for text outline/shadow for COVID Status: https://stackoverflow.com/questions/4919076/outline-effect-to-text
        echo "<p style='text-align: center; font-weight: bold; font-size: 16px; color:$color; text-weight: bold; text-shadow: -1px -1px 0 #000, 0.8px -1px 0 #000, -1px 0.8px 0 #000, 0.8px 0.8px 0 #000;'> COVID Status: $covidStat</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Sex: $sex</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Birthday: $birthday</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Weight: $weight</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Height: $height</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Preferred Language: $prefLang</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Address: $Address</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Phone: $phone</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Email: $email</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Provider Notes: $ProviderNotes</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>UserID of User Who created this profile: $userid</p>";

        //displays the allergy section of the patient
        echo "<h2 style='text-align: center;'>Allergy List</h2>";
        //gets the allergy data of the patient from the sql database
        $getAllergy = "select * from can_have where Gov_HealthCard_Num = '$healthcard'";
        $allergyQueryRes = mysqli_query($conn, $getAllergy);
        
        //checks to see if the query retrieved is not empty
        if(mysqli_num_rows($allergyQueryRes)>0){
            //loops through all the entries in the table to display all the allergies of the patient
            $counter = 0; 
            while($row = mysqli_fetch_assoc($allergyQueryRes)){
                $counter += 1;
                $index = "Patient Allergy ".$counter;
                $DataArr[$index] = array("Allergy To: " => $row['Ingredient_Name']);
                $allergicTo = $row['Ingredient_Name'];
                echo "<p style='text-align: center;  font-size: 16px;'>$allergicTo</p>";
            }        
        } 
        else {
            //else this means the patient has no allergies so display a message saying none.
            echo "<p style='text-align: center;  font-size: 16px;'>None</p>";
            $dataArr["Patient Allergy: "] = array("message: " => "None.");
        }

        //displays the drug prescription section of the patient
        echo "<h2 style='text-align: center;'>Drug Prescription List</h2>";
        //retrieve the drug prescriptions the patient has from the sql database
        $getDrugPresription = "select * from drug_prescription where Patient_HealthCard_Num = '$healthcard'";
        $drugPrescriptionQuery = mysqli_query($conn,$getDrugPresription);
        
        //checks to see if the query recieved is not empty
        if(mysqli_num_rows($drugPrescriptionQuery)>0){
            //if it isnt loops through all the patient's drug prescription entries, and prints it out onto the html
            $counter = 0;
            while($row = mysqli_fetch_assoc($drugPrescriptionQuery)){
                $counter += 1;
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
                echo "<p style='text-align: center;  font-size: 16px;'>Drug ID: $DIN</p>";
                echo "<p style='text-align: center;  font-size: 16px;'>RX_Number: $RX_Number</p>";
                echo "<p style='text-align: center;  font-size: 16px;'>Fill Status: $FillStat</p>";
                echo "<p style='text-align: center;  font-size: 16px;'>Instructions: $Instruction</p>";
            }
        } 
        else {
            //else this means the patient has no current drug prescriptions, so displays that message to the html
            $dataArr["Patient Prescription: "] = array("message"=>"No Drug Prescriptions.");
            echo "<p style='text-align: center;  font-size: 16px;'>No Drug Prescriptions.</p>";
        }

        //retrieves and displays the information of the patient's dependents
        echo "<h2 style='text-align: center;'>Dependent List</h2>";
        //retrieve the data of the patient's dependents from the sql database
        $getPatientDependents = "select * from dependent where Parent_HealthCard_Num = '$healthcard'";
        $patientDependentQuery = mysqli_query($conn, $getPatientDependents);

        //checks to see if the table returned by the sql database is empty
        if(mysqli_num_rows($patientDependentQuery) > 0){
            $DependentData = mysqli_fetch_assoc($patientDependentQuery);

            //saves the data to these variables to print them
            $color="black";
            $depName = $DependentData['First_Name']." ".$DependentData['Last_Name'];
            $DepRelationship = $DependentData['Relationship'];
            
            $dataArr["Patient Dependent Info: "] = array(
                "Dependent First Name: " => $DependentData['First_Name'],
                "Dependent Last Name: " =>$DependentData['Last_Name'],
                "Relationship: " => $DependentData['Relationship']
            );

            //displays the information from the variables onto the html
            echo "<p style='text-align: center;  font-size: 16px;'>Dependent Name: $depName</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Dependent Relationship: $DepRelationship</p>";
        }
        else{
            //else this means that the patient has no dependents, so prints a message to the html about it
            $dataArr["Patient Dependent Info: "] = array("Message:"=>"No Dependents.");
            echo "<p style='text-align: center;  font-size: 16px;'>No Dependents</p>";
        }
        
        //displays the insurance section of the patient
        echo "<h2 style='text-align: center;'>Insurance</h2>";
        //retrieves the data regarding the patient's insurance from the sql database
        $getPatientInsurance = "select * from `insurance_plan` where Policy_Holder_Health_Num ='$healthcard'";
        $insuranceQueryRes = mysqli_query($conn, $getPatientInsurance);
        
        //checks to see if the received table from the sql database is empty
        if(mysqli_num_rows($insuranceQueryRes) > 0){
            //if it isnt saves the data from the table into the following variables
            $InsuranceData = mysqli_fetch_assoc($insuranceQueryRes);

            $color="black";
            $policyNum = $InsuranceData['Policy_Number'];
            $InsCompanyName = $InsuranceData['Company'];
            $Start_Date = $InsuranceData['Start_Date'];
            $EndDate = $InsuranceData['End_Date'];

            $dataArr["Patient Insurance Info: "] = array(
                "policyNum: " => $InsuranceData['Policy_Number'],
                "Insurance Company Name: " => $InsuranceData['Company'],
                "Start_Date: " => $InsuranceData['Start_Date'],
                "EndDate: " => $InsuranceData['End_Date']
            );

            //displays the information stored in each variable onto the html
            echo "<p style='text-align: center;  font-size: 16px;'>Insurance Policy Number: $policyNum</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Insurance Company Name: $InsCompanyName</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>Start Date: $Start_Date</p>";
            echo "<p style='text-align: center;  font-size: 16px;'>End Date: $EndDate</p>";
        }
        else{
            //else this means the patient has no insurance so display a message about it.
            echo "<p style='text-align: center;  font-size: 16px;'>No insurance Plan</p>";
            $dataArr["Patient Insurance Info: "] = array("Message: " => "No Insurance Plan.");
        }
    } 
    else {
        //else this means something has happened with that patient's data, so display a error message regarding not able to find it.
        echo"<p style='text-align: center;  font-size: 16px;'>There was an problem retrieving this information.</p>";
        $encodeJson = json_encode("There was an problem retrieving this information.");
        file_put_contents($fileName,$encodeJson);
    }
    $encodeJson = json_encode($dataArr);
    file_put_contents($fileName,$encodeJson);
?>
