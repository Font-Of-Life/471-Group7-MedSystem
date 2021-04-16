<?php 
    //checks to see the user is logged in
    session_start();

    /*
    include the following files:
        -> connections.php is used for purpose of $conn to verify connections to server and database
        -> LoginChecker.php is used for the function of isLoggedIn to check if the user is logged in to the database
    */
    include("connections.php");
    include("LoginChecker.php");

    //Stores the user's current session data in the variable userSessionData
    //isLoggedIn is a function defined LoginChecker.php as mentioned above, where the connection to the database is registered as $conn
    $userSessionData = isLoggedIn($conn);


    if (isset($_POST['details'])) {
		//set session variables for the property that was clicked
		$_SESSION['DIN'] = $_POST['details'];
		// then redirect to viewProperty page
		header("Location: viewDrugDetails.php");
		die;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Drug Profiles</title>
        <link rel="stylesheet" type="text/css" href="style.css">

        <!--References used: https://www.w3schools.com/tags/att_meta_name.asp-->
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
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
            font-weight: bold;
            border: 2px solid black;
            border-radius: 1px solid black;
            cursor: pointer;
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
            <h1 class="title">Insert Title of medical Insitute</h1>
        </div>

        <div class="navigationBar">
            <a href="LogOut.php">Log Out</a>
            <a href="index.php">Home</a>
            <a href="registerPatient.php">Add Patient Profile</a>
            <a href="registerDrug.php">Add Drug Profile</a>
        </div>
        
        <form method="post">
            
            <div>
                <h2><center>Patient Profiles: </center></h2>
                <p><center>DIN# = Government Health Card Number</center></p>
                <br>
            </div>

            <div id="formbox">
                <label>Drug Search: </label>
                <input type="text" name ="searchDrug" placeholder="enter Drug Identification Number (DIN)."/>
                <input id="buttonStuff" type="submit" name="submit" value="Search"/>
            </div>

        </form>
        <br>
    <form method="post" action="">
        <?php
        $message="";
        //get information from the following text fields on the html after pressing the search button
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            //$covidStat = $_POST['covidstat'];
            $drugSearch = $_POST['searchDrug'];
        }

