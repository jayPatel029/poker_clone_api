<?php

include('index.php');
header("Access-Control-Allow-Origin", "*");
header("Access-Control-Allow-Methods", "GET,PUT,PATCH,POST,DELETE");
header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');

// Select all users
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    $users = array();
    while ($row = $result->fetch_assoc()) {
        // Append each user to the users array
        $users[] = $row;
    }
    $response["success"] = true;
    $response["users"] = $users;
} else {
    $response["success"] = false;
    $response["message"] = "No users found";
}

// Output the response as JSON
echo json_encode($response);

$conn->close();

?>