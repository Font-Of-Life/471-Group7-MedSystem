<?php
    session_start();

    include("connections.php");
    include("LoginChecker.php");

    if($_SERVER['REQUEST_METHOD']=="POST"){
        //collect data from the post variables in the html
        $userid = $_POST['userid'];
        $password = $_POST['password'];
        $message="";

        //checks to see if the userid and password are valid and arent empty
        if(is_numeric($userid) && !empty($password)){
            //LOGIN, prepare statements to prevent sql injection
            $stmt = $conn->prepare('(SELECT Password FROM users where UserID = ?) limit 1');
            $stmt->bind_param('i', $userid); // 'i' specifies the variable type => 'integer'
            $stmt->execute();
            $QueryResult = $stmt->get_result();

            if($QueryResult && mysqli_num_rows($QueryResult) > 0){
                $userSessionData = mysqli_fetch_assoc($QueryResult);

                if($userSessionData['Password'] == $password){
                    $_SESSION['UserID'] = $userid;
                    $loginDataArr['user Login: '] = array("UserID: " => $userid, "Password: "=> $password);
                    $encodeJson = json_encode($loginDataArr);
                    $fileName = 'jsonfile.json';
                    file_put_contents($fileName,$encodeJson);
                    //http_response_code(200);
                    //echo json_encode($loginDataArr);
                    header("Location: index.php");
                    die;
                }
            } 
            else {
                $message="Invalid/Incorrect Email or Password.";
                $encodeJson = json_encode($message);
                $fileName = 'jsonfile.json';
                file_put_contents($fileName,$encodeJson);
                //http_response_code(404);
                //echo json_encode($message);
            }
        }
        else{
            //echo "Invalid Information. Try again.";
            $message="Invalid Information. Try again.";
            $encodeJson = json_encode($message);
            $fileName = 'jsonfile.json';
            file_put_contents($fileName,$encodeJson);
            //http_response_code(400);
            //jsonSend($message);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
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
    <div id = "formbox">
        <form method="post">
            <div style="font-size: 20px; margin: 12px; color: black; font-weight:bold;">Login</div>
            <p><?php echo $message;?></p>
            <p>
                <label>UserID:</label>
                <input id="textbox" type="text" name="userid"/>
            </p>
            <p>
                <label>Password:</label>
                <input id="textbox" type="password" name="password"/>
            </p>

            <input id="buttonStuff" type="submit" value="Login"/>
            <br><br>
            <a href="registration.php" style="font-size: 17px; color: black; font-weight: bold;">Click Here to Register</a>
            <br>
        </form>
    </div>
</body>
</html>
