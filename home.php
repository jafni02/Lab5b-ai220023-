<?php
require 'session_management.php'; // Handles session management and session timeout
require 'database.php'; // Use the shared database connection

// Get the user's name from the session (already set during login)
$user_name = $_SESSION['user']['name']; // Assuming 'name' is stored in the session

// Fetch user data from the database
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        html, body {
            height: 100%; 
            margin: 0; 
        }
        .background{
            background-image: url('image2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            text-align: center;
        }
    </style>
</head>
<body class= "background">
    <br>
    <!-- Display the user's name -->
    <h1>Welcome,<br> <?php echo htmlspecialchars($user_name); ?>!</h1> 
    <div class= "container-box">
        <nav>
            <!-- Log out button -->
            <button style="background-color: green; width: 150px; padding: 10px; border: 1px solid #ccc;" 
            onclick="location.href='logout.php'">Log Out</button>
        </nav>
        <br>

        <!-- Table to display user information -->
        <table>
        <thead>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through each user record -->
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['matric']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <!-- Links for actions -->
                    <a href="update.php?matric=<?php echo $row['matric']; ?>">Update</a> | 
                    <a href="delete.php?matric=<?php echo $row['matric']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</body>
</html>

