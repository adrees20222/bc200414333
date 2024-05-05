<?php
session_start();
// Check if user is logged in and has appropriate role
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'manager')) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_config.php';

// Check if product_id parameter is provided in the URL
if(isset($_GET['product_id'])) {
    // Retrieve product_id from URL parameter
    $product_id = $_GET['product_id'];

    // Perform database delete to remove the product
    $sql = "DELETE FROM products WHERE product_id = $product_id";
    if(mysqli_query($conn, $sql)) {
        // Product deleted successfully, redirect back to product management page
        header("Location: products_manage.php");
        exit();
    } else {
        // Error occurred while deleting product
        $error = "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect back to product management page if product_id parameter is not provided
    header("Location: products_manage.php");
    exit();
}
?>