
<?php
    session_start();

    include("connections.php");
    include("LoginChecker.php");

    $userDataSessions = isLoggedIn($conn);
    $drugDIN = $_SESSION['DIN'];
    if($drugDIN == NULL){
        $drugDIN = isset($_GET['din']) ? mysqli_real_escape_string($conn, $_GET['din']) :  "";
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
    $stmt = $conn->prepare('SELECT * FROM drug_profile WHERE DIN = ?');
    $stmt->bind_param('i', $drugDIN); // 'i' specifies the variable type => 'integer'
    $stmt->execute();
    $queryDrugRes = $stmt->get_result();

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
    } 
    else {
        //else this means something has happened with that patient's data, so display a error message regarding not able to find it.
        echo"<p>There was an problem retrieving this information.</p>";
    }
?>
