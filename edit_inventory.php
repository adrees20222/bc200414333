<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if inventory_id parameter is provided in the URL
if(isset($_GET['inventory_id'])) {
    $inventory_id = $_GET['inventory_id'];
    // Fetch inventory item details from the database
    $sql = "SELECT * FROM inventory WHERE inventory_id = $inventory_id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1) {
        $inventory = mysqli_fetch_assoc($result);
    } else {
        // Inventory item not found, redirect to inventory management page
        header('Location: inventory_manage.php');
        exit();
    }
} else {
    // Redirect to inventory management page if inventory_id parameter is not provided
    header('Location: inventory_manage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Inventory Item</title>
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
        <h1>Edit Inventory Item</h1>
        <!-- Edit inventory form -->
        <form method="post" action="update_inventory.php">
            <input type="hidden" name="inventory_id" value="<?php echo $inventory_id; ?>">
            <label for="product_id">Product ID:</label>
            <input type="number" id="product_id" name="product_id" value="<?php echo $inventory['product_id']; ?>"
            required><br>
            <label for="warehouse_id">Warehouse ID:</label>
            <input type="number" id="warehouse_id" name="warehouse_id" value="<?php echo $inventory['warehouse_id']; ?>" required><br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $inventory['quantity']; ?>" required><br>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $inventory['date']; ?>" required><br>
            <input type="submit" value="Update Inventory Item">
        </form>
    </div>
</body>
</html>