<?php
session_start();
include_once "config.php";

if(isset($_SESSION['unique_id'])) {
    // Check if user exists and get their last activity
    $sql = mysqli_query($conn, "SELECT last_activity FROM users WHERE unique_id = {$_SESSION['unique_id']}");
    
    if(mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $last_activity = $row['last_activity'];
        $current_time = time();
        
        // Check if last activity was within the last hour (3600 seconds)
        if(($current_time - $last_activity) < 3600) {
            // Update last activity time
            mysqli_query($conn, "UPDATE users SET last_activity = '{$current_time}' 
                               WHERE unique_id = {$_SESSION['unique_id']}");
            echo "valid";
        } else {
            // Session expired due to inactivity
            $_SESSION = array();
            session_destroy();
            echo "invalid";
        }
    } else {
        // User not found in database
        $_SESSION = array();
        session_destroy();
        echo "invalid";
    }
} else {
    // No session exists
    echo "invalid";
}
?>