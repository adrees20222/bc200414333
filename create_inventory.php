<?php
session_start();
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'manager')) {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $warehouse_id = $_POST['warehouse_id'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];

    $sql = "INSERT INTO inventory (product_id, warehouse_id, quantity, date) VALUES ($product_id, $warehouse_id, $quantity, '$date')";
    if(mysqli_query($conn, $sql)) {
        header("Location: inventory_manage.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Inventory Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .create-container {
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
    <div class="create-container">
        <h1>Create Inventory Item</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="product_id">Product ID:</label>
            <input type="number" id="product_id" name="product_id" required><br>
            <label for="warehouse_id">Warehouse ID:</label>
            <input type="number" id="warehouse_id" name="warehouse_id" required><br>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required><br>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br>
            <input type="submit" value="Create Inventory Item">
        </form>
    </div>
</body>
</html>