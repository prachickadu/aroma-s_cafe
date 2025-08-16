<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>

    <!-- Sidebar Section -->
    <div class="sidebar" id="sidebar">
        <h2>My Sidebar</h2>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>

    <!-- Content Section -->
    <div class="content">
        <!-- Toggle Button for Sidebar -->
        <button id="toggleBtn" class="toggle-btn">☰</button>
        
        <!-- Search Box -->
        <div class="search-box">
            <h2>Search</h2>
            <input type="text" id="search" placeholder="Search here...">
        </div>

        <!-- Table Section -->
        <div class="table-box">
            <h2>Data Table</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane</td>
                        <td>25</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Doe</td>
                        <td>28</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript for Toggling Sidebar -->
    <script src="./js/script.js"></script>
</body>
</html>
