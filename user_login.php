<?php
session_start();

include('index.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // SQL statement using prepared statements
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // verufy hashed password
        if (password_verify($password, $row["password"])) {
            // Set user session
            $_SESSION['user_id'] = $row['id'];
            echo json_encode(array("message" => "Login successful", "user_id" => $row['id']));
        } else {
            echo json_encode(array("message" => "Incorrect password"));
        }
    } else {
        echo json_encode(array("message" => "User not found"));
    }

    $stmt->close();
    $conn->close();
}
?>
