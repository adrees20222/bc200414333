<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if customer_id parameter is provided in the URL
if(isset($_GET['customer_id'])) {
	$customer_id = $_GET['customer_id'];
	// Fetch customer details from the database
	$sql = "SELECT * FROM customers WHERE customer_id = $customer_id";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) == 1) {
		$customer = mysqli_fetch_assoc($result);
	} else {
		// Customer not found, redirect to customer management page
		header('Location: customers_manage.php');
		exit();
	}
} else {
	// Redirect to customer management page if customer_id parameter is not provided
	header('Location: customers_manage.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .edit-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 50px auto;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="submit"] {
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="edit-container">
        <h1>Edit Customer</h1>
        <!-- Edit customer form -->
        <form method="post" action="update_customer.php">
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" value="<?php echo $customer['customer_name']; ?>" required><br>
            <label for="contact_info">Contact Info:</label>
            <input type="text" id="contact_info" name="contact_info" value="<?php echo $customer['contact_info']; ?>" required><br>
            <input type="submit" value="Update Customer">
        </form>
    </div>
</body>
</html>