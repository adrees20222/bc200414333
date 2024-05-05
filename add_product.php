<?php
session_start();
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'manager')) {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $quantity = $_POST['quantity'];
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $unit_price = $_POST['unit_price'];
    $purchase_date = $_POST['purchase_date'];
    $warehouse_id = $_POST['warehouse_id'];

    $sql = "INSERT INTO products (name, quantity, brand, category, unit_price, purchase_date, warehouse_id) VALUES ('$name', $quantity, '$brand', '$category', $unit_price, '$purchase_date', $warehouse_id)";
    if(mysqli_query($conn, $sql)) {
        header("Location: products_manage.php");
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
    <title>Add Product</title>
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
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
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
    
    <h1>Add Product</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br>
        <label for="brand">Brand:</label>
        <input type="text" id="brand" name="brand"><br>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category"><br>
        <label for="unit_price">Unit Price:</label>
        <input type="number" id="unit_price" name="unit_price" step="0.01" required><br>
        <label for="purchase_date">Purchase Date:</label>
        <input type="date" id="purchase_date" name="purchase_date" required><br>
        <label for="warehouse_id">Warehouse ID:</label>
        <select id="warehouse_id" name="warehouse_id">
            <?php
            $sql = "SELECT * FROM warehouses";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['warehouse_id'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Add Product">
    </form>
</body>
</html>