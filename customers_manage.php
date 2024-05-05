<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

$sql = "SELECT * FROM customers";
$result = mysqli_query($conn, $sql);
$customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
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

        h1 {
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

        .create-customer-link {
            display: inline-block;
            padding: 8px 16px;
            margin-bottom: 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .create-customer-link:hover {
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
        <h1>Customer Management</h1>

        <table>
            <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Contact Info</th>
                <th>Action</th>
            </tr>
            <?php foreach($customers as $customer): ?>
                <tr>
                    <td><?php echo $customer['customer_id']; ?></td>
                    <td><?php echo $customer['customer_name']; ?></td>
                    <td><?php echo $customer['contact_info']; ?></td>
                    <td>
                        <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manager'): ?>
                            <a href="edit_customer.php?customer_id=<?php echo $customer['customer_id']; ?>">Edit</a>
                        <?php endif; ?>
                        <?php if($_SESSION['role'] == 'admin'): ?>
                            <a href="delete_customer.php?customer_id=<?php echo $customer['customer_id']; ?>">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
				</br>
				
        <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manager'): ?>
            <a href="create_customer.php" class="create-customer-link">Create Customer</a>
        <?php endif; ?>
    </div>
</body>
</html>