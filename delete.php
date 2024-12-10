<?php
require 'session_management.php'; // Includes session handling
require 'database.php'; // Includes the shared database connection

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    $conn = new mysqli('localhost', 'root', '', 'Lab_5b');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the record
    $sql = "DELETE FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);

    if ($stmt->execute()) {
        header('Location: home.php'); // Redirect back to the home page after deletion
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Matric not provided.";
}
?>
