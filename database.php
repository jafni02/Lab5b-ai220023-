<?php
// Database configuration
$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'Lab_5b';

// Create a new MySQLi connection
$conn = new mysqli($host, $db_user, $db_password, $db_name);

// Check for connection errors
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
