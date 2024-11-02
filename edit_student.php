<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Admin') {
    header("Location: login.php");
    exit();
}

// Fetch student details
if (isset($_GET['id'])) {
    $studentId = intval($_GET['id']);
    $sql = "SELECT * FROM students WHERE id = $studentId";
    $result = $conn->query($sql);
    $student = $result->fetch_assoc();
}

// Handle form submission for updating the student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $age = intval($_POST['age']);
    $usertype = $_POST['usertype'];

    $updateSql = "UPDATE students SET email='$email', first_name='$first_name', last_name='$last_name', gender='$gender', age=$age, usertype='$usertype' WHERE id=$studentId";
    
    if ($conn->query($updateSql) === TRUE) {
        header("Location: admin_dashboard.php?message=Student updated successfully.");
        exit();
    } else {
        echo "Error updating student: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <form action="" method="POST">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
        <br>
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
        <br>
        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
        <br>
        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>
        <br>
        <label>Age:</label>
        <input type="number" name="age" value="<?php echo htmlspecialchars($student['age']); ?>" required>
        <br>
        <label>User Type:</label>
        <select name="usertype" required>
            <option value="Student" <?php echo ($student['usertype'] == 'Student') ? 'selected' : ''; ?>>Student</option>
            <option value="Admin" <?php echo ($student['usertype'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
        </select>
        <br>
        <button type="submit">Update Student</button>
    </form>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
