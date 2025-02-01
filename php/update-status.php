<?php
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.php";
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    // Add timestamp to track last activity
    $current_time = time();
    $sql = mysqli_query($conn, "UPDATE users SET 
                               status = '{$status}',
                               last_activity = '{$current_time}' 
                               WHERE unique_id = {$_SESSION['unique_id']}");
    if(!$sql) {
        echo "Status update failed";
    }
}
?>