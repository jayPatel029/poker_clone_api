<?php

header("Content-Type: application/json");
// Allow from any origin
header("Access-Control-Allow-Origin: *");
// Allow specific HTTP methods
header("Access-Control-Allow-Methods: GET, PUT, PATCH, POST, DELETE");
// Allow specific headers
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


$servername = "localhost";
$username = "root";
$password = "";
$database = "poker1";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "connected!!"
?>
