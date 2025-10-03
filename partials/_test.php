<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "users";

$conn =mysqli_connect($host, $user, $pass, $db);
if ($conn){
    echo "Connected successfully!";
}
else{
    die("error". mysqli_connect_error());
}

?>