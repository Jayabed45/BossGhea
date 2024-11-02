<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Student') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Welcome to the Student Dashboard</h2>
    <p>You are logged in as a student.</p>

    <a href="student_profile.php">View Profile</a> <!-- Link to profile page -->
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
