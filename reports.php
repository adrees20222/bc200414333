<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_config.php';

// Initialize variables
$error = '';
$report_data = [];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to generate reports
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_type = $_POST['report_type'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    try {
        // Generate report based on selected type
        switch ($report_type) {
            case 'item-wise':
                // Query to retrieve item-wise report
                $sql = "SELECT items.item_name, COALESCE(SUM(inventory.quantity), 0) AS total_in, COALESCE(SUM(transactions.quantity), 0) AS total_out 
                        FROM items 
                        LEFT JOIN inventory ON items.item_id = inventory.product_id AND inventory.date BETWEEN ? AND ?
                        LEFT JOIN transactions ON items.item_id = transactions.product_id AND transactions.transaction_date BETWEEN ? AND ?
                        GROUP BY items.item_name";
                break;
            case 'day-wise':
                // Query to retrieve day-wise report
                $sql = "SELECT DATE_FORMAT(date, '%Y-%m-%d') AS date, COALESCE(SUM(inventory.quantity), 0) AS total_in, COALESCE(SUM(transactions.quantity), 0) AS total_out 
                        FROM (
                            SELECT date FROM inventory WHERE date BETWEEN ? AND ?
                            UNION
                            SELECT transaction_date FROM transactions WHERE transaction_date BETWEEN ? AND ?
                        ) AS dates
                        LEFT JOIN inventory ON dates.date = inventory.date
                        LEFT JOIN transactions ON dates.date = transactions.transaction_date
                        GROUP BY dates.date";
                break;
            case 'week-wise':
                // Query to retrieve week-wise report
                $sql = "SELECT WEEK(date) AS week, COALESCE(SUM(inventory.quantity), 0) AS total_in, COALESCE(SUM(transactions.quantity), 0) AS total_out 
                        FROM (
                            SELECT date FROM inventory WHERE date BETWEEN ? AND ?
                            UNION
                            SELECT transaction_date FROM transactions WHERE transaction_date BETWEEN ? AND ?
                        ) AS dates
                        LEFT JOIN inventory ON WEEK(dates.date) = WEEK(inventory.date)
                        LEFT JOIN transactions ON WEEK(dates.date) = WEEK(transactions.transaction_date)
                        GROUP BY WEEK(dates.date)";
                break;
            case 'month-wise':
                // Query to retrieve month-wise report
                $sql = "SELECT MONTH(date) AS month, COALESCE(SUM(inventory.quantity), 0) AS total_in, COALESCE(SUM(transactions.quantity), 0) AS total_out 
                        FROM (
                            SELECT date FROM inventory WHERE date BETWEEN ? AND ?
                            UNION
                            SELECT transaction_date FROM transactions WHERE transaction_date BETWEEN ? AND ?
                        ) AS dates
                        LEFT JOIN inventory ON MONTH(dates.date) = MONTH(inventory.date)
                        LEFT JOIN transactions ON MONTH(dates.date) = MONTH(transactions.transaction_date)
                        GROUP BY MONTH(dates.date)";
                break;
            case 'brand-wise':
                // Query to retrieve brand-wise report
                $sql = "SELECT brands.brand_name, COALESCE(SUM(inventory.quantity), 0) AS total_in, COALESCE(SUM(transactions.quantity), 0) AS total_out 
                        FROM items 
                        LEFT JOIN brands ON items.brand_id = brands.brand_id 
                        LEFT JOIN inventory ON items.item_id = inventory.product_id AND inventory.date BETWEEN ? AND ?
                        LEFT JOIN transactions ON items.item_id = transactions.product_id AND transactions.transaction_date BETWEEN ? AND ?
                        GROUP BY brands.brand_name";
                break;
            case 'inventory-reports':
                // Query to retrieve inventory reports
                // Modify this query according to your inventory report requirements
                $sql = "SELECT * FROM inventory_reports";
                break;
            case 'stock-aging':
                // Query to retrieve stock aging report
                // Modify this query according to your stock aging report requirements
                $sql = "SELECT * FROM stock_aging";
                break;
            case 'stock-value':
                // Query to retrieve stock value report
                // Modify this query according to your stock value report requirements
                $sql = "SELECT * FROM stock_value";
                break;
            case 'stock-movement':
                // Query to retrieve stock movement report
                // Modify this query according to your stock movement report requirements
                $sql = "SELECT * FROM stock_movement";
                break;
            default:
                $error = "Please select a valid report type";
                break;
        }

        // Prepare and execute the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $from_date, $to_date, $from_date, $to_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            // Fetch the report data
            $report_data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Error occurred while generating report
            $error = "Error generating report: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } catch (Exception $e) {
        $error = "Error generating report: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <style>
        /* CSS styles remain unchanged */
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="report-container">
    <h1>Generate Reports</h1>
    <!-- Add form to select report type and date range -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="report_type">Report Type:</label>
        <select id="report_type" name="report_type" required>
            <option value="item-wise">Item-wise</option>
            <option value="day-wise">Day-wise</option>
            <option value="week-wise">Week-wise</option>
            <option value="month-wise">Month-wise</option>
            <option value="brand-wise">Brand-wise</option>
            <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manager'): ?>
            <!-- Additional report options for admins and managers -->
            <option value="inventory-reports">Inventory Reports</option>
            <option value="stock-aging">Stock Aging</option>
            <option value="stock-value">Stock Value</option>
            <option value="stock-movement">Stock Movement</option>
            <?php endif; ?>
        </select><br>
        <label for="from_date">From Date:</label>
        <input type="date" id="from_date" name="from_date" required><br>
        <label for="to_date">To Date:</label>
        <input type="date" id="to_date" name="to_date" required><br>
        <input type="submit" value="Generate Report">
    </form>

    <!-- Display error message if any -->
    <?php if (!empty($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Display report data -->
    <?php if (!empty($report_data)): ?>
        <h2>Report</h2>
        <table>
            <thead>
            <tr>
                <!-- Display column headers -->
                <?php foreach ($report_data[0] as $key => $value): ?>
                    <th><?php echo ucfirst(str_replace('_', ' ', $key)); ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <!-- Display report rows -->
            <?php foreach ($report_data as $row): ?>
                <tr>
                    <?php foreach ($row as $value): ?>
                        <td><?php echo $value; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>