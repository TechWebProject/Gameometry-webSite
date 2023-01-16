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

//Per rimuovere dal nome le estensioni
function RemoveSpecialChar($dir,$n){
    $res = str_replace( array( '.webp', '.jpg',
    '.png' , '.jpeg'), '', $dir[$n]);
    return $res;
}

?>