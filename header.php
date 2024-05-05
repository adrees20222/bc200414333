<!DOCTYPE html>
<html>
<head>
    <title>Warehouse Management System</title>
    <style>
        header {
            background-color: #0074D9;
            color: #333;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 10;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li:last-child {
            margin-right: 0;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border: 1px solid #fff;
            border-radius: 4px;
        }

        nav ul li a:hover {
            background-color: #f0f0f0;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Include navigation bar, logo, etc. -->
    <header>
        <h1>Warehouse Management System</h1>
        <nav>
            <ul>
                <!-- Include other navigation links based on user role -->
                <?php if($_SESSION['role'] == 'admin'): ?>
                    <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
                <?php elseif($_SESSION['role'] == 'manager'): ?>
                    <li><a href="manager_dashboard.php">Manager Dashboard</a></li>
                <?php elseif($_SESSION['role'] == 'user'): ?>
                    <li><a href="user_dashboard.php">User Dashboard</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>