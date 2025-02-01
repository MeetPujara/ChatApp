<?php
session_start();
include_once "config.php";

if(isset($_SESSION['unique_id'])){
    $logout_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);
    $status = "Offline now";
    $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$logout_id}");
}
?>