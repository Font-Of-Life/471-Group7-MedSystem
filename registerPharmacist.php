<?php
session_start();

    // include the files we need
    include("connections.php");
    include("LoginChecker.php");

    // uses SERVER to check if the user has clicked on the post button below in the html to request the post method
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // collect data from the post variables in the html
        $pharmid = $_POST['pharmid'];
        $pharmLicenseNum = $_POST['pharm_license_num'];
		$phone = $_POST['phone'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $password = $_POST['password'];
        $office_address = $_POST['address'];
        $practice_province = $_POST['province'];
        $photo_signature = $_POST['signature'];
        $message = "";

        //checks to see if any of the values are not empty in the post section of the html
        if (!empty($pharmid) && !empty($pharmLicenseNum) && !empty($phone) && !empty($firstName) && !empty($lastName) && !empty($password) && !empty($office_address) && !empty($practice_province) && !empty($photo_signature)) {
            //checks to see if the following values are not numerical values in the post section
            if(!is_numeric($firstName) && !is_numeric($lastName) && !is_numeric($office_address) && !is_numeric($practice_province) && !is_numeric($photo_signature)){
                //checks to see if the following values are numerical values
                if(is_numeric($pharmid) && is_numeric($pharmLicenseNum) && is_numeric($phone)){

                    //the following is used to check if the current values are in the database already
                    //conditionalQuery is the query commands used to retrieve the values in the user table with the same values of UserID as pharmid
                    $conditionalQuery = "select * from users where UserID = '$pharmid'";
                    //retrieves the data from the command given in conditionalQuery from the SQL database
                    $CondQueryRes = mysqli_query($conn, $conditionalQuery);
                    //conditionalQuery2 is the query commands used to retrieve the values in the pharmacist table with the same values of PharmLicense_Num as pharmLicenseNum
                    $conditionalQuery2 = "select * from pharmacist where PharmLicense_Num = '$pharmLicenseNum'";
                    //retrieves the data from the command given in conditionalQuery from the SQL database
                    $CondQueryRes2 = mysqli_query($conn, $conditionalQuery2);

                    //checks to see if the tables are not empty, if so that means they are not registered in the database
                    if(mysqli_num_rows($CondQueryRes2) <= 0 && mysqli_num_rows($CondQueryRes) <= 0){
                        //register the following values into the user table
                        $queryRes = "insert into users (UserID, First_Name, Last_Name, Phone, Password) values ('$pharmid','$firstName','$lastName', '$phone','$password')";
                        //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                        mysqli_query($conn, $queryRes);

                        //register the following values into the pharmacist table
                        $queryRes = "insert into pharmacist (PharmLicense_Num, PharmID, First_Name, Last_Name, Phone, Password, Office_Address, Practice_Province, Photo_Signature) values ('$pharmLicenseNum', '$pharmid', '$firstName', '$lastName', '$phone', '$password', '$office_address', '$practice_province', '$photo_signature')";
                        //insert the following variable queryRes into the user table in the sql Server to update the database in the SQL server
                        mysqli_query($conn, $queryRes);

                        // redirect user to login page so that they can login
                        header("Location: LoginPage.php");
                        die;
                    } 
                    else {
                        //echo "PharmID or License Number already exists, please enter a different value.";
                        $message = "PharmID or License Number already exists, please enter a different value.";
                    }
                } 
                else{
                    //echo "Invalid information, pharmid, pharmLicenseNum, and Phone have to be integers only.";
                    $message = "Invalid information, pharmid, pharmLicenseNum, and Phone have to be integers only.";
                }     
            } 
            else {
                //echo "invalid information. First & last name, office address, practice province, photo signature cannot be integer values only.";
                $message = "invalid information. First & last name, office address, practice province, photo signature cannot be integer values only.";
            }
        } 
        else {
            //echo "Invalid Information Try again. Cannot have a empty field.";
            $message = "Invalid Information Try again. Cannot have a empty field.";
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
            <title>Pharmacist Registration</title>
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
                            <div style="font-size: 22px; margin: 14px; color: black; font-weight:bold;">Pharmacist Registration</div>
                            <p><?php echo $message?></p>
                            <p>
                                <label>PharmID:</label>
                                <input type="text" id="textbox" name="pharmid"/>
                            </p>
                            <p>
                                <label>Pharmacy License #:</label>
                                <input type="text" id="textbox" name="pharm_license_num"/>
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
                            <p>
                                <label>Office Address:</label>
                                <input type="text" id="textbox" name="address"/>
                            </p>
                            <p>
                                <label>Practice Province:</label>
                                <input type="text" id="textbox" name="province"/>
                            </p>
                            <p>
                                <label>Photo signature:</label>
                                <input type="text" id="textbox" name="signature"/>
                            </p>
                            <input id="buttonStuff" type="submit" value="Register Account">
                            <br>
                            <br>
                            <a href="LoginPage.php" style="font-size: 17px; color: black;">Login</a><br><br>
                            <a href="registerTechnican.php" style="font-size: 17px; color: black;">Register As Technican</a><br><br>
                    </form>
            </div>
    </body>
</html>