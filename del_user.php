<?php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_5b";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user
$matric = $_GET['matric'];
$sql = "DELETE FROM users WHERE matric='$matric'";

if ($conn->query($sql) === TRUE) {
    header("Location: display.php");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}

$conn->close();
?>