<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Ensure the user is authenticated and has the necessary role
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'manager')) {
    header("Location: login.php");
    exit();
}

// Handle form submission to create a new ledger entry
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$account_id = $_POST['account_id'];
	$transaction_id = $_POST['transaction_id'];
	$debit = $_POST['debit'];
	$credit = $_POST['credit'];

	// Perform database insert to create the new ledger entry
	$sql = "INSERT INTO ledger (account_id, transaction_id, debit, credit) VALUES ($account_id, $transaction_id, $debit, $credit)";
	if(mysqli_query($conn, $sql)) {
		// Ledger entry created successfully, redirect back to ledger entry management page
		header("Location: ledger_entries.php");
		exit();
	} else {
		// Error occurred while creating ledger entry
		$error = "Error: " . mysqli_error($conn);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ledger Entry</title>
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
        <h1>Create Ledger Entry</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="account_id">Account ID:</label>
            <input type="number" id="account_id" name="account_id" required><br>
            <label for="transaction_id">Transaction ID:</label>
            <input type="number" id="transaction_id" name="transaction_id" required><br>
            <label for="debit">Debit:</label>
            <input type="number" id="debit" name="debit" required><br>
            <label for="credit">Credit:</label>
            <input type="number" id="credit" name="credit" required><br>
            <input type="submit" value="Create Ledger Entry">
        </form>
    </div>
</body>
</html>