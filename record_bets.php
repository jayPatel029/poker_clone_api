<?php
include('index.php');
session_start();


// ?? logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "message" => "You must be logged in to record a bet"));
    exit; // Stop execution
}

// get userid from...session
$user_id = $_SESSION['user_id'];

/*
query's to get the game ID assc. with the curr. user
gameid --> usergames(table) only if active (i.e. active=1)
*/
$get_game_id_query = "SELECT game_id FROM UserGames WHERE user_id = ? AND is_active = 1";
$stmt = $conn->prepare($get_game_id_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(array("success" => false, "message" => "User is not currently associated with any active game"));
    exit; // Stop execution
}

$row = $result->fetch_assoc();
$game_id = $row['game_id'];

/*
here POST the other data
round num
amt
bet 
etc..
*/

$round_number = $_POST["round_number"];
$amount = $_POST["amount"];
$bet_type = $_POST["bet_type"];

// Insert bet into the 'userbets' table
$insert_query = "INSERT INTO UserBets (user_id, game_id, round_number, amount, bet_type) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("iiids", $user_id, $game_id, $round_number, $amount, $bet_type);

if ($stmt->execute()) {
    echo json_encode(array("success" => true, "message" => "Bet recorded successfully"));
} else {
    echo json_encode(array("success" => false, "message" => "Error recording bet"));
}

$stmt->close();
$conn->close();



?>
