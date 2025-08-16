<?php
session_start();
// require('config.php');
error_reporting(E_ALL);
if(isset($_SESSION['id'])){
    header("location:home_page.php");
    die();
  }  
include('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing_page</title>
    <link rel="stylesheet" href="./css/style.css">
    <!-- magnific popup css link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <!-- font awesome file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        .navbar-links {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .buttons {
            display: flex;
            gap: 15px;
        }
        .log-btn {
            padding: 9px;
            width: 100%;
            border-radius: 10px;
            background-color: #00754a;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="./images/logo2.jpg" alt="logo" width="60px" height="60px">
        </div>
        <nav class="navbar">
            <div class="navbar-links">
                <a href="#home" id="active">Home</a>
                <a href="#">Gift</a>
                <a href="#">Order</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
            </div>
            <div class="buttons">
                <form action="./admin/admin_login.php" method="get">
                    <button type="submit" name="submit" class="log-btn">Admin Login</button>
                </form>
                <form action="login.php" method="get">
                    <button type="submit" name="submit" class="log-btn">User Login</button>
                </form>
            </div>
        </nav>
    </header>
    
    <div class="welcome">
        <h2>Welcome to Aroma's Cafe</h2>
    </div>

    <div class="space"></div>

    <!-- menu section starts -->
    <div class="menu">
        <!-- <br> -->
        <h1>Barista Recommends</h1>
        <br><br><br>
        <div class="container">
            <div class="contain">
                <div class="image">
                    <img src="./images/img8.jpg" alt="logo" width="60px" height="60px">
                </div>
                <div class="text">
                    <i class="fa-regular fa-square-caret-up" style="color: #e30d0d;"></i>
                    <h2>Bhuna Chicken Puff</h2><br>
                    <p>80g/309kcal</p><br>
                    <div class="buy">
                        <div class="mrp">
                            <h3>₹ 199.75</h3>
                        </div>
                        <div class="cart">
                            <input type="button" class="button" value="Add Cart">
                        </div>
                    </div>
                </div>
            </div>

            <div class="contain">
                <div class="image">
                    <img src="./images/img9.jpg" alt="logo" width="60px" height="60px">
                </div>
                <div class="text">
                    <i class="fa-regular fa-square-caret-up" style="color: #e30d0d;"></i>
                    <h2>Tandoori Chicken Panini Sandwich</h2><br>
                    <p>290g/901kcal</p><br>
                    <div class="buy">
                        <div class="mrp">
                            <h3>₹ 299.50</h3>
                        </div>
                        <div class="cart">
                            <input type="button" class="button" value="Add Cart">
                        </div>
                    </div>
                </div>
            </div>

            <div class="contain">
                <div class="image">
                    <img src="./images/img12.jpg" alt="logo">
                </div>
                <div class="text">
                    <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                    <h2>Chocolate Brownie Cupcake</h2><br>
                    <p>80g/416kcal</p><br>
                    <div class="buy">
                        <div class="mrp">
                            <h3>₹ 449.10</h3>
                        </div>
                        <div class="cart">
                            <input type="button" class="button" value="Add Cart">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>
    <!-- menu section ends -->

    <div class="handcraft">
        <div class="order">
            <div class="sec1">
                <img src="./images/img2.jpg" alt="logo" width="60px" height="60px">
            </div>
            <div class="sec2">
                <h2>Coffee Meets Dessert</h2><br><br>
                <h1>Cold Brew Tiramisu</h1><br><br>
                <h2>Experience the harmonious blend of smooth coffee, nutty almond, and creamy mascarpone.</h2>
                <div class="sec3">
                    <div class="sec3buy">
                        <h3>For</h3>
                        <h2>Rs. 300</h2>
                    </div>
                    <div class="sec3order">
                        <input type="button" class="orderbtn" value="Order now">
                    </div>
                </div>
            </div>
        </div>
        <div class="curation">
            <div class="text">
                <h1>Handcrafted Curations</h1>
            </div>
            <div class="imgsec">
                <div class="image">
                    <img src="./images/img7.jpg" alt="logo" width="60px" height="60px">
                    <h2>Bestseller</h2>
                </div>
                <div class="image">
                    <img src="./images/img6.jpg" alt="logo" width="60px" height="60px">
                    <h2>Drinks</h2>
                </div>
                <div class="image">
                    <img src="./images/img11.jpg" alt="logo" width="60px" height="60px">
                    <h2>Ready to Eat</h2>
                </div>
                <div class="image">
                    <img src="./images/img13.jpg" alt="logo" width="60px" height="60px">
                    <h2>Food</h2>
                </div>
                <div class="image">
                    <img src="./images/img19.jpg" alt="logo" width="60px" height="60px">
                    <h2>Coffee At Home</h2>
                </div>
                <div class="image">
                    <img src="./images/img12.jpg" alt="logo" width="60px" height="60px">
                    <h2>Merchandise</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="free">
        <div class="text">
            <h1>Flat 50% Off on Food</h1>
        </div>
        <div class="btns">
            <input type="button" class="btn" value="Know More">
        </div>
    </div>

    <div class="off"></div>

    <div class="offer">
        <div class="text">
            <h1>Latest Offerings</h1>
        </div>
        <div class="card">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="./images/img23.jpg" alt="Avatar" style="width:300px;height:300px;">
                    </div>
                    <div class="flip-card-back">
                        <div class="text">
                            <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                            <h3>Belgium Chocolate Frappuccino</h3>
                            <h5>TALL(354 ML).470 Kcal</h5><br>
                            <p>Blend of decadent Belgian chocolate sause and coffee with a whipped chocolate topping. The beverage is finishe...</p>
                        </div>
                        <div class="buy">
                            <div class="mrp">
                                <h2>₹ 509.25</h2>
                            </div>
                            <div class="cart">
                                <input type="button" class="btn" value="Add Item">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="./images/img24.jpg" alt="Avatar" style="width:300px;height:300px;">
                    </div>
                    <div class="flip-card-back">
                        <div class="text">
                            <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                            <h3>Belgium Chocolate Latte</h3>
                            <h5>SHORT(237 ML).235 Kcal</h5><br>
                            <p>Espresso with decadent Belgian chocolate sauce, mocha sauce and steamed milk. Topped with whipped chocolate to...</p>
                        </div>
                        <div class="buy">
                            <div class="mrp">
                                <h2>₹ 430.50</h2>
                            </div>
                            <div class="cart">
                                <input type="button" class="btn" value="Add Item">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="./images/img25.jpg" alt="Avatar" style="width:300px;height:300px;">
                    </div>
                    <div class="flip-card-back">
                        <div class="text">
                            <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                            <h3>Iced Belgium Chocolate Latte</h3>
                            <h5>TALL(354 ML).340 Kcal</h5><br>
                            <p>Espresso with decadent Belgian chocolate sauce, mocha sauce and steamed milk served over ice. Topped with whip...</p>
                        </div>
                        <div class="buy">
                            <div class="mrp">
                                <h2>₹ 472.50</h2>
                            </div>
                            <div class="cart">
                                <input type="button" class="btn" value="Add Item">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <img src="./images/logo2.jpg" alt="logo" width="90px" height="90px">
        <h1>Aroma's Cafe</h1>
    </div>
</body>
</html>
