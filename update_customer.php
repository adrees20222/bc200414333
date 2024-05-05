<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Handle form submission to update an existing customer
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$customer_id = $_POST['customer_id'];
	$customer_name = $_POST['customer_name'];
	$contact_info = $_POST['contact_info'];

	// Perform database update to update the customer
	$sql = "UPDATE customers SET customer_name = '$customer_name', contact_info = '$contact_info' WHERE customer_id = $customer_id";
	if(mysqli_query($conn, $sql)) {
		// Customer updated successfully, redirect back to customer management page
		header("Location: customers_manage.php");
		exit();
	} else {
		// Error occurred while updating customer
		$error = "Error: " . mysqli_error($conn);
	}
}
?>