<?php
    session_start();

    include("connections.php");
    include("LoginChecker.php");

    if($_SERVER['REQUEST_METHOD']=="POST"){
        //collect data from the post variables in the html
        $userid = $_POST['userid'];
        $password = $_POST['password'];

        //checks to see if the userid and password are valid and arent empty
        if(is_numeric($userid) && !empty($password)){
            //unsure about this section, as userid should contain all userIds or no?
            $DataQuery = "(select Password from users where UserID = '$userid') limit 1";
            $QueryResult = mysqli_query($conn, $DataQuery);

            if($QueryResult && mysqli_num_rows($QueryResult) >= 1){
                $userSessionData = mysqli_fetch_assoc($QueryResult);

                if($userSessionData['Password'] == $password){
                    $_SESSION['UserID'] = $userid;

                    header("Location: index.php");
                    die;
                }
            }
            echo "Invalid/Incorrect Email or Password.";
        }
        else{
            echo "Invalid Information. Try again.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href = "style.css" text="text/css">
</head>

<body>
    <div id = "formbox">

        <form method="post">
            <div style="font-size: 16px; margin: 12px; color: black; font-weight:bold;">Login</div>

            <p>
                <label>UserID:</label>
                <input id="textbox" type="text" name="userid"/>
            </p>
            <p>
                <label>Password:</label>
                <input id="textbox" type="password" name="password"/>
            </p>

            <input id="buttonStuff" type="submit" value="Login"/>
            <br>
            <a href="registration.php">Click Here to Register</a>
            <br>
        </form>
    </div>
</body>
</html>

