<?php

include('index.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    // get game info
    $sql = "SELECT * FROM gameInfo";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            //  game info
            $gameInfo = array();
            while ($row = $result->fetch_assoc()) {
                $gameInfo[] = $row;
            }
            echo json_encode($gameInfo);
        } else {
            echo json_encode(array("message" => "No game information found."));
        }
    } else {
        echo json_encode(array("message" => "Error: " . $conn->error));
    }

    $conn->close();
}

?>
