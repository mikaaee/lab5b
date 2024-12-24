<?php
include 'db_config.php'; // Include database connection
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}


$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>User List</title>
</head>
<body>
    <h2>User List</h2>
    <!-- Add Logout Button -->
    <div class="logout-container">
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
    <table border="1">
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['matric']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['role']}</td>
                         <td><a href='update.php?matric={$row['matric']}'>Update</a></td>
                <td><a href='delete.php?matric={$row['matric']}'>Delete</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
        }

        
        $conn->close();
        ?>
    </table>
</body>
</html>
