<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Handle form submission to add a new account
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_name = $_POST['account_name'];
    $account_type = $_POST['account_type'];
    $parent_account_id = $_POST['parent_account_id'];

    // Check if parent_account_id exists in chart_of_accounts table
    $parent_account_check_sql = "SELECT * FROM chart_of_accounts WHERE account_id = $parent_account_id";
    $parent_account_check_result = mysqli_query($conn, $parent_account_check_sql);
    if(mysqli_num_rows($parent_account_check_result) > 0) {
        // Parent account exists, proceed with inserting into chart_of_accounts table
        $sql = "INSERT INTO chart_of_accounts (account_name, account_type, parent_account_id) VALUES ('$account_name', '$account_type', $parent_account_id)";
    } else {
        // Parent account does not exist, insert null into parent_account_id field
        $sql = "INSERT INTO chart_of_accounts (account_name, account_type, parent_account_id) VALUES ('$account_name', '$account_type', NULL)";
    }
    if(mysqli_query($conn, $sql)) {
        // Account added successfully, redirect back to account management page
        header("Location: chart_of_accounts.php");
        exit();
    } else {
        // Error occurred while adding account
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

        .add-account-container {
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
    
    <div class="add-account-container">
        <h1>Add Account</h1>
        
        <!-- Add form to add a new account -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="account_name">Account Name:</label>
            <input type="text" id="account_name" name="account_name" required><br>
            <label for="account_type">Account Type:</label>
            <select id="account_type" name="account_type" required>
                <option value="parent">Parent</option>
                <option value="control">Control</option>
                <option value="ledger">Ledger</option>
            </select><br>
            <label for="parent_account_id">Parent Account ID:</label>
            <input type="number" id="parent_account_id" name="parent_account_id"><br>
            <input type="submit" value="Add Account">
        </form>

        <!-- Display error message if any -->
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>

</body>
</html>