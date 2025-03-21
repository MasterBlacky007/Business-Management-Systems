<?php
$servername = "localhost";
$username = "Nigeeth";
$password = "2018";
$dbname = "poly";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed". $conn->connect_error);
}



?>