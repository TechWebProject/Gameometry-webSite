<?php
function OpenCon(){
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "gameometrydb";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db);
    
    if(!$conn){
        echo 'Connection error: '.mysqli_connect_error();
    }

    return $conn;
}
 
function CloseCon($conn){
    $conn -> close();
}
?>