
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
            <center><h1>Patient: <?php echo $patientHealthCardNum?></h1></center>
        </div>
        <div>
            <form>
                <a href="viewPatientDetails.php">Back to Patient Profile</a>
                <a href="registerInsurance.php">Add Insurance Information</a>
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
    // 	Policy_Number	Policy_Holder_Health_Num	Company	Start_Date	End_Date
    //gets the query data from the sql database of the current selected patient in the patient profile table 
    $queryPatientGet = "select * from insurance_plan where Policy_Holder_Health_Num = '$patientHealthCardNum'";
    $queryPatientRes = mysqli_query($conn, $queryPatientGet);

    //checks to see if the query returned is not empty
    if(mysqli_num_rows($queryPatientRes) > 0){
        echo "<h2>Insurance Information</h2>";
        $InsuranceData = mysqli_fetch_assoc($queryPatientRes);

        // Policy_Number	Policy_Holder_Health_Num	Company	Start_Date	End_Date
        $color="black";
        $Policy_Number = $InsuranceData['Policy_Number'];
        $Policy_Holder_Health_Num = $InsuranceData['Policy_Holder_Health_Num'];
        $Company = $InsuranceData['Company'];
        $Start_Date = $InsuranceData['Start_Date'];
        $End_Date = $InsuranceData['End_Date'];

        //displays the information from the variables onto the html
        echo "<p>Policy_Number: $Policy_Number</p>";
        echo "<p>Policy Holder Health Card Number: $Policy_Holder_Health_Num</p>";
        echo "<p>Company: $Company</p>";
        echo "<p>Start Date: $Start_Date</p>";
        echo "<p>End Date: $End_Date</p>";
    }
    else {
        //else this means something has happened with that patient's data, so display a error message regarding not able to find it.
        echo"<p>No Insurance Information</p>";
    }
?>
