<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if invoice_id parameter is provided in the URL
if(isset($_GET['invoice_id'])) {
    $invoice_id = $_GET['invoice_id'];
    // Fetch invoice details from the database
    $sql = "SELECT * FROM invoices WHERE invoice_id = $invoice_id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1) {
        $invoice = mysqli_fetch_assoc($result);
    } else {
        // Invoice not found, redirect to invoice management page
        header('Location: invoices_manage.php');
        exit();
    }
} else {
    // Redirect to invoice management page if invoice_id parameter is not provided
    header('Location: invoices_manage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>
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

        input[type="number"],
        input[type="date"],
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
        <h1>Edit Invoice</h1>
        <!-- Edit invoice form -->
        <form method="post" action="update_invoice.php">
            <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>">
            <label for="customer_id">Customer ID:</label>
            <input type="number" id="customer_id" name="customer_id" value="<?php echo $invoice['customer_id']; ?>" required><br>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $invoice['date']; ?>" required><br>
            <label for="total_amount">Total Amount:</label>
            <input type="number" id="total_amount" name="total_amount" value="<?php echo $invoice['total_amount']; ?>" required><br>
            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date" value="<?php echo $invoice['due_date']; ?>" required><br>
            <input type="submit" value="Update Invoice">
        </form>
    </div>
</body>
</html>