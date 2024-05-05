<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if transaction_id parameter is provided in the URL
if(isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];
    // Fetch transaction details from the database
    $sql = "SELECT * FROM transactions WHERE transaction_id = $transaction_id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1) {
        $transaction = mysqli_fetch_assoc($result);
    } else {
        // Transaction not found, redirect to transaction management page
        header('Location: transactions_manage.php');
        exit();
    }
} else {
    // Redirect to transaction management page if transaction_id parameter is not provided
    header('Location: transactions_manage.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
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

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Include header.php -->
    <?php include 'header.php'; ?>
    
    <div class="form-container">
        <h1>Edit Transaction</h1>
        <!-- Edit transaction form -->
        <form method="post" action="update_transaction.php">
            <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
            <label for="product_id">Product ID:</label>
            <input type="number" id="product_id" name="product_id" value="<?php echo $transaction['product_id']; ?>" required><br>
            <label for="voucher_id">Voucher ID:</label>
            <input type="number" id="voucher_id" name="voucher_id" value="<?php echo $transaction['voucher_id']; ?>"><br>
            <label for="transaction_type">Transaction Type:</label>
            <select id="transaction_type" name="transaction_type">
                <option value="incoming" <?php if($transaction['transaction_type'] == 'incoming') echo 'selected'; ?>>Incoming</option>
                <option value="outgoing" <?php if($transaction['transaction_type'] == 'outgoing') echo 'selected'; ?>>Outgoing</option>
            </select><br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $transaction['quantity']; ?>" required><br>
            <label for="transaction_date">Transaction Date:</label>
            <input type="date" id="transaction_date" name="transaction_date" value="<?php echo $transaction['transaction_date']; ?>" required><br>
            <input type="submit" value="Update Transaction">
        </form>
    </div>
</body>
</html>