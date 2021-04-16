<?php
//sets up the connections to the server

$db_hostname = "localhost";
$db_username = "root";     //Change your username here to be your mySQL server username
$db_password = "Robert040191!"; //change your password here to be your MYSQL server password
$db_name = "med_database_test";  //the name of the sql database file

//if there is no connection to the server, kills the process, and display the message connection failed.
if(!$conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_name)){
    die("Connection has failed.");
}

?>
