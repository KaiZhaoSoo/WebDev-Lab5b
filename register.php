<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "", "lab_5b");
    if ($conn->connect_error) die("Connection failed");

    $matric = $conn->real_escape_string($_POST['matric']);
    $name = $conn->real_escape_string($_POST['name']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    $exists = $conn->query("SELECT * FROM users WHERE matric='$matric'");
    if ($exists->num_rows > 0) {
        $error = "Matric number already exists.";
    } else {
        $conn->query("INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')");
        header("Location: login.php");
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Register</title>
</head>
<body>
<div class="container">
    <h1>Register</h1>
    <form method="POST">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="Student">Student</option>
            <option value="Lecturer">Lecturer</option>
        </select>
        <input type="submit" value="Register">
    </form>
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <a href="login.php">Back</a>
</div>
</body>
</html>
