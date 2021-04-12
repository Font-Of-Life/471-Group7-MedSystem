<?php

function isLoggedIn($conn){
    //checks to see if the user is logged in.
    if(isset($_SESSION['UserID'])){
        //checks to see if the current UserID is in the database contained in the users table.
        $userid = $_SESSION['UserID'];
        $getQuery = "select * from users where UserID = '$userid' limit 1";
        //get the resulting query from the sql database with the current connection
        $queryresult = mysqli_query($conn,$getQuery);
        
        //checks to see resulting query has rows bigger than 0
        if($queryresult && mysqli_num_rows($queryresult) != 0){
            //if so then it gets the queryresult and saves it to the variable userSessionData and then returns it
            $userSessionData = mysqli_fetch_assoc($queryresult);
            return $userSessionData;
        }

        //this section and the one below is not really needed but im leaving it here for now, does the same thing as before
        $getQuery = "select * from technican where TechID = $userid limit 1";
        $queryresult = mysqli_query($conn,$getQuery);
        if($queryresult && mysqli_num_rows($queryresult) != 0){
            $userSessionData = mysqli_fetch_assoc($queryresult);
            return $userSessionData;
        }

        $getQuery = "select * from pharmacist where PharmID = $userid limit 1";
        $queryresult = mysqli_query($conn,$getQuery);
        if($queryresult && mysqli_num_rows($queryresult) != 0){
            $userSessionData = mysqli_fetch_assoc($queryresult);
            return $userSessionData;
        }   
    }
    header("Location: loginPage.php");
    die;
}
?>