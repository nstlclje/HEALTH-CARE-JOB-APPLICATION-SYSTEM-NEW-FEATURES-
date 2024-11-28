<?php
session_start(); 

if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name']; 
    log_activity($user_name, "Logged out"); 
}

session_destroy();

header("Location: login.php");
exit();
?>
