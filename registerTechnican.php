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
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $password = $_POST['password'];
        $message = "";

        // if not empty and it is valid, then do the following
        if (!empty($techid) && !empty($phone) && !empty($firstName) && !empty($lastName) && !empty($password)) {
            if(is_numeric($phone) && is_numeric($techid)){
                $conditionalQuery = "select * from users where UserID = '$techid'";
                $CondQueryRes = mysqli_query($conn, $conditionalQuery);
                    
                if(mysqli_num_rows($CondQueryRes) <= 0){
                    //register the following values into the user table
                    $queryRes = "insert into users (UserID, First_Name, Last_Name, Phone, Password) values ('$pharmid','$firstName','$lastName', '$phone','$password')";
                    //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                    mysqli_query($conn, $queryRes);

                    //register the following values into the pharmacist table
                    $queryRes = "insert into technican (TechID, First_Name, Last_Name, Phone, Password) values ('$techid', '$firstName', '$lastName', '$phone', '$password')";
                    //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                    mysqli_query($conn, $queryRes);
                    // redirect user to login page
                    header("Location: LoginPage.php");
                    die;
                }
                else{
                    //echo "TechID already exists. Enter a different value.";
                    $message = "TechID already exists. Enter a different value.";
                }
            } else {
                //echo "TechID or Phone number were not numerical values, try again.";
                $message = "TechID or Phone number were not numerical values, try again.";
            }
            
        } 
        else {
            //echo "Cannot have a empty field, try again.";
            $message = "Cannot have a empty field, try again.";
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
            <title>Technican Registration</title>
            <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    
    <body>
            <div id="formbox">
                    <form method="post">
                            <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">User Registration</div>
                            <p><?php echo $message?></p>
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
                                <label>Password:</label>
                                <input type="text" id="textbox" name="password"/>
                            </p>
                            <p>
                                <label>Phone:</label>
                                <input type="text" id="textbox" name="phone"/>
                            </p>

                            <input id="buttonStuff" type="submit" value="Register">
                            <br>
                            <br>
                            <a href="LoginPage.php">Login</a><br><br>
                            <a href="registerPharmacist.php">Register As Pharmacist</a><br><br>
                    </form>
            </div>
    </body>
</html>