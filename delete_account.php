<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_config.php';

// Check if account ID is provided
if(isset($_GET['id'])) {
    $account_id = $_GET['id'];

    // Check if there are any subaccounts associated with this account
    $sql = "SELECT * FROM chart_of_accounts WHERE parent_account_id = $account_id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        // Delete subaccounts first
        $sql = "DELETE FROM chart_of_accounts WHERE parent_account_id = $account_id";
        mysqli_query($conn, $sql);
    }

    // Delete account from the database
    $sql = "DELETE FROM chart_of_accounts WHERE account_id = $account_id";
    if(mysqli_query($conn, $sql)) {
        // Account deleted successfully, redirect to chart_of_accounts.php
        header("Location: chart_of_accounts.php");
        exit();
    } else {
        // Error occurred while deleting account
        $error = "Error deleting record: " . mysqli_error($conn);
    }
}
?>