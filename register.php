<?php
require 'database.php'; // Include database connection

$status = ""; // Feedback message
$error = ""; // Empty error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $matric = trim($_POST['matric']);
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Validate input
    if (empty($matric) || empty($name) || empty($password) || empty($role)) {
        $error = "All fields are required!"; // Set error message
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check for duplicate matric
    $stmt = $conn->prepare("SELECT matric FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $error = "Matric number already exists. Please use a different one."; // Set error message
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $matric, $name, $hashedPassword, $role); 
        if ($stmt->execute()) {
            $status = "\n\nRegistration successful! <a href='login.php'>Click here to login</a>"; // Set success message
        } else {
            $status = "Error: " . $stmt->error;
        }
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <script>
        // Function to clear error messages after 5 seconds
        window.onload = function() {
            setTimeout(() => {
                const errorElement = document.querySelector('.error');
                if (errorElement) {
                    errorElement.textContent = ''; // Clear the text content
                }
            }, 5000); // 5000 milliseconds = 5 seconds
        };
    </script>

    <br>
    <h1>Register</h1>
    <br>

    <!-- Registration form -->
    <form method="POST" action="">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="Lecture">Lecture</option>
            <option value="Student">Student</option>
        </select>

        <button type="submit">Register</button>

        <!-- Display the error message -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <br>
        <span> Already have account?  </span><a href="login.php">Login</a>

        <!-- Display the status message -->
        <?php if (!empty($status)): ?>
            <p><?php echo $status; ?></p>
        <?php endif; ?>

    </form>
</body>
</html>
