<?php
session_start();

// Set timeout duration (5 minutes = 300 seconds)
$timeout_duration = 300;

// Check if "session_expiry" is set
if (isset($_SESSION['session_expiry'])) {
    if (time() > $_SESSION['session_expiry']) {
        // Destroy the session and redirect to login
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit;
    }
} else {
    // Set session expiry when the session starts
    $_SESSION['session_expiry'] = time() + $timeout_duration;
}

// Check if the user is logged in
if (!isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    header('Location: login.php');
    exit;
}

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
