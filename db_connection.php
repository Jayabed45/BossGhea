<?php
// db_connection.php
$host = "127.0.0.1";
$username = "root"; // Replace with your actual username
$password = ""; // Replace with your actual password
$dbname = "ghea_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
