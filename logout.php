<?php
session_start(); // Start the session

// Destroy all session data
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session

// Prevent caching of the previous session data
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect to the login page
header('Location: login.php');
exit;
?>