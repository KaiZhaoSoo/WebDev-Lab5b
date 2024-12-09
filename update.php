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
    <title>Update User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Update User</h1>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Update user
            $old_matric = $_POST['old_matric'];
            $new_matric = $_POST['new_matric'];
            $name = $_POST['name'];
            $role = $_POST['role'];

            $sql = "UPDATE users SET matric='$new_matric', name='$name', role='$role' WHERE matric='$old_matric'";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='success'>User updated successfully</div>";
            } else {
                echo "<div class='error'>Error updating user: " . $conn->error . "</div>";
            }

            $conn->close();
            echo "<div class='navigation'><a href='display.php' class='btn-back'>Back to Users List</a></div>";
        } else {
            // Fetch user data
            $matric = $_GET['matric'];
            $sql = "SELECT * FROM users WHERE matric='$matric'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <form action="update.php" method="post" class="update-form">
                    <input type="hidden" name="old_matric" value="<?php echo $row['matric']; ?>">
                    
                    <div class="form-group">
                        <label for="new_matric">Matric:</label>
                        <input type="text" id="new_matric" name="new_matric" value="<?php echo $row['matric']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select id="role" name="role" required>
                            <option value="student" <?php if($row['role']=='student') echo 'selected'; ?>>Student</option>
                            <option value="lecturer" <?php if($row['role']=='lecturer') echo 'selected'; ?>>Lecturer</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <input type="submit" value="Update User">
                        <a href="display.php" class="btn-cancel">Cancel</a>
                    </div>
                </form>
                <?php
            } else {
                echo "<div class='error'>User not found</div>";
                echo "<div class='navigation'><a href='display.php' class='btn-back'>Back to Users List</a></div>";
            }
        }
        ?>
    </div>
</body>
</html>