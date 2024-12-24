<?php
include 'db_config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the data into the database
    $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $matric, $name, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: display.php"); // Redirect to display page after registration
        exit();
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="registration.php">
        Matric: <input type="text" name="matric" required><br>
        Name: <input type="text" name="name" required><br>
        Password: <input type="password" name="password" required><br>
        Role: 
        <select name="role" required>
            <option value="lecturer">Lecturer</option>
            <option value="student">Student</option>
        </select><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
