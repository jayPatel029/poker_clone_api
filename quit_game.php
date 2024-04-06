<?php
include('index.php');
session_start();


// ?? logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "message" => "You must be logged in to quit the game"));
    exit; // Stop 
}

// Get user ID from...session
$user_id = $_SESSION['user_id'];

// enter gameid via POST 
$game_id = mysqli_real_escape_string($conn, $_POST["game_id"]);

// stmts to prevent SQL injection
$update_query = "UPDATE UserGames SET player_state = 'folded', is_active = false WHERE user_id = ? AND game_id = (SELECT id FROM Games WHERE game_id = ? AND status = 'waiting')";

$stmt_update = $conn->prepare($update_query);
$stmt_update->bind_param("is", $user_id, $game_id);

if ($stmt_update->execute()) {
    // Logout 
    session_unset();
    session_destroy();
    echo json_encode(array("success" => true, "message" => "You have quit the game successfully"));
} else {
    echo json_encode(array("success" => false, "message" => "Error quitting the game"));
}

$stmt_update->close();
$conn->close();


?>
