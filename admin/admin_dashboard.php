<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'phpdb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count total users
$sql = "SELECT COUNT(*) AS total_users FROM coffee_shop";
$result = $conn->query($sql);

// Fetch the total users count
$total_users = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_users = $row['total_users'];
}

// Fetch the most recent user
$last_user_query = "SELECT name FROM coffee_shop ORDER BY id DESC LIMIT 1";
$last_user_result = $conn->query($last_user_query);

$last_user_name = "No recent user"; // Default value if no user is found
if ($last_user_result->num_rows > 0) {
    $last_user_row = $last_user_result->fetch_assoc();
    $last_user_name = $last_user_row['name'];
}

// Fetch today's orders and revenue
$today_date = date('Y-m-d'); // Get today's date
$orders_query = "SELECT COUNT(*) AS total_orders, SUM(total_price) AS total_revenue FROM orders WHERE DATE(order_date) = '$today_date'";
$orders_result = $conn->query($orders_query);

$total_orders = 0;
$total_revenue = 0;
if ($orders_result->num_rows > 0) {
    $orders_row = $orders_result->fetch_assoc();
    $total_orders = $orders_row['total_orders'];
    $total_revenue = $orders_row['total_revenue'];
}

// Fetch all users
$user_query = "SELECT * FROM coffee_shop";
$user_result = $conn->query($user_query);

// Add user functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $add_user_query = "INSERT INTO coffee_shop (name, email, password) VALUES ('$name', '$email', '$password')";
    $conn->query($add_user_query);
    header("Location: admin_dashboard.php");
}

// Delete user functionality
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $delete_user_query = "DELETE FROM coffee_shop WHERE id = $user_id";
    $conn->query($delete_user_query);
    header("Location: admin_dashboard.php");
}

// Fetch the most recent order
$last_order_query = "SELECT id, order_date, total_price FROM orders ORDER BY id DESC LIMIT 1";
$last_order_result = $conn->query($last_order_query);

$last_order_id = "No recent order"; // Default value if no order is found
$last_order_date = "";
$last_order_payment = 0; // Default payment amount
if ($last_order_result->num_rows > 0) {
    $last_order_row = $last_order_result->fetch_assoc();
    $last_order_id = $last_order_row['id'];
    $last_order_date = date('F j, Y, g:i a', strtotime($last_order_row['order_date'])); // Format the date
    $last_order_payment = $last_order_row['total_price']; // Fetch the payment amount
}

// Define maximum possible values
$max_users = 1000; // Define the maximum possible users
$max_orders = 100; // Define the maximum possible orders
$max_revenue = 10000; // Define the maximum possible revenue for the day

