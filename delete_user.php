<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
}

$conn = new mysqli("localhost", "root", "", "library");
$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    header('Location: admin_dashboard.php');
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
