<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if voucher_id parameter is provided in the URL
if(isset($_GET['voucher_id'])) {
	$voucher_id = $_GET['voucher_id'];
	// Perform database delete to remove the voucher
	$sql = "DELETE FROM vouchers WHERE voucher_id = $voucher_id";
	if(mysqli_query($conn, $sql)) {
		// Voucher deleted successfully, redirect back to voucher management page
		header("Location: vouchers_manage.php");
		exit();
	} else {
		// Error occurred while deleting voucher
		$error = "Error: " . mysqli_error($conn);
	}
} else {
	// Redirect to voucher management page if voucher_id parameter is not provided
	header('Location: vouchers_manage.php');
	exit();
}
?>