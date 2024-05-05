<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if voucher_id parameter is provided in the URL
if(isset($_GET['voucher_id'])) {
	$voucher_id = $_GET['voucher_id'];
	// Fetch voucher details from the database
	$sql = "SELECT * FROM vouchers WHERE voucher_id = $voucher_id";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) == 1) {
		$voucher = mysqli_fetch_assoc($result);
	} else {
		// Voucher not found, redirect to voucher management page
		header('Location: vouchers_manage.php');
		exit();
	}
} else {
	// Redirect to voucher management page if voucher_id parameter is not provided
	header('Location: vouchers_manage.php');
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Voucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="number"],
        input[type="text"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
	<h1>Edit Voucher</h1>
	<!-- Edit voucher form -->
	<form method="post" action="update_voucher.php">
		<input type="hidden" name="voucher_id" value="<?php echo $voucher_id; ?>">
		<label for="user_id">User ID:</label>
		<input type="number" id="user_id" name="user_id" value="<?php echo $voucher['user_id']; ?>" required><br>
		<label for="voucher_type">Voucher Type:</label>
		<input type="text" id="voucher_type" name="voucher_type" value="<?php echo $voucher['voucher_type']; ?>" required><br>
		<label for="voucher_status">Voucher Status:</label>
		<select id="voucher_status" name="voucher_status">
			<option value="pending" <?php if($voucher['voucher_status'] == 'pending') echo 'selected'; ?>>Pending</option>
			<option value="approved" <?php if($voucher['voucher_status'] == 'approved') echo 'selected'; ?>>Approved</option>
			<option value="rejected" <?php if($voucher['voucher_status'] == 'rejected') echo 'selected'; ?>>Rejected</option>
		</select><br>
		<input type="submit" value="Update Voucher">
	</form>
</body>
</html>