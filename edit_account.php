<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_config.php';

// Fetch account details based on account ID
if(isset($_GET['id'])) {
    $account_id = $_GET['id'];
    $sql = "SELECT * FROM chart_of_accounts WHERE account_id = $account_id";
    $result = mysqli_query($conn, $sql);
    $account = mysqli_fetch_assoc($result);
}

// Initialize variables
$error = '';

// Handle form submission to edit account details
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_id = $_POST['account_id'];
    $account_name = mysqli_real_escape_string($conn, $_POST['account_name']);
    $account_type = mysqli_real_escape_string($conn, $_POST['account_type']);
    $parent_account_id = mysqli_real_escape_string($conn, $_POST['parent_account_id']);

    // Update account details in the database
    $sql = "UPDATE chart_of_accounts SET account_name = '$account_name', account_type = '$account_type', parent_account_id = '$parent_account_id' WHERE account_id = $account_id";
    if(mysqli_query($conn, $sql)) {
        // Account details updated successfully, redirect to chart_of_accounts.php
        header("Location: chart_of_accounts.php");
        exit();
    } else {
        // Error occurred while updating account details
        $error = "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account - Warehouse Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .edit-account-container {
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
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="edit-account-container">
        <h1>Edit Account</h1>
        
        <!-- Add form to edit account details -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="account_id" value="<?php echo $account['account_id']; ?>">
            <label for="account_name">Account Name:</label>
            <input type="text" id="account_name" name="account_name" value="<?php echo $account['account_name']; ?>" required><br>
            <label for="account_type">Account Type:</label>
            <select id="account_type" name="account_type" required>
                <option value="parent" <?php if($account['account_type'] == 'parent') echo 'selected'; ?>>Parent</option>
                <option value="control" <?php if($account['account_type'] == 'control') echo 'selected'; ?>>Control</option>
                <option value="ledger" <?php if($account['account_type'] == 'ledger') echo 'selected'; ?>>Ledger</option>
            </select><br>
            <label for="parent_account_id">Parent Account ID:</label>
            <input type="number" id="parent_account_id" name="parent_account_id" value="<?php echo $account['parent_account_id']; ?>"><br>
            <input type="submit" value="Save Changes">
        </form>

        <!-- Display error message if any -->
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