//         //if the $covidStat is null, meaning the page has first loaded up, set it to All Automatically.
//         if($covidStat == NULL){
//             $covidStat = "All";
//         }

        // if drug field doesnt have anything in it
        if($drugSearch == NULL){
            $queryRes = "select * from drug_profile";
            $queryResult = mysqli_query($conn,$queryRes);

            if(mysqli_num_rows($queryResult) > 0){
            ?>
            <div class = "rowResult">
            <?php
                //loops through all the entities in the query saved in the queryResult variable, and prints it into the html
                while($row = mysqli_fetch_assoc($queryResult)){
                    // echo "#rows: ".mysqli_num_rows($row);
                    //echo $row['First_Name']." ".$row['Last_Name']." Address: ".$row['Address']." ".$row['COVID_Test_Result']." Phone:".$row['Phone_Number'].'\n';

                ?>
                <div class="columnRes">
                <!--Reference used to help make this card section: https://www.w3schools.com/howto/howto_css_cards.asp-->
                        <div class="card">
                            <h2> <?php echo "DIN#: ".$row['DIN'];?> </h2>
                            <p class="nameText"> <?php echo "Brand Name: ".$row['Drug_Name'];?> </p>
                            <h3> <?php echo "Generic Name: ".$row['Drug_Generic_Name'];?></h3>
                            <h3> <?php echo "Drug Strength: ".$row['Strength'];?></h3>
                            <p> <?php echo "Current Inventory: ".$row['Current_Inventory']; ?> </p>
                            <p> <?php echo "Sell Price: ".$row['Sell_Price'];?> </p>
                            <p> <button type="submit" name="details" value="<?php echo "".$row['DIN'];?>">Click For More Details</button> </p>
                        </div>
                </div>

                <?php
                }
            ?>

            </div>
            <?php
            }
            //else this means no data was found in the database so it displays the message to the page.
            else {
                echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>No Data in database about this category at the moment.</p>";
                //$message = "No Data in database about this category at the moment.";
            }
        }
        else if(is_numeric($drugSearch)) {
            //if it is, gets all the columns in the query patient_profile where Gov_Health_Num result is the same as the value in patientSearch
            $queryRes = "select * from drug_profile where DIN = '$drugSearch'";
            //gets the query and saves it into the variable queryResult
            $queryResult = mysqli_query($conn,$queryRes);

            if(mysqli_num_rows($queryResult) > 0){
                ?>
            <div class = "rowResult">
            <?php
                //loops through all the rows in the table saved in queryResult, and prints it out into the html
                while($row = mysqli_fetch_assoc($queryResult)){
                    // echo "#rows: ".mysqli_num_rows($row);
                    //echo $row['First_Name']." ".$row['Last_Name']." Address: ".$row['Address']." ".$row['COVID_Test_Result']." Phone:".$row['Phone_Number'].'\n';

            ?>
            <div class="columnRes">
                    <div class="card">
                        <h2> <?php echo "DIN#: ".$row['DIN'];?> </h2>
                        <p class="nameText"> <?php echo "Brand Name: ".$row['Drug_Name'];?> </p>
                        <h3> <?php echo "Generic Name: ".$row['Drug_Generic_Name'];?></h3>
                        <h3> <?php echo "Drug Strength: ".$row['Strength'];?></h3>
                        <p> <?php echo "Current Inventory: ".$row['Current_Inventory']; ?> </p>
                        <p> <?php echo "Sell Price: ".$row['Sell_Price'];?> </p>
                        <p> <button type="submit" name="details" value="<?php echo "".$row['DIN'];?>">Click For More Details</button> </p>
                    </div>
            </div>

            <?php
            }
            ?>

            </div>
            <?php
            }
            //if nothing is returned that means the user does not exist in the database, so display a message to the user about it
            else {
                echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>User not found in the database.</p>";
                //$message = "User not found in the database.";
            }
        }
        else {
            echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>Drug search only works for numerical values, please give the DIN and try again.</p>";
            //$message = "Patient search only works for numerical values, try again.";
        }
    ?>
    </form>
    </body>
</html>

<!DOCTYPE html>
<html>
    <style>
        * {
			box-sizing: border-box;
		}
        .columnRes{
            float: left;
            width: 25%;
            padding-top: 0px;
            padding-bottom: 0px;
            padding-left: 25px;
            padding-right: 25px;
        }
        .rowResult{
            margin: 0,-5px;
        }
        .rowResult:after{
            /*References used: 
                -> for the clear css: https://www.w3schools.com/cssref/pr_class_clear.asp
                ->  for the content css: https://www.w3schools.com/cssref/pr_gen_content.asp */
            content: "";
            display: table;
            clear: both;
        }
        .card{
            /*references used to help make the card stuff:
                ->  https://www.w3schools.com/howto/howto_css_cards.asp
                -> https://www.w3schools.com/howto/howto_css_column_cards.asp */
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0px 5px 10px 0px;
            overflow: hidden;
            //position: relative;
            outline: none;
        }

        .nameText{
            color: black;
            font-weight: bold;
            font-size: 20px;
        }

        .card button{
            /*References:
                -> for the cursor: https://www.w3schools.com/cssref/pr_class_cursor.asp */
            border: none;
            padding: 15px;
            color: white;
            outline: 0px;
            background-color: mediumseagreen;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            font-size: 16px;
        }
        
        .card button:hover{
            background-color: green;
        }

        .navigationBar{
            background-color: mediumseagreen;
            overflow: hidden;
            text-align: center;
            color: white;
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

        /* reference used for this css:  
            -> https://www.w3schools.com/css/css_rwd_mediaqueries.asp*/
        @media screen and (max-width: 600px) {
		  .columnRes {
			width: 100%;
			display: block;
            margin-bottom: 20px;
		  }
		}
    </style>
</html>
