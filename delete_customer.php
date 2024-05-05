<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if customer_id parameter is provided in the URL
if(isset($_GET['customer_id'])) {
	$customer_id = $_GET['customer_id'];
	// Perform database delete to remove the customer
	$sql = "DELETE FROM customers WHERE customer_id = $customer_id";
	if(mysqli_query($conn, $sql)) {
		// Customer deleted successfully, redirect back to customer management page
		header("Location: customers_manage.php");
		exit();
	} else {
		// Error occurred while deleting customer
		$error = "Error: " . mysqli_error($conn);
	}
} else {
	// Redirect to customer management page if customer_id parameter is not provided
	header('Location: customers_manage.php');
	exit();
}
?>