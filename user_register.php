<?php

include('index.php');

// POST req to enter name,email,pass.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // hash the entred pass and stor it in new var.
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // POST name,email,hashed pass in the db
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(array("message" => "User registered successfully"));
    } else {
        echo json_encode(array("message" => "Error: " . $stmt->error));
    }
    $stmt->close();
    $conn->close();
}


?>
