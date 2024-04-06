    <?php

include('index.php');

    session_start();

    //  ??login
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(array("success" => false, "message" => "You must be logged in to join a game"));
        exit; // quit...if not
    }

    
    // get user ID via..session
    $user_id = $_SESSION['user_id'];


    // enter gameid via POST
    $game_id = mysqli_real_escape_string($conn, $_POST["game_id"]);

    //  stmts to prevent SQL injection
    $insert_query = "INSERT INTO UserGames (user_id, game_id) VALUES (?, (SELECT id FROM Games WHERE game_id = ? AND status = 'waiting'))";
    $update_query = "INSERT INTO GameInfo (game_id, status, num_players, timestamp) VALUES (?, 'waiting', 1, NOW()) ON DUPLICATE KEY UPDATE num_players = num_players + 1";

    $stmt_insert = $conn->prepare($insert_query);
    $stmt_insert->bind_param("is", $user_id, $game_id);

    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param("s", $game_id);

    if ($stmt_insert->execute() && $stmt_update->execute()) {
        echo json_encode(array("success" => true, "message" => "You have joined the game successfully"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error joining the game"));
    }

    $stmt_insert->close();
    $stmt_update->close();
    $conn->close();


    ?>
