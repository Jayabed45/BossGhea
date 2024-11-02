<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'Admin') {
    header("Location: login.php");
    exit();
}

// Fetch all students from the database
$sql = "SELECT id, email, first_name, last_name, gender, age, usertype FROM students";
$result = $conn->query($sql);

// Handle delete request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $studentId = intval($_GET['id']);
    $deleteSql = "DELETE FROM students WHERE id = $studentId";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: admin_dashboard.php?message=Student deleted successfully.");
        exit();
    } else {
        echo "Error deleting student: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, Admin!</h2>
    <p>This is the admin dashboard.</p>
    <a href="logout.php">Logout</a>

    <h3>List of Students</h3>
    <?php if (isset($_GET['message'])): ?>
        <p><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>User Type</th>
            <th>Actions</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                    <td><?php echo htmlspecialchars($row['usertype']); ?></td>
                    <td>
                        <a href="edit_student.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit</a> |
                        <a href="?action=delete&id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No students found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
