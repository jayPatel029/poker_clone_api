<?php
include('index.php');


//get game IDs
$sql = "SELECT game_id FROM Games WHERE status = 'waiting'";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    $game_ids = array();
    while ($row = $result->fetch_assoc()) {
        $game_ids[] = $row["game_id"];
    }
    $response["success"] = true;
    $response["game_ids"] = $game_ids;
} else {
    $response["success"] = false;
    $response["message"] = "No available games found";
}

echo json_encode($response);

$conn->close();
?>
