<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if invoice_id parameter is provided in the URL
if(isset($_GET['invoice_id'])) {
	$invoice_id = $_GET['invoice_id'];
	// Perform database delete to remove the invoice
	$sql = "DELETE FROM invoices WHERE invoice_id = $invoice_id";
	if(mysqli_query($conn, $sql)) {
		// Invoice deleted successfully, redirect back to invoice management page
		header("Location: invoices_manage.php");
		exit();
	} else {
		// Error occurred while deleting invoice
		$error = "Error: " . mysqli_error($conn);
	}
} else {
	// Redirect to invoice management page if invoice_id parameter is not provided
	header('Location: invoices_manage.php');
	exit();
}
?>