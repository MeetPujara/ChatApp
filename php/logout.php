<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id) && $logout_id === $_SESSION['unique_id']){ // Added security check
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE users SET 
                                      status = '{$status}',
                                      last_activity = '0' 
                                      WHERE unique_id = {$logout_id}");
            if($sql){
                // Clear all session data
                $_SESSION = array();
                
                // Clear session cookie
                if (isset($_COOKIE[session_name()])) {
                    setcookie(session_name(), '', time() - 3600, '/');
                }
                
                // Destroy session
                session_destroy();
                
                // Clear local storage via JavaScript
                echo "<script>localStorage.clear();</script>";
                
                header("location: ../login.php");
                exit();
            }
        }
        header("location: ../users.php");
    }else{  
        header("location: ../login.php");
    }
?>