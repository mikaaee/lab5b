<?php
session_start(); // Start the session
include 'db_config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $sql = "SELECT matric, name, role, password FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['matric'] = $user['matric'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Redirect to the display page
            header("Location: display.php");
            exit();
        } else {
            echo "<p>Invalid password!</p>";
        }
    } else {
        echo "<p>Invalid username or password, try <a href='login.php' style='color:blue; text-decoration:underline;'>login</a> again</p>";
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
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
    <form method="POST" action="login.php" class="login-form">
        <label for="matric">Matric:</label> 
        <input type="text" name="matric" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <p class="register-link">Don't have an account? <a href="registration.php">Register here</a></p>
</body>
</html>
