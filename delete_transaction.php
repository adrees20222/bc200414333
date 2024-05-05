<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if transaction_id parameter is provided in the URL
if(isset($_GET['transaction_id'])) {
	$transaction_id = $_GET['transaction_id'];
	// Perform database delete to remove the transaction
	$sql = "DELETE FROM transactions WHERE transaction_id = $transaction_id";
	if(mysqli_query($conn, $sql)) {
		// Transaction deleted successfully, redirect back to transaction management page
		header("Location: transactions_manage.php");
		exit();
	} else {
		// Error occurred while deleting transaction
		$error = "Error: " . mysqli_error($conn);
	}
} else {
	// Redirect to transaction management page if transaction_id parameter is not provided
	header('Location: transactions_manage.php');
	exit();
}
?>