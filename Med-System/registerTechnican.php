<?php
session_start();

    // include the following php files
    include("connections.php");
    include("LoginChecker.php");
    $fileName = 'jsonfile.json';

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
                //prepare statement and check for existsing userID
                $stmt = $conn->prepare('SELECT * FROM users WHERE UserID = ?');
                $stmt->bind_param('i', $techid); // 'i' specifies the variable type => 'integer'
                $stmt->execute();
                $CondQueryRes = $stmt->get_result();
                    
                if(mysqli_num_rows($CondQueryRes) <= 0){
                    $DataArr['users data: '] = array("UserID: " => $techid, "Password: "=> $password, "first_name: " => $firstName, "last_name: " => $lastName, "Phone: "=> $phone);
                    
                    //register the following values into the user table
                    $queryRes = "insert into users (UserID, First_Name, Last_Name, Phone, Password) values ('$pharmid','$firstName','$lastName', '$phone','$password')";
                    //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                    mysqli_query($conn, $queryRes);

                    //register the following values into the pharmacist table
                    $queryRes = "insert into technican (TechID, First_Name, Last_Name, Phone, Password) values ('$techid', '$firstName', '$lastName', '$phone', '$password')";
                    //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                    mysqli_query($conn, $queryRes);

                    $DataArr['Technician data:'] = array("TechID: " => $techid, "Password: " => $password, "First_name: " => $firstName, "Last_name: " => $lastName, "phone: "=> $phone);
                    $encodeJson = json_encode($DataArr);
                    file_put_contents($fileName,$encodeJson);

                    // redirect user to login page
                    header("Location: LoginPage.php");
                    die;
                }
                else{
                    //echo "TechID already exists. Enter a different value.";
                    $message = "TechID already exists. Enter a different value.";
                    $encodeJson = json_encode($message);
                    file_put_contents($fileName,$encodeJson);
                }
            } else {
                //echo "TechID or Phone number were not numerical values, try again.";
                $message = "TechID or Phone number were not numerical values, try again.";
                $encodeJson = json_encode($message);
                file_put_contents($fileName,$encodeJson);
            }
            
        } 
        else {
            //echo "Cannot have a empty field, try again.";
            $message = "Cannot have a empty field, try again.";
            $encodeJson = json_encode($message);
            file_put_contents($fileName,$encodeJson);
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
            <title>Technican Registration</title>
            <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <style>
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
            right: 50%;
            bottom: 50%;
            transform: translate(50%,50%);
            position: absolute;
            text-align: center;
            vertical-align: center;
            margin: 0 auto;
            background-color: whitesmoke;
            border-radius: 2px;
            border: 3px solid black;
            width: 25%;
            padding: 5%;
        }

        body{
            background-color: darkgrey;
        }
    </style>
    <body>
            <div id="formbox">
                    <form method="post">
                            <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Technician Registration</div>
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
                            <a href="LoginPage.php" style="font-size: 17px; color: black; font-weight: bold;">Login</a><br><br>
                            <a href="registerPharmacist.php" style="font-size: 17px; color: black; font-weight: bold;">Register As Pharmacist</a><br><br>
                    </form>
            </div>
    </body>
</html>
