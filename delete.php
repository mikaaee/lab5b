<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Delete User</title>
</head>
<body>
    <h2>Delete User</h2>
    <?php
    include 'db_config.php';
    if (isset($_GET['matric'])) {
        $matric = $_GET['matric'];
        $sql = "DELETE FROM users WHERE matric = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $matric);

        if ($stmt->execute()) {
            echo "<p class='success'>User deleted successfully!</p>";
            header("Refresh: 2; url=display.php");
            exit();
        } else {
            echo "<p class='error'>Error deleting user: " . $conn->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<p class='error'>Invalid request!</p>";
        exit();
    }
    ?>
    <div class="back-container">
        <a href="display.php">Back to User List</a>
    </div>
</body>
</html>
