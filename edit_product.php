<?php
session_start();
// Check if user is logged in and has appropriate role
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'manager')) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_config.php';

// Handle form submission to edit an existing product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $unit_price = mysqli_real_escape_string($conn, $_POST['unit_price']);
    $purchase_date = mysqli_real_escape_string($conn, $_POST['purchase_date']);
    $warehouse_id = $_POST['warehouse_id'];

    // Perform database update to edit the product
    $sql = "UPDATE products SET 
            name = '$name', 
            quantity = '$quantity', 
            brand = '$brand', 
            category = '$category', 
            unit_price = '$unit_price', 
            purchase_date = '$purchase_date', 
            warehouse_id = '$warehouse_id' 
            WHERE product_id = '$product_id'";

    if (mysqli_query($conn, $sql)) {
        // Product updated successfully, redirect back to product management page
        header("Location: products_manage.php");
        exit();
    } else {
        // Error occurred while updating product
        $error = "Error: " . mysqli_error($conn);
    }
} else {
    // If the request is not POST, fetch the product details from the database
    if (isset($_GET['product_id']) && !empty(trim($_GET['product_id']))) {
        $product_id = trim($_GET['product_id']);
        // Fetch product details from the database
        $sql = "SELECT * FROM products WHERE product_id = '$product_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];
            $quantity = $row['quantity'];
            $brand = $row['brand'];
            $category = $row['category'];
            $unit_price = $row['unit_price'];
            $purchase_date = $row['purchase_date'];
            $warehouse_id = $row['warehouse_id'];
        } else {
            // Product not found, redirect to product management page
            header('Location: products_manage.php');
            exit();
        }
    } else {
        // No product ID specified, redirect to product management page
        header('Location: products_manage.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
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
    <!-- Include header.php -->
    <?php include 'header.php'; ?>
    
    <h2>Edit Product</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Form fields for editing product details -->
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required><br>
        <label for="brand">Brand:</label>
        <input type="text" id="brand" name="brand" value="<?php echo $brand; ?>"><br>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $category; ?>"><br>
        <label for="unit_price">Unit Price:</label>
        <input type="number" id="unit_price" name="unit_price" value="<?php echo $unit_price; ?>" required><br>
        <label for="purchase_date">Purchase Date:</label>
        <input type="date" id="purchase_date" name="purchase_date" value="<?php echo $purchase_date; ?>" required><br>
        <label for="warehouse_id">Warehouse ID:</label>
        <select id="warehouse_id" name="warehouse_id">
            <?php
            $sql = "SELECT * FROM warehouses";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['warehouse_id'] . "'";
                if ($row['warehouse_id'] == $warehouse_id) {
                    echo " selected";
                }
                echo ">" . $row['name'] . "</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Update Product">
    </form>
</body>
</html>