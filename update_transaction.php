<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Handle form submission to update an existing transaction
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$transaction_id = $_POST['transaction_id'];
	$product_id = $_POST['product_id'];
	$voucher_id = $_POST['voucher_id'];
	$transaction_type = $_POST['transaction_type'];
	$quantity = $_POST['quantity'];
	$transaction_date = $_POST['transaction_date'];

	// Perform database update to update the transaction
	$sql = "UPDATE transactions SET product_id = $product_id, voucher_id = $voucher_id, transaction_type = '$transaction_type', quantity = $quantity, transaction_date = '$transaction_date' WHERE transaction_id = $transaction_id";
	if(mysqli_query($conn, $sql)) {
		// Transaction updated successfully, redirect back to transaction management page
		header("Location: transactions_manage.php");
		exit();
	} else {
		// Error occurred while updating transaction
		$error = "Error: " . mysqli_error($conn);
	}
}
?>