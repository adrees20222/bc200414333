<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Handle form submission to update an existing inventory item
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$inventory_id = $_POST['inventory_id'];
	$product_id = $_POST['product_id'];
	$warehouse_id = $_POST['warehouse_id'];
	$quantity = $_POST['quantity'];
	$date = $_POST['date'];

	// Perform database update to update the inventory item
	$sql = "UPDATE inventory SET product_id = $product_id, warehouse_id = $warehouse_id, quantity = $quantity, date = '$date' WHERE inventory_id = $inventory_id";
	if(mysqli_query($conn, $sql)) {
		// Inventory item updated successfully, redirect back to inventory management page
		header("Location: inventory_manage.php");
		exit();
	} else {
		// Error occurred while updating inventory item
		$error = "Error: " . mysqli_error($conn);
	}
}
?>