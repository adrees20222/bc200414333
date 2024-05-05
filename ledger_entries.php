<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';

$sql = "SELECT * FROM ledger";
$result = mysqli_query($conn, $sql);
$ledger_entries = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledger Entry Management</title>
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

        .create-ledger-entry-link {
            display: inline-block;
            padding: 8px 16px;
            margin-bottom: 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .create-ledger-entry-link:hover {
            background-color: #218838;
        }

        td a {
            text-decoration: none;
            color: #fff;
            margin-right: 5px;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #007bff;
            transition: background-color 0.3s;
            display: inline-block;
        }

        td a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="manage-container">
        <h1>Ledger Entry Management</h1>

        <table>
            <tr>
                <th>Ledger ID</th>
                <th>Account ID</th>
                <th>Transaction ID</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Action</th>
            </tr>
            <?php foreach($ledger_entries as $ledger_entry): ?>
                <tr>
                    <td><?php echo $ledger_entry['ledger_id']; ?></td>
                    <td><?php echo $ledger_entry['account_id']; ?></td>
                    <td><?php echo $ledger_entry['transaction_id']; ?></td>
                    <td><?php echo $ledger_entry['debit']; ?></td>
                    <td><?php echo $ledger_entry['credit']; ?></td>
                    <td>
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <a href="edit_ledger_entry.php?ledger_id=<?php echo $ledger_entry['ledger_id']; ?>">Edit</a>
                            <a href="delete_ledger_entry.php?ledger_id=<?php echo $ledger_entry['ledger_id']; ?>">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
				</br>
        <?php if(isset($_SESSION['user_id'])): ?>
        <a href="create_ledger_entry.php" class="create-ledger-entry-link">Create Ledger Entry</a>
        <?php endif; ?>
		
    </div>
</body>
</html>
