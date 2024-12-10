<?php
require 'session_management.php'; // Includes session handling
require 'database.php'; // Includes the shared database connection

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Fetch the existing record
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "No record found.";
        exit;
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Update the record
    $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        header('Location: home.php'); // Redirect back to the home page after update
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        html, body {
            height: 100%; /* Ensure the html and body take up the full height of the viewport */
            margin: 0; /* Remove default margin */
        }
        .background{
            background-image: url('image2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            text-align: center;
        }
        h1{
            color: white;  
            margin-top: 50px;
            font-size: 48px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class= "background">
    <br>
    <h1>Update User</h1>
    <br>
    <div class= "container-box">
        <!-- Update form -->
        <form method="POST" action="">
            <input type="hidden" name="matric" value="<?php echo $user['matric']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>

            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="Lecture" <?php echo ($user['role'] === 'Lecture') ? 'selected' : ''; ?>>Lecture</option>
                <option value="Student" <?php echo ($user['role'] === 'Student') ? 'selected' : ''; ?>>Student</option>
            </select>

            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>
