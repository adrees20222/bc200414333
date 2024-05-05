<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Handle form submission to update an existing invoice
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$invoice_id = $_POST['invoice_id'];
	$customer_id = $_POST['customer_id'];
	$date = $_POST['date'];
	$total_amount = $_POST['total_amount'];
	$due_date = $_POST['due_date'];

	// Perform database update to update the invoice
	$sql = "UPDATE invoices SET customer_id = $customer_id, date = '$date', total_amount = $total_amount, due_date = '$due_date' WHERE invoice_id = $invoice_id";
	if(mysqli_query($conn, $sql)) {
		// Invoice updated successfully, redirect back to invoice management page
		header("Location: invoices_manage.php");
		exit();
	} else {
		// Error occurred while updating invoice
		$error = "Error: " . mysqli_error($conn);
	}
}
?>