<?php
session_start();
require_once 'db_config.php';

// Check if the user is already logged in, redirect to appropriate dashboard
if(isset($_SESSION['user_id'])) {
    if($_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard.php");
    } elseif($_SESSION['role'] == 'manager') {
        header("Location: manager_dashboard.php");
    } elseif($_SESSION['role'] == 'user') {
        header("Location: user_dashboard.php");
    }
    exit();
}

// Handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT user_id, username, role FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        // Redirect to appropriate dashboard based on role
        if($row['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } elseif($row['role'] == 'manager') {
            header("Location: manager_dashboard.php");
        } elseif($row['role'] == 'user') {
            header("Location: user_dashboard.php");
        }
        exit();
    } else {
        $error = "Your Login Name or Password is invalid";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Warehouse Management System</title>
    <!-- Include CSS stylesheets or other necessary meta tags -->
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <?php
    // Display error message if login attempt failed
    if(isset($error)) {
        echo "<p>$error</p>";
    }
    ?>
</body>
</html>