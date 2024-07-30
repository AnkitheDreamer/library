<?php
session_start();
$conn = new mysqli("localhost", "root", "", "library");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded admin credentials
    $admin_username = 'admin';
    $admin_password = 'admin123';

    if ($username == $admin_username && $password == $admin_password) {
        $_SESSION['admin'] = true;
        header('Location: admin_dashboard.php');
    } else {
        echo "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Admin Login</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="register.php">Register</a>
            <a href="user_login.php">User Login</a>
            <a href="admin_login.php">Admin Login</a>
        </nav>
    </header>
    <form action="admin_login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <footer>
        <p>&copy; 2024 Library System</p>
    </footer>
</body>
</html>
