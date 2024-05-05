<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $city = $_POST['city'];
    $address = $_POST['address'];
    $capacity = $_POST['capacity'];

    $sql = "INSERT INTO warehouses (city, address, capacity) VALUES ('$city', '$address', '$capacity')";
    if(mysqli_query($conn, $sql)) {
        header("Location: warehouses_manage.php");
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .add-container {
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
        }

        label {
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"] {
            padding: 8px;
            margin-bottom: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
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

        .error {
            color: #ff0000;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="add-container">
        <h1>Add Warehouse</h1>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" required>
            <input type="submit" value="Add Warehouse">
        </form>

        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>