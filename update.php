<?php
include 'db_config.php'; // Include database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Update query
    $sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        echo "<p>User updated successfully!</p>";
        header("Refresh: 2; url=display.php");
        exit();
    } else {
        echo "<p>Error updating user: " . $conn->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Fetch user data if the page is accessed via GET
    $matric = $_GET['matric'];
    $sql = "SELECT matric, name, role FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "<p>User not found!</p>";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <form method="POST" action="update.php">
        <input type="hidden" name="matric" value="<?php echo $user['matric']; ?>">
        Matric: <strong><?php echo $user['matric']; ?></strong><br>
        Name: <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
        Role:
        <select name="role" required>
            <option value="student" <?php if ($user['role'] == 'student') echo 'selected'; ?>>Student</option>
            <option value="lecturer" <?php if ($user['role'] == 'lecturer') echo 'selected'; ?>>Lecturer</option>
        </select><br>
        <input type="submit" value="Update">
    </form>
        <a href="display.php" class="cancel-button">Cancel</a>
    
</body>
</html>
