
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
            <a href="drugSearch.php">Drug Search</a>
            <a href="registerDrug.php">Add Drug Profile</a>
        </div>
        <div>
            <center><h1>Drug <?php echo $drugDIN?></h1></center>
        </div>
        <div>
            <form>
                <a href="viewPatientDetails.php">Back to Patient Profile</a>
                <a href="registerAllergy.php">Add an Allergy Record</a>
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
            $_SESSION['Gov_HealthCard_Num'] = $drugDIN;
            header("Location: editPatientProfile.php");
            die;
        }
    } */
    //gets the query data from the sql database of the current selected drug in the drug profile table
    $queryAllergyGet = "select * from can_have where Gov_HealthCard_Num = '$patientHealthCardNum'";
    $queryAllergyRes = mysqli_query($conn, $queryAllergyGet);

    //checks to see if the query returned is not empty
    if(mysqli_num_rows($queryAllergyRes) > 0){
        //if it isnt, then it fetches the data on that patient retrieved from the sql database
        $AllergyData = mysqli_fetch_assoc($queryAllergyRes);
        
        //reference:
        //php printing stuff: https://code-boxx.com/display-php-variables-in-html/
        
        //saving the following things into variables from the sql database
        $color="black";
        $Ingredient_Name = $AllergyData['Ingredient_Name'];
        $Gov_HealthCard_Num = $AllergyData['Gov_HealthCard_Num'];

        $queryIngredientGet = "select * from drug/ingredient_allergies where Ingredient_Name = '$Ingredient_Name'";
        $queryIngredientRes = mysqli_query($conn, $queryIngredientGet);
        $IngredientData = mysqli_fetch_assoc($queryIngredientRes);

        $ingredientName = $IngredientData['Ingredient_Name'];
        $ingredientAlternative = $IngredientData['Drug/Ingredient_Alt'];
        $ingredientUsage = $IngredientData['Drug/Ingredient_Usage'];

        //displays the data to the html
        echo "<p>Drug Identification Number (DIN): $Gov_HealthCard_Num</p>";
        echo "<p>Allergen Name: $Ingredient_Name</p>";
        //echo "<p>Allergen Alternative: $ingredientAlternative</p>";
        //echo "<p>Allergen Usage: $ingredientUsage</p>";

    } 
    else {
        //else this means something has happened with that patient's data, so display a error message regarding not able to find it.
        echo"<p>Patient $patientHealthCardNum does not have any recorded allergies.</p>";
    }
?>
