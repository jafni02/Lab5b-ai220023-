<?php
require 'session_management.php'; // Include session management
require 'database.php'; // Include database connection

$error = ""; // Initialize an empty error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $matric = trim($_POST['matric']);
    $password = trim($_POST['password']);

    // Prepare the SQL query
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user data in the session
            $_SESSION['user'] = $user;

            // Redirect to the home page
            header('Location: home.php');
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No user found with that Matric!";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <h1>Login</h1>
    <br>

    <!-- Login form -->
    <form method="POST" action="">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>

        <br>
        <a href="register.php">Register</a><span> here if you have not.</span>

        <!-- Display the error message -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        
    </form>
</body>
</html>

