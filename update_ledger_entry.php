<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Handle form submission to update an existing ledger entry
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$ledger_id = $_POST['ledger_id'];
	$account_id = $_POST['account_id'];
	$transaction_id = $_POST['transaction_id'];
	$debit = $_POST['debit'];
	$credit = $_POST['credit'];

	// Perform database update to update the ledger entry
	$sql = "UPDATE ledger SET account_id = $account_id, transaction_id = $transaction_id, debit = $debit, credit = $credit WHERE ledger_id = $ledger_id";
	if(mysqli_query($conn, $sql)) {
		// Ledger entry updated successfully, redirect back to ledger entry management page
		header("Location: ledger_entries.php");
		exit();
	} else {
		// Error occurred while updating ledger entry
		$error = "Error: " . mysqli_error($conn);
	}
}
?>