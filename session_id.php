<?php
session_start(); 

// ?? logged in == session estb.

if(isset($_SESSION['user_id'])) {
    $session_id = session_id(); // sessionid
    $user_id = $_SESSION['user_id']; // userid

    // this is to get the session id and user id of logged in user
    // print session ID and user ID
    echo "Session ID: $session_id<br>";
    echo "User ID: $user_id<br>";

} else {
    // not logged in, 
    echo "User is not logged in";
    exit; // Stop 
}

?>
