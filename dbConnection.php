<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "ops";

// <-----------------------Creating Connection-------------------->
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);


//<---------------------- Checking for connection--------------------> 
if($conn->connect_error){
    die("connection failed");
    echo "<script> alert('Connection Failed')</script>";
}
else{
    // echo "connect";
}
?>