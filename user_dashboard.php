<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 50px auto;
        }

        .dashboard-container h1 {
            text-align: center;
            color: #333;
        }

        .dashboard-container p {
            text-align: center;
            color: #555;
        }

        .nav-menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .nav-item {
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(25% - 20px); /* 25% width for each item with margin */
            margin-bottom: 20px;
            cursor: pointer;
        }

        .nav-item a {
            text-decoration: none;
            color: #333;
        }

        .nav-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="dashboard-container">
        <h1>Welcome to User Dashboard</h1>

        <div class="nav-menu">
            <div class="nav-item"><a href="products_manage.php">View Products</a></div>
            <div class="nav-item"><a href="vouchers_manage.php">View Vouchers</a></div>
            <div class="nav-item"><a href="transactions_manage.php">View Transactions</a></div>
            <div class="nav-item"><a href="inventory_manage.php">View Inventory</a></div>
            <div class="nav-item"><a href="invoices_manage.php">View Invoices</a></div>
            <div class="nav-item"><a href="customers_manage.php">View Customers</a></div>
            <div class="nav-item"><a href="reports.php">Generate Reports</a></div>
        </div>
    </div>
</body>
</html>