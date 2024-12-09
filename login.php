<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "lab_5b");
    if ($conn->connect_error) die("Connection failed");

    $matric = $conn->real_escape_string($_POST['matric']);
    $password = $conn->real_escape_string($_POST['password']);

    $result = $conn->query("SELECT * FROM users WHERE matric='$matric' AND password='$password'");
    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        header("Location: display.php");
    } else {
        $error = "Invalid matric or password.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
<div class="container">
    <h1>Login</h1>
    <form method="POST">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Login">
    </form>
    <a href="register.php">Register</a>
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
</div>
</body>
</html>
