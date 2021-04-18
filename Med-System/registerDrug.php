<?php
session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");

    // using SERVER to check if the user has clicked on the post button (if request method = POST)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html section below
        $DINum = $_POST['DINum'];
        $drugName = $_POST['drugName'];
        $drugGenericName = $_POST['drugGenericName'];
        $drugPackSize = $_POST['drugPackSize'];
        $drugSellPrice = $_POST['drugSellPrice'];
        $drugBuyPrice = $_POST['drugBuyPrice'];
        $drugInventory = $_POST['drugInventory'];
        $drugSupplier = $_POST['drugSupplier'];
        $drugImage = $_POST['drugImage'];
        $drugSchedule = $_POST['drugSchedule'];
        $drugStrength = $_POST['drugStrength'];
        $drugCreation = $_POST['drugCreation'];
        $userid = $_POST['userid'];

        $message = "before first if statement";

        // if not empty and it is valid, then do the following
        //if (!empty($DINum) && !empty($drugName) && !empty($drugGenericName)) {//&& !empty($drugPackSize) && !empty($drugSellPrice) && !empty($drugBuyPrice) && !empty($drugInventory) && !empty($drugStrength) && !empty($drugCreation) && !empty($userid)) {
        if (!empty($DINum)) {
            $message = "Passed first if statement";
            if(is_numeric($DINum)) {//&& is_numeric($userid) && is_numeric($drugPackSize) && is_numeric($drugSellPrice) && is_numeric($drugBuyPrice) && is_numeric($drugInventory) && is_numeric($drugStrength)){
                $conditionalQuery = "select * from drug_profile where DIN = '$DINum'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);

                $conditionalQuery2 = "select * from technican where TechID = '$userid'";
                $CondQueryRes2 = mysqli_query($conn, $conditionalQuery2);

                if(mysqli_num_rows($CondQueryRes) <= 0){
                    if(mysqli_num_rows($CondQueryRes2) > 0){
                        //register the following values into the user table
                        $queryRes = "insert into drug_profile (DIN, Drug_Name, Drug_Generic_Name, Pack_Size, Sell_Price, Bought_Price, Current_Inventory, Supplier, Drug_Image, Schedule, Strength, Date_Created, UserID) values ('$DINum', '$drugName', '$drugGenericName', '$drugPackSize', '$drugSellPrice', '$drugBuyPrice', '$drugInventory', '$drugSupplier', '$drugImage', '$drugSchedule', '$drugStrength', '$drugCreation', '$userid')";
                        //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                        mysqli_query($conn, $queryRes);

                        header("Location: drugSearch.php");
                        exit;  
                    }
                    else {
                        //echo "userID does not exist, try again.";
                        $message = "userID does not exist, try again.";
                    }   
                }
                else{
                    //echo "Gov. Health card already exists, try again.";
                    $message = "DIN already exists, try again.";
                }
            } 
            else {
                //echo "TechID, Phone number, health card number were not numerical values, try again.";
                $message = "DIN, Pack Size, Sell Price, Buy Price, Inventory, Drud Schedule and Drug Strength were not numerical values, try again.";
            }
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "The only empty fields allowed is Drug Image, try again.";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
            <title>Drug Registration</title>
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
            margin-top: 10px;
        }

        #formbox{
            /*Reference for code used in vertical and horizontal aligment by user Mr Bullets: 
                -> https://stackoverflow.com/questions/19461521/how-to-center-an-element-horizontally-and-vertically */
            text-align: center;
            margin: 0 auto;
            background-color: whitesmoke;
            border-radius: 2px;
            border: 3px solid black;
            width: 25%;
            padding-left: 5%;
            padding-right: 5%;
            padding-bottom: 20px;
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
                            <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Drug Registration</div>
                            <p><?php echo $message?></p>
                            <p>
                                <label>Drug ID # (DIN):</label>
                                <input type="text" id="textbox" name="DINum"/>
                            </p>
                            <p>
                                <label>TechID:</label>
                                <input type="text" id="textbox" name="userid"/>
                            </p>
                            <p>
                                <label>Drug Name:</label>
                                <input type="text" id="textbox" name="drugName"/>
                            </p>
                            <p>
                                <label>Generic Drug Name:</label>
                                <input type="text" id="textbox" name="drugGenericName"/>
                            </p>
                            <p>
                                <label>Drug Strength in mg :</label>
                                <input type="text" id="textbox" name="drugStrength"/>
                            </p>
                            <p>
                                <label>Drug Pack Size :</label>
                                <input type="text" id="textbox" name="drugPackSize"/>
                            </p>
                            <p>
                                <label>Buy Price:</label>
                                <input type="text" id="textbox" name="drugBuyPrice"/>
                            </p>
                            <p>
                                <label>Sell Price:</label>
                                <input type="text" id="textbox" name="drugSellPrice"/>
                            </p>
                            <p>
                                <label>Current Inventory:</label>
                                <input type="text" id="textbox" name="drugInventory"/>
                            </p>
                            <p>
                                <label>Supplier:</label>
                                <select name="drugSupplier">
                                    <option value="Teva">Teva</option>
                                    <option value="Pfizer">Pfizer</option>
                                    <option value="JohnsonJohnson">Johnson & Joshnson</option>
                                </select>
                            </p>
                            <p>
                                <label>Drug Image:</label>
                                <input type="text" id="textbox" name="drugImage"/>
                            </p>
                            <p>
                                <label>Drug Schedule:</label>
                                <select name="drugSchedule"/>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </p>
                            <p>
                                <label>Drug Creation Date :</label>
                                <input type="text" id="textbox" name="drugCreation"/>
                            </p>

                            <input type="submit" value="Register" id="buttonStuff"/>
                            <br>
                    </form>
            </div>
    </body>
</html>
