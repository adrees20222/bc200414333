<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if ledger_id parameter is provided in the URL
if(isset($_GET['ledger_id'])) {
	$ledger_id = $_GET['ledger_id'];
	// Perform database delete to remove the ledger entry
	$sql = "DELETE FROM ledger WHERE ledger_id = $ledger_id";
	if(mysqli_query($conn, $sql)) {
		// Ledger entry deleted successfully, redirect back to ledger entry management page
		header("Location: ledger_entries.php");
		exit();
	} else {
		// Error occurred while deleting ledger entry
		$error = "Error: " . mysqli_error($conn);
	}
} else {
	// Redirect to ledger entry management page if ledger_id parameter is not provided
	header('Location: ledger_entries.php');
	exit();
}
?>