
<?php
    session_start();

    include("connections.php");
    include("LoginChecker.php");
    $fileName = 'jsonfile.json';

    $userDataSessions = isLoggedIn($conn);
    $patientHealthCardNum = $_SESSION['Gov_HealthCard_Num'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>View Dependent Details</title>
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
            margin-left: 10px;
            background-color: #0BDA51;
            color: black;
            font-size: 16px;
            font-weight: bold;
            padding: 5px;
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
            margin-bottom: 20px;
        }
        body{
            background-color: lightgrey;
        }
    </style>
    <body>
        <div class="titleClass">
            <h1 class="title">Insert Title of medical insitute</h1>
        </div>
        <div class="navigationBar" style="margin-bottom: 20px;">
            <a href="LogOut.php">Log Out</a>
            <a href="index.php" style="margin: 0 20px;">Home</a>
            <a href="patientSearch.php" style="margin: 0 20px;">Patient Search</a>
            <a href="registerPatient.php" style="margin: 0 20px;">Add Patient Profile</a>
        </div>
        
        <div>
            <form id="formbox">
                <a href="viewPatientDetails.php" id="buttonStuff">Back to Patient Profile</a>
                <a href="registerDependents.php" id="buttonStuff">Add Patient Dependents</a>
                <a href="editDependentDetails.php" id="buttonStuff">Edit Patient Dependents</a>

            </form>   
        </div>
        <div>
            <center><h1>Patient: <?php echo $patientHealthCardNum?></h1></center>
        </div>
    </body>
</html>

<?php
    //gets the query data from the sql database of the current selected patient in the patient profile table 
    $queryPatientGet = "select * from dependent where Parent_HealthCard_Num = '$patientHealthCardNum'";
    $queryPatientRes = mysqli_query($conn, $queryPatientGet);

    //checks to see if the query returned is not empty
    if(mysqli_num_rows($queryPatientRes) > 0){
        echo "<h2 style='text-align: center;'>Dependent List</h2>";
        $DependentData = mysqli_fetch_assoc($queryPatientRes);

        $color="black";
        $depName = $DependentData['First_Name']." ".$DependentData['Last_Name'];
        $DepRelationship = $DependentData['Relationship'];

        $dataArr["Patient Dependent Info: "] = array(
            "Dependent First Name: " => $DependentData['First_Name'],
            "Dependent Last Name: " =>$DependentData['Last_Name'],
            "Relationship: " => $DependentData['Relationship']
        );
        $encodeJson = json_encode($dataArr);
        file_put_contents($fileName,$encodeJson);

        //displays the information from the variables onto the html
        echo "<p style='text-align: center;  font-size: 16px;'>Dependent Name: $depName</p>";
        echo "<p style='text-align: center;  font-size: 16px;'>Dependent Relationship: $DepRelationship</p>";
    }
    else {
        //else this means something has happened with that patient's data, so display a error message regarding not able to find it.
        echo"<p style='text-align: center;  font-size: 16px;'>No Dependents</p>";
        $encodeJson = json_encode("No Dependents.");
        file_put_contents($fileName,$encodeJson);
    }
?>
