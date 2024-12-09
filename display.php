<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Users List</h1>
        <table>
            <thead>
                <tr>
                    <th>Matric</th>
                    <th>Name</th>
                    <th>Access Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "lab_5b";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("<div class='error'>Connection failed: " . $conn->connect_error . "</div>");
                }

                // Fetch data from users table
                $sql = "SELECT matric, name, role FROM users";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["matric"]. "</td>
                                <td>" . $row["name"]. "</td>
                                <td>" . $row["role"]. "</td>
                                <td class='action-buttons'>
                                    <a href='update.php?matric=" . $row["matric"] . "' class='btn-update'>Update</a>
                                    <a href='del_user.php?matric=" . $row["matric"] . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='no-data'>No users found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <div class="navigation">
            <a href="login.php" class="btn-back">Logout</a>
        </div>
    </div>
</body>
</html>