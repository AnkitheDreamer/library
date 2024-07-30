<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "library");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $photo = $_FILES['photo']['name'];
    $target = "uploads/" . basename($photo);

    // Check if the uploads directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    $sql = "INSERT INTO users (name, dob, gender, email, phone, password, photo) VALUES ('$name', '$dob', '$gender', '$email', '$phone', '$password', '$photo')";
    if (mysqli_query($conn, $sql)) {
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            echo "Registration successful";
        } else {
            echo "Failed to upload photo.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>User Registration</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="register.php">Register</a>
            <a href="user_login.php">User Login</a>
            <a href="admin_login.php">Admin Login</a>
        </nav>
    </header>
    <form action="register.php" method="post" enctype="multipart/form-data">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="photo">Upload Photo:</label>
        <input type="file" id="photo" name="photo" required><br>
        <button type="submit">Register</button>
    </form>
    <footer>
        <p>&copy; 2024 Library System</p>
    </footer>
</body>
</html>
