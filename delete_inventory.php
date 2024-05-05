<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if inventory_id parameter is provided in the URL
if(isset($_GET['inventory_id'])) {
	$inventory_id = $_GET['inventory_id'];
	// Perform database delete to remove the inventory item
	$sql = "DELETE FROM inventory WHERE inventory_id = $inventory_id";
	if(mysqli_query($conn, $sql)) {
		// Inventory item deleted successfully, redirect back to inventory management page
		header("Location: inventory_manage.php");
		exit();
	} else {
		// Error occurred while deleting inventory item
		$error = "Error: " . mysqli_error($conn);
	}
} else {
	// Redirect to inventory management page if inventory_id parameter is not provided
	header('Location: inventory_manage.php');
	exit();
}
?>