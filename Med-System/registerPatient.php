<?php
session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");

    // using SERVER to check if the user has clicked on the post button (if request method = POST)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html section below
        $techid = $_POST['techid'];
		$phone = $_POST['phone'];
        $healthcardnum = $_POST['healthcard'];

        $covidStat = $_POST['covidstat'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $sex = $_POST['sex'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $prefLanguage = $_POST['language'];
        $birthday = $_POST['birthday'];
        $address = $_POST['address'];

        $providerNotes = $_POST['notes'];
        $email = $_POST['email'];

        $message = "";

        // if not empty and it is valid, then do the following
        if (!empty($birthday)&& !empty($address) && !empty($techid) && !empty($phone) && !empty($firstName) && !empty($lastName) && !empty($weight) && !empty($height) && !empty($prefLanguage) && !empty($healthcardnum) && !empty($sex)) {
            if(is_numeric($phone) && is_numeric($techid) && is_numeric($healthcardnum)){
                $conditionalQuery = "select * from patient_profile where Gov_HealthCard_Num = '$healthcardnum'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);

                $conditionalQuery2 = "select * from technican where TechID = '$techid'";
                $CondQueryRes2 = mysqli_query($conn, $conditionalQuery2);
                    
                if(mysqli_num_rows($CondQueryRes) <= 0){
                    if(mysqli_num_rows($CondQueryRes2) > 0){
                        //register the following values into the user table
                        $queryRes = "insert into patient_profile (Gov_HealthCard_Num, First_Name, Last_Name, COVID_Test_Result, Weight, Height, Preferred_Language, Sex, Phone_Number, Address, Provider_Notes, Email, Day_Of_Birth, UserID) values ('$healthcardnum','$firstName','$lastName', '$covidStat', '$weight', '$height', '$prefLanguage', '$sex', '$phone', '$address','$providerNotes', '$email','$birthday','$techid')";
                        //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                        mysqli_query($conn, $queryRes);

                        header("Location: patientSearch.php");
                        exit;  
                    }
                    else {
                        //echo "userID does not exist, try again.";
                        $message = "userID does not exist, try again.";
                    }   
                }
                else{
                    //echo "Gov. Health card already exists, try again.";
                    $message = "Gov. Health card already exists, try again.";
                }
            } 
            else {
                //echo "TechID, Phone number, health card number were not numerical values, try again.";
                $message = "TechID, Phone number, health card number were not numerical values, try again.";
            }
        } 
        else {
            //echo "The only empty fields allowed are provider notes and email, try again.";
            $message = "The only empty fields allowed are provider notes and email, try again.";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
            <title>Patient Registration</title>
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
            color: black;
        }

        .navigationBar a:hover{
            background-color: lime;
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
            padding: 5%;
        }

	body{
        background-color: lightgrey;
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
            
        </div>
            <div id="formbox">
                    <form method="post">
                            <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Patient Registration</div>
                            <p><?php echo $message?></p>
                            <p>
                                <label>Government Health Card #:</label>
                                <input type="text" id="textbox" name="healthcard"/>
                            </p>
                            <p>
                                <label>TechID:</label>
                                <input type="text" id="textbox" name="techid"/>
                            </p>
                            <p>
                                <label>First Name:</label>
                                <input type="text" id="textbox" name="first_name"/>
                            </p>
                            <p>
                                <label>Last Name:</label>
                                <input type="text" id="textbox" name="last_name"/>
                            </p>
                            <p>
                                <label>Address:</label>
                                <input type="text" id="textbox" name="address"/>
                            </p>
                            <p>
                                <label>Weight:</label>
                                <input type="text" id="textbox" name="weight"/>
                            </p>
                            <p>
                                <label>Height:</label>
                                <input type="text" id="textbox" name="height"/>
                            </p>
                            <p>
                                <label>Sex:</label>
                                <select name="sex">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </p>
                            <p>
                                <label>Preferred language:</label>
                                <input type="text" id="textbox" name="language"/>
                            </p>
                            <p>
                                <label>Phone:</label>
                                <input type="text" id="textbox" name="phone"/>
                            </p>
                            <p>
                                <label>Email:</label>
                                <input type="text" id="textbox" name="email"/>
                            </p>
                            <p>
                                <label>Birthday:</label>
                                <input type="text" id="textbox" name="birthday"/>
                            </p>
                            <p>
                                <label>Provider Notes:</label>
                                <input type="text" id="textbox" name="notes"/>
                            </p>
                            
                            <p>
                                <label>Select COVID Status:</label>
                                <select name="covidstat">
                                    <option value="Pending">Pending</option>
                                    <option value="Negative">Negative</option>
                                    <option value="Positive">Positive</option>
                                </select>
                            </p>

                            <input id="buttonStuff" type="submit" value="Register"/>
                            <br>
                    </form>
            </div>
    </body>
</html>