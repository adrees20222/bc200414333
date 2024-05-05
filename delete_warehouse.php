<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

if(isset($_GET['id'])) {
    $warehouse_id = $_GET['id'];
    $sql = "DELETE FROM warehouses WHERE warehouse_id = $warehouse_id";
    if(mysqli_query($conn, $sql)) {
        header("Location: warehouses_manage.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Warehouse - Warehouse Management System</title>
    <!-- Include CSS stylesheets or other necessary meta tags -->
</head>
<body>
    <!-- Include header.php -->
    <?php include 'header.php'; ?>
    
    <h1>Delete Warehouse</h1>
    <!-- Display confirmation message -->
    <p>Warehouse deleted successfully!</p>

    <!-- Display error message if any -->
    <?php if(isset($error)) echo "<p>$error</p>"; ?>

    <!-- Include footer.php -->
    <?php include 'footer.php'; ?>
</body>
</html>