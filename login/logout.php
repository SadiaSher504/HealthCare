<?php
// Start session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page or wherever appropriate
header("location: login.php"); // Replace login.php with your actual login page
exit();
?>
