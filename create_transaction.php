<?php
session_start();
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'manager')) {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $voucher_id = $_POST['voucher_id'];
    $transaction_type = $_POST['transaction_type'];
    $quantity = $_POST['quantity'];
    $transaction_date = $_POST['transaction_date'];

    $sql = "INSERT INTO transactions (product_id, voucher_id, transaction_type, quantity, transaction_date) VALUES ($product_id, $voucher_id, '$transaction_type', $quantity, '$transaction_date')";
    if(mysqli_query($conn, $sql)) {
        header("Location: transactions_manage.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Transaction</title>
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
    <?php include 'header.php'; ?>
    
    <div class="form-container">
        <h1>Create Transaction</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="product_id">Product ID:</label>
            <input type="number" id="product_id" name="product_id" required><br>
            <label for="voucher_id">Voucher ID:</label>
            <input type="number" id="voucher_id" name="voucher_id"><br>
            <label for="transaction_type">Transaction Type:</label>
            <select id="transaction_type" name="transaction_type">
                <option value="incoming">Incoming</option>
                <option value="outgoing">Outgoing</option>
            </select><br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required><br>
            <label for="transaction_date">Transaction Date:</label>
            <input type="date" id="transaction_date" name="transaction_date" required><br>
            <input type="submit" value="Create Transaction">
        </form>
    </div>
</body>
</html>