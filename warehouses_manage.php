<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

// Fetch list of warehouses
$sql = "SELECT * FROM warehouses";
$result = mysqli_query($conn, $sql);
$warehouses = mysqli_fetch_all($result, MYSQLI_ASSOC);
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

        td a {
            text-decoration: none;
            color: #fff;
            margin-right: 5px;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #007bff;
            transition: background-color 0.3s;
        }

        td a:hover {
            background-color: #0056b3;
        }

        a.add-warehouse-link {
            display: inline-block;
            padding: 8px 16px;
            margin-top: 10px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        a.add-warehouse-link:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="manage-container">
        <h1>Manage Warehouses</h1>
        
        <table>
            <tr>
                <th>Warehouse ID</th>
                <th>City</th>
                <th>Address</th>
                <th>Capacity</th>
                <th>Action</th>
            </tr>
            <?php foreach($warehouses as $warehouse): ?>
                <tr>
                    <td><?php echo $warehouse['warehouse_id']; ?></td>
                    <td><?php echo $warehouse['city']; ?></td>
                    <td><?php echo $warehouse['address']; ?></td>
                    <td><?php echo $warehouse['capacity']; ?></td>
                    <td>
                        <a href="edit_warehouse.php?id=<?php echo $warehouse['warehouse_id']; ?>">Edit</a>
                        <a href="delete_warehouse.php?id=<?php echo $warehouse['warehouse_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <a href="add_warehouse.php" class="add-warehouse-link">Add Warehouse</a>
    </div>
</body>
</html>