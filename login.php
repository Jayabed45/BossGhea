<?php
session_start();
include 'db_connection.php';

$error = '';  // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    // Login handling
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user['usertype'];

        // Redirect based on user type
        if ($user['usertype'] === 'Admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: student_dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BSIT Student Profile System</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
<div class="container">
  <div class="forms-container">
    <div class="form-control signup-form">
      <form action="register.php" method="POST"> <!-- Point to register.php for signup -->
        <h2>Signup</h2>
        <input type="text" name="username" placeholder="Username" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="password" name="confirm_password" placeholder="Confirm password" required />
        <button type="submit" name="signup">Sign up</button>
      </form>
    </div>
    
    <div class="form-control signin-form">
      <form action="login.php" method="POST">
        <h2>Signin</h2>
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit" name="signin">Sign in</button>
      </form>
      <?php if (!empty($error)): ?>
          <p style="color: red;"><?php echo $error; ?></p>
      <?php endif; ?>
    </div>
  </div>
  
  <div class="intros-container">
    <div class="intro-control signin-intro">
      <div class="intro-control__inner">
      <img src="img/bsitlogo.png" alt="Welcome Back" width="40%" height="50%" />
        <h2>Welcome back!</h2>
        <p>Welcome back! Dear BSIT Student</p>
        <a href="register.php" id="signup-btn" >No account yet? Signup.</a>
      </div>
    </div>
    
    <div class="intro-control signup-intro">
      <div class="intro-control__inner">
      <img src="img/bsitlogo.png" alt="Welcome Back" width="50%" height="50%" />
        <h2>Come join us!</h2>
        <p>Be Part of our journy as a BSIT!.</p>
        <button id="signin-btn">Already have an account? Sign in.</button>
      </div>
    </div>
  </div>
</div>

<script src="login.js"></script> <!-- Link to JavaScript file for form toggle functionality -->
</body>
</html>
