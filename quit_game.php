<?php

include('index.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "message" => "You must be logged in to quit the game"));
    exit; // Stop 
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Get game ID via POST 
$game_id = mysqli_real_escape_string($conn, $_POST["game_id"]);

// Check if the game ID is associated with the logged-in user
$check_game_query = "SELECT COUNT(*) AS count FROM UserGames WHERE user_id = ? AND game_id = (SELECT id FROM Games WHERE game_id = ?)";
$stmt_check_game = $conn->prepare($check_game_query);
$stmt_check_game->bind_param("is", $user_id, $game_id);
$stmt_check_game->execute();
$result_check_game = $stmt_check_game->get_result();
$row_check_game = $result_check_game->fetch_assoc();

if ($row_check_game['count'] == 0) {
    echo json_encode(array("success" => false, "message" => "The game ID provided is not associated with your account"));
    exit;
}

// Prepare and execute SQL statement to update user state and deactivate user in UserGames table
$update_query = "UPDATE UserGames SET player_state = 'folded', is_active = false WHERE user_id = ? AND game_id = (SELECT id FROM Games WHERE game_id = ? AND status = 'waiting')";

$stmt_update = $conn->prepare($update_query);
$stmt_update->bind_param("is", $user_id, $game_id);

if ($stmt_update->execute()) {
    // If update is successful, decrement num_players in GameInfo table
    $update_game_info_query = "UPDATE GameInfo SET num_players = num_players - 1 WHERE game_id = ?";
    $stmt_update_game_info = $conn->prepare($update_game_info_query);
    $stmt_update_game_info->bind_param("s", $game_id);
    $stmt_update_game_info->execute();
    
    // Logout the user
    session_unset();
    session_destroy();
    
    echo json_encode(array("success" => true, "message" => "You have quit the game successfully"));
} else {
    echo json_encode(array("success" => false, "message" => "Error quitting the game"));
}

$stmt_check_game->close();
$stmt_update->close();
$stmt_update_game_info->close();
$conn->close();



?>
