<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

$sql = "SELECT * FROM invoices";
$result = mysqli_query($conn, $sql);
$invoices = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .manage-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 50px auto;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .create-invoice-link {
            display: inline-block;
            padding: 8px 16px;
            margin-bottom: 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .create-invoice-link:hover {
            background-color: #218838;
        }

        td a {
            text-decoration: none;
            color: #fff;
            margin-right: 5px;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #007bff;
            transition: background-color 0.3s;
            display: inline-block;
        }

        td a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="manage-container">
        <h2>Invoice Management</h2>

        <table>
            <tr>
                <th>Invoice ID</th>
                <th>Customer ID</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Due Date</th>
                <th>Action</th>
            </tr>
            <?php foreach($invoices as $invoice): ?>
                <tr>
                    <td><?php echo $invoice['invoice_id']; ?></td>
                    <td><?php echo $invoice['customer_id']; ?></td>
                    <td><?php echo $invoice['date']; ?></td>
                    <td><?php echo $invoice['total_amount']; ?></td>
                    <td><?php echo $invoice['due_date']; ?></td>
                    <td>
                        <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manager'): ?>
                            <a href="edit_invoice.php?invoice_id=<?php echo $invoice['invoice_id']; ?>">Edit</a>
                        <?php endif; ?>
                        <?php if($_SESSION['role'] == 'admin'): ?>
                            <a href="delete_invoice.php?invoice_id=<?php echo $invoice['invoice_id']; ?>">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
						</br>
        
        <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manager'): ?>
            <a href="create_invoice.php" class="create-invoice-link">Create Invoice</a>
        <?php endif; ?>
    </div>
</body>
</html>