<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_config.php';

// Check if user ID is provided
if(isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user from the database
    $sql = "DELETE FROM users WHERE user_id = $user_id";
    if(mysqli_query($conn, $sql)) {
        // User deleted successfully, redirect to users_manage.php
        header("Location: users_manage.php");
        exit();
    } else {
        // Error occurred while deleting user
        $error = "Error deleting record: " . mysqli_error($conn);
    }
}
?>