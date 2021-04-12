<?php
    session_start();

    //checks to see if the user is currently logged in
    if (isset($_SESSION['UserID'])) {
        //if so then it logs the user out
        unset($_SESSION['UserID']);
    }

    //sends the user back to the login page
    header("Location: LoginPage.php");
    die;
?>