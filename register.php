<?php
include 'db_connection.php';

$register_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $usertype = $_POST['usertype'];  // Get user type from the form

    // Check if email already exists
    $checkEmail = "SELECT * FROM students WHERE email = '$email'";
    $emailResult = $conn->query($checkEmail);

    if ($emailResult->num_rows > 0) {
        $register_error = "Email already exists. Please use a different email.";
    } else {
        // Insert new user data
        $sql = "INSERT INTO students (email, password, first_name, last_name, gender, age, usertype) 
                VALUES ('$email', '$password', '$first_name', '$last_name', '$gender', '$age', '$usertype')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");  // Redirect to login page after successful registration
            exit();
        } else {
            $register_error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Create an Account</h2>
    <form action="register.php" method="POST">
        <label>Email:</label>
        <input type="text" name="email" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <label>First Name:</label>
        <input type="text" name="first_name" required>
        <br>
        <label>Last Name:</label>
        <input type="text" name="last_name" required>
        <br>
        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <br>
        <label>Age:</label>
        <input type="text" name="age" required>
        <br>
        <label>User Type:</label>
        <select name="usertype" required>
            <option value="Student">Student</option>
        </select>
        <br>
        <button type="submit">Register</button>
    </form>
    <?php if ($register_error): ?>
        <p style="color: red;"><?php echo $register_error; ?></p>
    <?php endif; ?>
</body>
</html>
