<?php

// $servername = "127.0.0.1:3307";
$servername = "localhost";
$user = "root";
$password = "";
$dbname = "pupwebsite";

$conn = new mysqli($servername, $user, $password, $dbname);

if ($conn->connect_error){
    die("Connection error: ". $conn->connect_error);
}
?>