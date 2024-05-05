<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Handle form submission to update an existing voucher
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$voucher_id = $_POST['voucher_id'];
	$user_id = $_POST['user_id'];
	$voucher_type = $_POST['voucher_type'];
	$voucher_status = $_POST['voucher_status'];

	// Perform database update to update the voucher
	$sql = "UPDATE vouchers SET user_id = $user_id, voucher_type = '$voucher_type', voucher_status = '$voucher_status' WHERE voucher_id = $voucher_id";
	if(mysqli_query($conn, $sql)) {
		// Voucher updated successfully, redirect back to voucher management page
		header("Location: vouchers_manage.php");
		exit();
	} else {
		// Error occurred while updating voucher
		$error = "Error: " . mysqli_error($conn);
	}
}
?>