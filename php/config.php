<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chatapp";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
    exit();
  }
  
  // Secure session configuration
  ini_set('session.gc_maxlifetime', 3600); // 1 hour
  ini_set('session.cookie_lifetime', 0); // Until browser closes
  ini_set('session.use_strict_mode', 1);
  ini_set('session.cookie_httponly', 1);
  ini_set('session.use_only_cookies', 1);
  
  // If you're using HTTPS, uncomment these:
  // ini_set('session.cookie_secure', 1);
  // ini_set('session.cookie_samesite', 'Strict');
  
  session_set_cookie_params([
      'lifetime' => 0,
      'path' => '/',
      'domain' => '',
      'secure' => false, // Set to true if using HTTPS
      'httponly' => true
  ]);
?>