// Calculate averages in percentages
$average_users = ($total_users / $max_users) * 100; // Percentage of total users
$average_orders = ($total_orders / $max_orders) * 100; // Percentage of total orders
$average_revenue = ($total_revenue / $max_revenue) * 100; // Percentage of total revenue
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .dashboard {
            padding: 20px 0;
        }

        .dashboard h1 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--secondary-color);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .card .icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        .card .label {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 10px;
        }

        .card .value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
        }

        .card .value::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--secondary-color);
        }

        .recent-activity {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: var (--card-shadow);
            border-top: 4px solid var(--primary-color);
        }

        .recent-activity h2 {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .recent-activity h2::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-color);
        }

        .activity-list {
            list-style: none;
            padding: 0;
        }

        .activity-list li {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .activity-list li:hover {
            background: rgba(238, 191, 99, 0.1);
            padding-left: 10px;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            border: 2px solid var(--primary-color);
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
            .dashboard-cards {
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

        .dashboard-graph {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 50px;
            padding: 30px;
            border: none;
            border-radius: 25px;
            background: linear-gradient(165deg, #ffffff, #f8f9fa);
            box-shadow: 
                0 15px 35px rgba(14, 56, 44, 0.1),
                0 8px 8px rgba(14, 56, 44, 0.05),
                0 0 120px rgba(238, 191, 99, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .dashboard-graph:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 20px 40px rgba(14, 56, 44, 0.15),
                0 10px 10px rgba(14, 56, 44, 0.08),
                0 0 150px rgba(238, 191, 99, 0.12);
        }

        .dashboard-graph::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, 
                rgba(238, 191, 99, 1),
                rgba(14, 56, 44, 1),
                rgba(139, 69, 19, 1)
            );
            animation: gradientMove 3s ease infinite;
        }

        .dashboard-graph::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at top right, 
                rgba(238, 191, 99, 0.1),
                transparent 70%);
            pointer-events: none;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .dashboard-graph h2 {
            color: #0e382c;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
            text-shadow: 2px 2px 4px rgba(14, 56, 44, 0.1);
        }

        .dashboard-graph h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, 
                rgba(238, 191, 99, 1),
                rgba(14, 56, 44, 1)
            );
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(14, 56, 44, 0.2);
        }

        #averageMetricsChart {
            max-width: 1000px;
            max-height: 300px;
            margin: 0 auto;
            padding: 15px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 
                inset 0 2px 4px rgba(255, 255, 255, 0.5),
                0 4px 8px rgba(14, 56, 44, 0.05);
            transition: all 0.3s ease;
        }

        #averageMetricsChart:hover {
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 
                inset 0 2px 4px rgba(255, 255, 255, 0.6),
                0 6px 12px rgba(14, 56, 44, 0.08);
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
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="./images/logo2.jpg" alt="logo">
            <h2>Aroma's Cafe</h2>
        </div>
        <nav>
            <a href="#" class="active">
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
            <a href="cash_flow.php">
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
                <input type="text" placeholder="Search...">
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

        <div class="dashboard">
            <h1>Dashboard Overview</h1>
            <div class="dashboard-cards">
                <div class="card">
                    <div class="icon"><i class="fa-solid fa-users"></i></div>
                    <div class="label">Total Users</div>
                    <div class="value"><?php echo $total_users; ?></div>
                </div>
                <div class="card">
                    <div class="icon"><i class="fa-solid fa-box"></i></div>
                    <div class="label">Orders Today</div>
                    <div class="value"><?php echo $total_orders; ?></div>
                </div>
                <div class="card">
                    <div class="icon"><i class="fa-solid fa-coins"></i></div>
                    <div class="label">Revenue</div>
                    <div class="value">₹<?php echo number_format($total_revenue, 2); ?></div>
                </div>
            </div>

            <div class="dashboard-graph">
                <h2>Average Metrics in Percentage</h2>
                <canvas id="averageMetricsChart" width="1000" height="400"></canvas> <!-- Reduced height -->
            </div>

            <div class="recent-activity">
                <h2>Recent Activity</h2>
                <ul class="activity-list">
                    <li>
                        <div class="activity-icon">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div class="activity-details">
                            <h4>New User Registration</h4>
                            <p><?php echo htmlspecialchars($last_user_name); ?> registered as a new user</p>
                        </div>
                    </li>
                    <li>
                        <div class="activity-icon">
                            <i class="fa-solid fa-shopping-cart"></i>
                        </div>
                        <div class="activity-details">
                            <h4>New Order</h4>
                            <p>Order #<?php echo htmlspecialchars($last_order_id); ?> was placed on <?php echo htmlspecialchars($last_order_date); ?></p>
                        </div>
                    </li>
                    <!-- <li>
                        <div class="activity-icon">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="activity-details">
                            <h4>New Review</h4>
                            <p>Sarah left a 5-star review</p>
                        </div>
                    </li> -->
                    <li>
                        <div class="activity-icon">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div class="activity-details">
                            <h4>Last Payment</h4>
                            <p>The last customer paid ₹<?php echo number_format($last_order_payment, 2); ?></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('averageMetricsChart').getContext('2d');
        
        // Create gradient backgrounds
        const createGradient = (ctx, startColor, endColor) => {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, startColor);
            gradient.addColorStop(1, endColor);
            return gradient;
        };

        const averageMetricsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Users', 'Orders', 'Revenue'],
                datasets: [{
                    label: 'Average Metrics (%)',
                    data: [
                        <?php echo round($average_users, 2); ?>, 
                        <?php echo round($average_orders, 2); ?>, 
                        <?php echo round($average_revenue, 2); ?>
                    ],
                    backgroundColor: [
                        createGradient(ctx, 'rgba(238, 191, 99, 0.8)', 'rgba(238, 191, 99, 0.4)'), // Coffee gold
                        createGradient(ctx, 'rgba(14, 56, 44, 0.8)', 'rgba(14, 56, 44, 0.4)'),    // Dark green
                        createGradient(ctx, 'rgba(139, 69, 19, 0.8)', 'rgba(139, 69, 19, 0.4)')   // Brown
                    ],
                    borderColor: [
                        'rgba(238, 191, 99, 1)',
                        'rgba(14, 56, 44, 1)',
                        'rgba(139, 69, 19, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    barThickness: 40,
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                family: "'Segoe UI', Arial, sans-serif",
                                weight: 'bold'
                            },
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(14, 56, 44, 0.9)',
                        titleFont: {
                            size: 16,
                            family: "'Segoe UI', Arial, sans-serif",
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14,
                            family: "'Segoe UI', Arial, sans-serif"
                        },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ` ${context.raw}%`;
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 14,
                                family: "'Segoe UI', Arial, sans-serif",
                                weight: 'bold'
                            },
                            padding: 10
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            font: {
                                size: 12,
                                family: "'Segoe UI', Arial, sans-serif"
                            },
                            padding: 10,
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            color: 'rgba(14, 56, 44, 0.1)',
                            drawBorder: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>