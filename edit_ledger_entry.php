<?php
session_start();
// Include database connection
require_once 'db_config.php';

// Check if ledger_id parameter is provided in the URL
if(isset($_GET['ledger_id'])) {
	$ledger_id = $_GET['ledger_id'];
	// Fetch ledger entry details from the database
	$sql = "SELECT * FROM ledger WHERE ledger_id = $ledger_id";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) == 1) {
		$ledger_entry = mysqli_fetch_assoc($result);
	} else {
		// Ledger entry not found, redirect to ledger entry management page
		header('Location: ledger_entries.php');
		exit();
	}
} else {
	// Redirect to ledger entry management page if ledger_id parameter is not provided
	header('Location: ledger_entries.php');
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ledger Entry</title>
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
        input[type="submit"] {
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
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
    <div class="edit-container">
        <h1>Edit Ledger Entry</h1>
        <form method="post" action="update_ledger_entry.php">
            <input type="hidden" name="ledger_id" value="<?php echo $ledger_id; ?>">
            <label for="account_id">Account ID:</label>
            <input type="number" id="account_id" name="account_id" value="<?php echo $ledger_entry['account_id']; ?>" required><br>
            <label for="transaction_id">Transaction ID:</label>
            <input type="number" id="transaction_id" name="transaction_id" value="<?php echo $ledger_entry['transaction_id']; ?>" required><br>
            <label for="debit">Debit:</label>
            <input type="number" id="debit" name="debit" value="<?php echo $ledger_entry['debit']; ?>" required><br>
            <label for="credit">Credit:</label>
            <input type="number" id="credit" name="credit" value="<?php echo $ledger_entry['credit']; ?>" required><br>
            <input type="submit" value="Update Ledger Entry">
        </form>
    </div>
</body>
</html>
