<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'phpdb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$user_query = "SELECT * FROM coffee_shop";
$user_result = $conn->query($user_query);

// Add user functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $add_user_query = "INSERT INTO coffee_shop (name, email, password) VALUES ('$name', '$email', '$password')";
    $conn->query($add_user_query);
    header("Location: manage_users.php");
}

// Delete user functionality
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $delete_user_query = "DELETE FROM coffee_shop WHERE id = $user_id";
    $conn->query($delete_user_query);
    header("Location: manage_users.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Aroma's Cafe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0e382c;
            --secondary-color: #eebf63;
            --text-color: #2a2a2a;
            --bg-color: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --accent-color: #eebf63;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
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
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--primary-color);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #0a2b22;
            transform: translateY(-2px);
        }

        .table {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .table thead {
            background: var(--primary-color);
            color: #fff;
        }

        .table th {
            font-weight: 500;
            padding: 15px;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
        }

        .btn-danger {
            background: #dc3545;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #bb2d3b;
            transform: translateY(-2px);
        }

        .modal-content {
            border-radius: 12px;
            border: none;
        }

        .modal-header {
            background: var(--primary-color);
            color: #fff;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            font-weight: 500;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        .form-control {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(14, 56, 44, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: var(--text-color);
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
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="./images/logo2.jpg" alt="logo">
            <h2>Aroma's Cafe</h2>
        </div>
        <nav>
            <a href="admin_dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="#" class="active"><i class="fa-solid fa-people-roof"></i> Manage Users</a>
            <a href="track_order.php"><i class="fa-solid fa-truck-fast"></i> Track Orders</a>
            <a href="manage_menu.php"><i class="fa-solid fa-utensils"></i> Manage Menu</a>
            <a href="cash_flow.php"><i class="fa-solid fa-money-bill-wave"></i> Cash Flow</a>
            <a href="#"><i class="fa-solid fa-comments"></i> Feedback</a>
        </nav>
    </div>
    <div class="main-content">
        <div class="navbar">
            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="Search users...">
            </div>
            <div class="profile dropdown">
                <span>Welcome, Admin</span>
                <img src="../images/logo2.jpg" alt="profile" class="dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Manage Users</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus me-2"></i>Add New User
                </button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $user_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td>
                                    <a href="?delete_user=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash-alt me-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>