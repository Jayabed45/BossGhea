<?php
session_start();
include 'db_connection.php';

// Redirect if not logged in or if the user type is not "Student"
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Student') {
    header("Location: login.php");
    exit();
}

// Fetch student data based on session user ID
$student_id = $_SESSION['user_id'];
$sql = "SELECT * FROM students WHERE id = $student_id AND usertype = 'Student'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $student = $result->fetch_assoc();
} else {
    echo "Error: Student profile not found.";
    exit();
}

// Handle form submission to update profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];

    // Update query for profile
    $update_sql = "UPDATE students SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        email = '$email', 
        gender = '$gender', 
        age = '$age' 
        WHERE id = $student_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Profile updated successfully.";
        // Fetch updated data
        $result = $conn->query($sql);
        $student = $result->fetch_assoc();
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    // Handle password change
    if (!empty($_POST['new_password']) || !empty($_POST['confirm_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password === $confirm_password) {
            // Update query for password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $password_sql = "UPDATE students SET password = '$hashed_password' WHERE id = $student_id";

            if ($conn->query($password_sql) === TRUE) {
                echo "Password updated successfully.";
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            echo "Passwords do not match.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
</head>
<body>
    <h2>Student Profile</h2>
    
    <form action="" method="POST">
        <p><strong>First Name:</strong> <input type="text" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required></p>
        <p><strong>Last Name:</strong> <input type="text" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required></p>
        <p><strong>Email:</strong> <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required></p>
        <p><strong>Gender:</strong> 
            <select name="gender" required>
                <option value="Male" <?php if($student['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($student['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if($student['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>
        </p>
        <p><strong>Age:</strong> <input type="number" name="age" value="<?php echo htmlspecialchars($student['age']); ?>" required></p>
        
        <h3>Change Password</h3>
        <p><strong>New Password:</strong> <input type="password" name="new_password" placeholder="New Password"></p>
        <p><strong>Confirm Password:</strong> <input type="password" name="confirm_password" placeholder="Confirm Password"></p>
        
        <button type="submit">Update Profile</button>
    </form>

    <a href="student_dashboard.php">Back to Dashboard</a>
    <a href="logout.php">Logout</a>
</body>
</html>
