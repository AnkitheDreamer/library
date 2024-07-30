<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: user_login.php');
}

$user = $_SESSION['user'];
$conn = new mysqli("localhost", "root", "", "library");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        
        $update_photo = '';
        if (!empty($_FILES['photo']['name'])) {
            $photo = $_FILES['photo']['name'];
            $target = "uploads/" . basename($photo);
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                $update_photo = ", photo='$photo'";
            }
        }

        $sql = "UPDATE users SET name='$name', dob='$dob', gender='$gender', email='$email', phone='$phone', password='$password' $update_photo WHERE id=".$user['id'];
        if (mysqli_query($conn, $sql)) {
            echo "Profile updated";
            // Update session data
            $result = mysqli_query($conn, "SELECT * FROM users WHERE id=".$user['id']);
            $_SESSION['user'] = mysqli_fetch_assoc($result);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete'])) {
        $sql = "DELETE FROM users WHERE id=".$user['id'];
        if (mysqli_query($conn, $sql)) {
            session_destroy();
            header('Location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>User Dashboard</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="register.php">Register</a>
            <a href="user_login.php">User Login</a>
            <a href="admin_login.php">Admin Login</a>
        </nav>
    </header>
    <form action="user_dashboard.php" method="post" enctype="multipart/form-data">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<?php echo $user['dob']; ?>" required><br>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
        </select><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" required><br>
        <label for="photo">Upload New Photo:</label>
        <input type="file" id="photo" name="photo"><br>
        <button type="submit" name="update">Update</button>
        <button type="submit" name="delete">Delete</button>
    </form>
    <footer>
        <p>&copy; 2024 Library System</p>
    </footer>
</body>
</html>
