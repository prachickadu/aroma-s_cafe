<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'phpdb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total cash flow
$cash_flow_query = "SELECT SUM(total_price) AS total_cash_flow FROM orders";
$cash_flow_result = $conn->query($cash_flow_query);

$total_cash_flow = 0; // Default value if no orders are found
if ($cash_flow_result->num_rows > 0) {
    $cash_flow_row = $cash_flow_result->fetch_assoc();
    $total_cash_flow = $cash_flow_row['total_cash_flow'];
}

// Fetch today's revenue
$today = date('Y-m-d');
$today_query = "SELECT SUM(total_price) AS today_revenue FROM orders WHERE DATE(order_date) = '$today'";
$today_result = $conn->query($today_query);
$today_revenue = $today_result->fetch_assoc()['today_revenue'] ?? 0;

// Fetch recent transactions
$recent_query = "SELECT * FROM orders ORDER BY order_date DESC LIMIT 10";
$recent_result = $conn->query($recent_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Flow - Aroma's Cafe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0e382c;
            --secondary-color: #eebf63;
            --accent-color: #eebf63;
            --background-color: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--background-color);
            color: var(--primary-color);
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: var(--primary-color);
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: var(--card-shadow);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .logo img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid var(--accent-color);
            background: white;
            padding: 3px;
        }

        .sidebar .logo h2 {
            margin: 10px 0;
            font-size: 1.5rem;
            color: white;
        }

        .sidebar nav {
            padding: 20px 0;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar nav a:hover, .sidebar nav a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid var(--accent-color);
        }

        .sidebar nav a i {
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .navbar {
            background: white;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: var(--background-color);
            border-radius: 25px;
            padding: 8px 20px;
            width: 300px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            padding: 5px 10px;
            width: 100%;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--secondary-color);
            cursor: pointer;
            transition: transform 0.2s ease;
            padding: 2px;
        }

        .profile img:hover {
            transform: scale(1.1);
        }

        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 
                0 10px 25px rgba(14, 56, 44, 0.1),
                0 5px 10px rgba(14, 56, 44, 0.05);
            padding: 8px;
            min-width: 200px;
            margin-top: 10px;
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            animation: dropdownFade 0.2s ease;
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            font-size: 14px;
            font-family: 'Segoe UI', Arial, sans-serif;
            padding: 12px 20px;
            border-radius: 8px;
            color: var(--primary-color);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item i {
            color: var(--secondary-color);
            font-size: 16px;
            width: 20px;
        }

        .dropdown-item:hover {
            background: linear-gradient(90deg, 
                rgba(238, 191, 99, 0.1),
                rgba(14, 56, 44, 0.05)
            );
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .dropdown-divider {
            margin: 8px 0;
            border-color: rgba(14, 56, 44, 0.1);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--secondary-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .stat-card .icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        .stat-card .amount {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin: 10px 0;
        }

        .stat-card .label {
            color: #666;
            font-size: 1.1rem;
        }

        .transactions {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
        }

        .transactions h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .transactions h2::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-color);
        }

        .transaction-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .transaction-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .transaction-item:hover {
            background: rgba(238, 191, 99, 0.1);
            padding-left: 20px;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-info {
            flex: 1;
        }

        .transaction-info .order-id {
            font-weight: 600;
            color: var(--primary-color);
        }

        .transaction-info .date {
            font-size: 0.9rem;
            color: #666;
        }

        .transaction-amount {
            font-weight: 600;
            color: var(--secondary-color);
            font-size: 1.1rem;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }
            .sidebar .logo h2, .sidebar nav a span {
                display: none;
            }
            .main-content {
                margin-left: 70px;
            }
            .search-box {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            .navbar {
                flex-direction: column;
                gap: 15px;
            }
            .search-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="./images/logo2.jpg" alt="logo">
            <h2>Aroma's Cafe</h2>
        </div>
        <nav>
            <a href="admin_dashboard.php">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="manage_users.php">
                <i class="fa-solid fa-people-roof"></i>
                <span>Manage Users</span>
            </a>
            <a href="#">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Track Orders</span>
            </a>
            <a href="manage_menu.php">
                <i class="fa-solid fa-list-check"></i>
                <span>Manage Menu</span>
            </a>
            <a href="cash_flow.php" class="active">
                <i class="fa-solid fa-landmark"></i>
                <span>Cash Flow</span>
            </a>
            <a href="#">
                <i class="fa-solid fa-comments"></i>
                <span>Feedback</span>
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="navbar">
            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="Search transactions...">
            </div>
            <div class="profile dropdown">
                <span>Welcome, Admin</span>
                <img src="./images/logo2.jpg" alt="profile" class="dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog"></i>
                            Settings
                        </a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li>
                        <a class="dropdown-item" href="../logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="icon">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div class="amount">₹<?php echo number_format($total_cash_flow, 2); ?></div>
                <div class="label">Total Revenue</div>
            </div>
            <div class="stat-card">
                <div class="icon">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <div class="amount">₹<?php echo number_format($today_revenue, 2); ?></div>
                <div class="label">Today's Revenue</div>
            </div>
            <div class="stat-card">
                <div class="icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div class="amount"><?php 
                    $total_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
                    echo number_format($total_orders);
                ?></div>
                <div class="label">Total Orders</div>
            </div>
        </div>

        <div class="transactions">
            <h2>Recent Transactions</h2>
            <ul class="transaction-list">
                <?php while ($transaction = $recent_result->fetch_assoc()): ?>
                <li class="transaction-item">
                    <div class="transaction-info">
                        <div class="order-id">Order #<?php echo $transaction['id']; ?></div>
                        <div class="date"><?php echo date('M d, Y H:i', strtotime($transaction['order_date'])); ?></div>
                    </div>
                    <div class="transaction-amount">₹<?php echo number_format($transaction['total_price'], 2); ?></div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>