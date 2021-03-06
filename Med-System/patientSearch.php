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
    $fileName = 'jsonfile.json';

    //send get request
    if (isset($_GET['details'])) {
		//set session variables for the property that was clicked
		$_SESSION['Gov_HealthCard_Num'] = $_GET['details'];
		// redirect to viewProperty page
		header("Location: viewPatientDetails.php?govID=". $_GET['details']);
		die;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Patient Profiles</title>
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

        #formbox{
            /*Reference for code used in vertical and horizontal aligment by user Mr Bullets: 
                -> https://stackoverflow.com/questions/19461521/how-to-center-an-element-horizontally-and-vertically */
            text-align: center;
            margin: 0 auto;
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
            color: black;
        }

        .navigationBar a:hover{
            background-color: lime;
        }
    </style>

    <body>
        <div class="titleClass">
            <h1 class="title">Insert Title of medical insitute</h1>
        </div>

        <div class="navigationBar">
            <a href="LogOut.php">Log Out</a>
            <a href="index.php">Home</a>
            <a href="registerPatient.php">Add Patient Profile</a>
            <a href="registerDrug.php">Add Drug Profile</a>
        </div>
        
        <form method="get">
            
            <div>
                <h2><center>Patient Profiles: </center></h2>
                <p><center>HC# = Government Health Card Number</center></p>
                <br>
            </div>
            <div id = "formbox">
                <label>Select COVID Status:</label>
                <select name="covidstat">
                    <option value="All">All</option>
                    <option value="Pending">Pending</option>
                    <option value="Negative">Negative</option>
                    <option value="Positive">Positive</option>
                </select>
                <label>Patient Search: </label>
                <input type="text" name ="searchfor" placeholder="enter health card number."/>
                <input type="submit" name="submit" id="buttonStuff" value="Search"/>
            </div>
        </form>
        <br>
    <form method="get" action="">
        <?php
        $message="";
        //get information from the following text fields on the html after pressing the search button
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $covidStat = $_GET['covidstat'];
            $patientSearch = $_GET['searchfor'];
        }

        //if the $covidStat is null, meaning the page has first loaded up, set it to All Automatically.
        if($covidStat == NULL){
            $covidStat = "All";
        }

        //if the dropdown option bar for search is selected the All option and searched is pressed does the following:
        if($covidStat == "All"){
            //gets all the rows from patient_profile table in the SQL database and registers it into the variable queryResult
            $queryRes = "select * from patient_profile";
            $queryResult = mysqli_query($conn,$queryRes);

            //if the patientSearch field doesnt have anything in it after pressing search does the following
            if($patientSearch == NULL){
                //checks to see if the number of rows in the variable queryResult is bigger than 0, meaning it isnt empty
                if(mysqli_num_rows($queryResult) > 0){
                    ?>
                <div class = "rowResult">
                <?php 
                    //loops through all the entities in the query saved in the queryResult variable, and prints it into the html
                    $DataArr = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        $index = 'patient '.$row['Gov_HealthCard_Num'];
                        $DataArr[$index] = array(
                            "Government Healthcard Num: " => $row['Gov_HealthCard_Num'],
                            "COVID_Stat: " => $row['COVID_Test_Result'],
                            "first name: " => $row['First_Name'],
                            "Last name: "=> $row['Last_Name'],
                            "Address: " => $row['Address'],
                            "phone: " => $row['Phone_Number']
                            );
                        // echo "#rows: ".mysqli_num_rows($row);
                        //echo $row['First_Name']." ".$row['Last_Name']." Address: ".$row['Address']." ".$row['COVID_Test_Result']." Phone:".$row['Phone_Number'].'\n';
                    
                ?> 
                <div class="columnRes">
                <!--Reference used to help make this card section: https://www.w3schools.com/howto/howto_css_cards.asp-->
                        <div class="card">
                            <h2> <?php echo "HC#: ".$row['Gov_HealthCard_Num'];?> </h2>
                            <p class="nameText"> <?php echo "COVID Status: ".$row['COVID_Test_Result'];?> </p>
                            <h3> <?php echo "Name: ".$row['First_Name']." ".$row['Last_Name'];?></h3>
                            <p> <?php echo "Address: ".$row['Address']; ?> </p>
                            <p> <?php echo "Phone: ".$row['Phone_Number'];?> </p>
                            <p> <button type="submit" name="details" value="<?php echo "".$row['Gov_HealthCard_Num'];?>">Click For More Details</button> </p>
                        </div>
                </div>
                
                <?php    
                }
                $encodeJson = json_encode($DataArr);
                file_put_contents($fileName,$encodeJson);
                ?>

                </div>
                <?php
                }
                //else this means no data was found in the database so it displays the message to the page. 
                else {
                    echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>No Data in database about this category at the moment.</p>";
                    $message = "No Data in database about this category at the moment.";
                    $encodeJson = json_encode($message);
                    file_put_contents($fileName,$encodeJson);
                }
            }
            //else this means there is something in the field of the patient search text field, so checks if its numerical value
            else if(is_numeric($patientSearch)){
                //if it is, gets all the columns in the query patient_profile where Gov_Health_Num result is the same as the value in patientSearch
               //search query, sql injection proofed
                $stmt = $conn->prepare('SELECT * FROM patient_profile WHERE Gov_HealthCard_Num = ?');
                $stmt->bind_param('i', $patientSearch); // 'i' specifies the variable type => 'integer'
                $stmt->execute();
                $queryResult = $stmt->get_result();

                //checks to see if the number of rows in the table returned is greater than 0, meaning it isnt empty
                if(mysqli_num_rows($queryResult) > 0){
                    ?>
                <div class = "rowResult">
                <?php 
                    //loops through all the rows in the table saved in queryResult, and prints it out into the html
                    $DataArr = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        $index = 'patient '.$row['Gov_HealthCard_Num'];
                        $DataArr[$index] = array(
                            "Government Healthcard Num: " => $row['Gov_HealthCard_Num'],
                            "COVID_Stat: " => $row['COVID_Test_Result'],
                            "first name: " => $row['First_Name'],
                            "Last name: "=> $row['Last_Name'],
                            "Address: " => $row['Address'],
                            "phone: " => $row['Phone_Number']
                            );
                        // echo "#rows: ".mysqli_num_rows($row);
                        //echo $row['First_Name']." ".$row['Last_Name']." Address: ".$row['Address']." ".$row['COVID_Test_Result']." Phone:".$row['Phone_Number'].'\n';
                    
                ?> 
                <div class="columnRes">
                        <div class="card">
                            <!--Reference used to help make this card section: https://www.w3schools.com/howto/howto_css_cards.asp-->
                            <h2> <?php echo $row['Gov_HealthCard_Num'];?> </h2>
                            <p class="nameText"> <?php echo "COVID Status: ".$row['COVID_Test_Result'];?> </p>
                            <h3> <?php echo "Name: ".$row['First_Name']." ".$row['Last_Name'];?></h3>
                            <p> <?php echo "Address: ".$row['Address']; ?> </p>
                            <p> <?php echo "Phone: ".$row['Phone_Number'];?> </p>
                            <p> <button type="submit" name="details" value="<?php echo "".$row['Gov_HealthCard_Num'];?>">Click For More Details</button> </p>
                        </div>
                </div>
                
                <?php    
                }
                $encodeJson = json_encode($DataArr);
                file_put_contents($fileName,$encodeJson);
                ?>

                </div>
                <?php
                } 
                //if nothing is returned that means the user does not exist in the database, so display a message to the user about it
                else {
                    echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>User not found in the database.</p>";
                    $message = "User not found in the database.";
                    $encodeJson = json_encode($message);
                    file_put_contents($fileName,$encodeJson);
                }
            } 
            //else if the patientsearch isnt numerical that means it is a string, and we dont allow it so we display a message to the user about it
            else {
                echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>Patient search only works for numerical values, try again.</p>";
                $message = "Patient search only works for numerical values, try again.";
                $encodeJson = json_encode($message);
                file_put_contents($fileName,$encodeJson);
            }
        }
        //else this means that the user chose either Positve, Negative, Or Pending for covid Status dropdown menu bar
        else{
            //finds all the rows in the patient_profile table where the COVID_Test_Result is the same as the value in the variable covidStat
            $stmt = $conn->prepare('SELECT * FROM patient_profile WHERE COVID_Test_Result = ?');
            $stmt->bind_param('s', $covidStat); // 's' specifies the variable type => 'stringS'
            $stmt->execute();
            $queryResult = $stmt->get_result();
            

            //checks to see if the patientSearch text/input field is empty
            if($patientSearch == NULL){
                //if it is checks to see if the table saved to the variable queryResult is empty or not
                if(mysqli_num_rows($queryResult) > 0){
                    ?>
                <div class = "rowResult">
                <?php 
                    $DataArr = array();
                    //if it isnt empty, loop through all the entries in the table and prints it out to the html
                    while($row = mysqli_fetch_assoc($queryResult)){
                        $index = 'patient '.$row['Gov_HealthCard_Num'];
                        $DataArr[$index] = array(
                            "Government Healthcard Num: " => $row['Gov_HealthCard_Num'],
                            "COVID_Stat: " => $row['COVID_Test_Result'],
                            "first name: " => $row['First_Name'],
                            "Last name: "=> $row['Last_Name'],
                            "Address: " => $row['Address'],
                            "phone: " => $row['Phone_Number']
                            );
                        // echo "#rows: ".mysqli_num_rows($row);
                        //echo $row['First_Name']." ".$row['Last_Name']." Address: ".$row['Address']." ".$row['COVID_Test_Result']." Phone:".$row['Phone_Number'].'\n';
                    
                ?> 
                <div class="columnRes">
                        <div class="card">
                            <!--Reference used to help make this card section: https://www.w3schools.com/howto/howto_css_cards.asp-->
                            <h2> <?php echo $row['Gov_HealthCard_Num'];?> </h2>
                            <p class="nameText"> <?php echo "COVID Status: ".$row['COVID_Test_Result'];?> </p>
                            <h3> <?php echo "Name: ".$row['First_Name']." ".$row['Last_Name'];?></h3>
                            <p> <?php echo "Address: ".$row['Address']; ?> </p>
                            <p> <?php echo "Phone: ".$row['Phone_Number'];?> </p>
                            <p> <button type="submit" name="details" value="<?php echo "".$row['Gov_HealthCard_Num'];?>">Click For More Details</button> </p>
                        </div>
                </div>
                
                <?php    
                }
                $encodeJson = json_encode($DataArr);
                file_put_contents($fileName,$encodeJson);
                ?>

                </div>
                <?php
                } 
                //else this means there are no patients/data in the database with that information, so prints a message to the user about it
                else {
                    $message = "No Data in database about this category at the moment.";
                    $encodeJson = json_encode($message);
                    file_put_contents($fileName,$encodeJson);
                    echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>No Data in database about this category at the moment.</p>";
                }
            } 
            //else this means the field in the patientSearch input text field isnt empty, so checks if it is a number
            else if(is_numeric($patientSearch)){
                //if it is does the following, finds and gets the entire row in the table where the government health number is the same as patientSearch variable,
                //and the covid status is equal to the value in the variable covidStat
                $queryRes = "select * from patient_profile where Gov_HealthCard_Num = '$patientSearch' and COVID_Test_Result = '$covidStat'";
                //saves the data into the variable queryResult
                $queryResult = mysqli_query($conn,$queryRes);

                if(mysqli_num_rows($queryResult) > 0){
                    ?>
                <div class = "rowResult">
                <?php 
                    $DataArr = array();
                    while($row = mysqli_fetch_assoc($queryResult)){
                        $index = 'patient '.$row['Gov_HealthCard_Num'];
                        $DataArr[$index] = array(
                            "Government Healthcard Num: " => $row['Gov_HealthCard_Num'],
                            "COVID_Stat: " => $row['COVID_Test_Result'],
                            "first name: " => $row['First_Name'],
                            "Last name: "=> $row['Last_Name'],
                            "Address: " => $row['Address'],
                            "phone: " => $row['Phone_Number']
                            );
                        // echo "#rows: ".mysqli_num_rows($row);
                        //echo $row['First_Name']." ".$row['Last_Name']." Address: ".$row['Address']." ".$row['COVID_Test_Result']." Phone:".$row['Phone_Number'].'\n';
                    
                ?> 
                <div class="columnRes">
                        <div class="card">
                            <h2> <?php echo $row['Gov_HealthCard_Num'];?> </h2>
                            <p class="nameText"> <?php echo "COVID Status: ".$row['COVID_Test_Result'];?> </p>
                            <h3> <?php echo "Name: ".$row['First_Name']." ".$row['Last_Name'];?></h3>
                            <p> <?php echo "Address: ".$row['Address']; ?> </p>
                            <p> <?php echo "Phone: ".$row['Phone_Number'];?> </p>
                            <p> <button value="<?php echo $row['Gov_HealthCard_Num'];?>" type="submit" name="details">Click For More Details</button></p>
                        </div>
                </div>
                
                <?php    
                }
                $encodeJson = json_encode($DataArr);
                file_put_contents($fileName,$encodeJson);
                ?>

                </div>
                <?php
                }
                //else this means that there is no user with that government health card number in the database with that covid status, so display a message to the user about it. 
                else {
                    $message = "User not found in the database of this COVID category.";
                    $encodeJson = json_encode($message);
                    file_put_contents($fileName,$encodeJson);
                    echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>User not found in the database of this COVID category.</p>";
                    
                }
            }
            //else this means the text field for patient Search input was a string, and that search input only allows integers so display a message to the user about it. 
            else {
                $message = "Patient search only works for numerical values, try again.";
                $encodeJson = json_encode($message);
                file_put_contents($fileName,$encodeJson);
                echo "<p style='text-align: center; font-weight: bold; font-size: 16px;'>Patient search only works for numerical values, try again.</p>";
            }
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
            color: black;
            outline: 0px;
            background-color: mediumseagreen;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            font-size: 16px;
        }
        
        .card button:hover{
            background-color: #0BDA51;
            color: black;
            font-style: italic;
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
