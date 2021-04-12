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
            color: black;
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
            background-color: dodgerblue;
        }

        body{
            background-color: lightgrey;
        }
    </style>

    <body>
        <div class="titleClass">
            <h1 class="title">Insert Title of medical insitute</h1>
        </div>

        <div><a href="LogOut.php">Log Out</a></div>
        <form method="post">
            
            <div>
                <h2><center>Patients Profiles: </center></h2>
                <br>
            </div>

            <div>
                <label>Select COVID Status:</label>
                <select name="covidstat">
                    <option value="All">All</option>
                    <option value="Pending">Pending</option>
                    <option value="Negative">Negative</option>
                    <option value="Positive">Positive</option>
                </select>
            </div>

            <div>
                <label>Patient Search: </label>
                <input type="text" name ="searchfor" placeholder="enter health card number."/>
            </div>

            <div>
                <input type="submit" name="submit" value="Search"/>
            </div>

        </form>
        <br>
    </body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $covidStat = $_POST['covidstat'];
        $patientSearch = $_POST['searchfor'];
    }

    /* $isNullCond = True;

    if($patientSearch == NULL){
        $isNullCond = False;
    }

    if($isNullCond == True){
        if($covidStat == "All"){
            $QueryGet = "select * from patient_profile";
        }
        else {
            $QueryGet = "select * from patient_profile where COVID_Test_Result = '$covidStat'";
        }

        $QueryRes = mysqli_query($conn, $QueryGet);

        if(mysqli_num_rows($QueryRes) > 0){
        ?>
        <div class = "rowResult">
        <?php 
            while($row = mysqli_fetch_assoc($QueryRes)){
                echo "#rows: ".mysqli_num_rows($row);
                echo $row['First_Name']." ".$row['Last_Name']." ".$row['Address']." ".$row['COVID_Test_Result'];
            
        ?> 
        <div class="columnRes">
                <div class="card">
                    <h2> <?php echo $row['Gov_HealthCard_Num'];?> </h2>
                    <p class="nameText"> <?php echo "COVID Status: ".$row['COVID_Test_Result'];?> </p>
                    <h3> <?php echo "Name: ".$row['First_Name']." ".$QueryRes['Last_Name'];?></h3>
                    <h3> <?php echo "Address: ".$row['Address']; ?> </h3>
                    <h3> <?php echo "Phone: ".$row['Phone'];?> </h3>
                    <p> <button>Click For More Details</button> </p>
                </div>
        </div>
        
        <?php    
        }
        ?>

        </div>
        <?php
        } 
        else {
            echo "No Data in database.";
        }
    }

    else if(is_numeric($patientSearch)){
        if($covidStat == "All"){
            $QueryGet = "select * from patient_profile where Gov_HealthCard_Num = '$patientSearch'";
        } 
        else {
            $QueryGet = "select * from patient_profile where Gov_HealthCard_Num = '$patientSearch' and COVID_Test_Result = '$covidStat'";
        }

        $QueryRes = mysqli_query($conn, $QueryGet);

        if(mysqli_num_rows($QueryRes) >= 1){
        ?>
        <div class = "rowResult">
        <?php 
            while($row = mysqli_fetch_assoc($QueryRes)){
            
        ?> 
        <div class="columnRes">
                <div class="card">
                    <h2> <?php echo $row['Gov_HealthCard_Num'];?> </h2>
                    <p class="nameText"><?php echo "COVID Status: " . $row['COVID_Test_Result'];?></p>
                    <p class="nameText"><?php echo "Name: " . $row['First_Name'] . " " . $QueryRes['Last_Name'];?></p>
                    <h3> <?php echo "Address: " . $row['Address']; ?> </h3>
                    <h3><?php echo "Phone: " . $row['Phone'];?></h3>
                    <p><button>Click For More Details</button></p>
                </div>
        </div>
        
        <?php    
        }
        ?>

        </div>
        <?php
        } 
        else {
            echo "Patient is not registered in the database.";
        }
    }
    else {
        echo "Patient Search has to be a integer value only.";
    } */

?>

<!DOCTYPE html>
<html>
    <style>
        .columnRes{
            float: left;
            width: 20%;
            padding-top: 0px;
            padding-bottom: 0px;
            padding-left: 25px;
            padding-right: 25px;
        }
        .rowResult{
            margin: none;
        }
        .rowResult:after{
            /*References used: 
                -> for the clear css: https://www.w3schools.com/cssref/pr_class_clear.asp
                ->  for the content css: https://www.w3schools.com/cssref/pr_gen_content.asp*/
            content: "";
            display: table;
            clear: both;
        }
        .card{
            /*references used to help make the card stuff:
                ->  https://www.w3schools.com/howto/howto_css_cards.asp*/
            max-width: 400px;
            margin: auto;
            text-align: center;
            box-shadow: 0px 8px 6px 0px;
        }

        .card button:hover{
            border: 2px solid black;
            box-shadow: 3px 8px 6px 3px;
            opacity: 0.85;
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
            background-color: mediumseagreen;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
            font-size: 16px;
        }

        

        /* reference used for this css:  
            -> https://www.w3schools.com/css/css_rwd_mediaqueries.asp*/
        @media screen and (max-width: 600px) {
		  .columnRes {
			width: 100%;
			display: block;
            margin-left: 10px;
            margin-right: 10px;
			margin-bottom: 25px;
		  }
		}

    </style>
</html>