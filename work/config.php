<?php

//Database Information
$db_host = "localhost"; //Host address (most likely localhost)
$db_name = "db_name"; //Name of Database
$db_user = "db_user"; //Name of database user
$db_pass = "db_pass"; //Password for database user

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_errno()) {
    echo "Connection Failed: " . mysqli_connect_errno();
    exit();
}

?>