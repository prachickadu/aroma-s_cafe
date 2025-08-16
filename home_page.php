<?php
require 'config.php'; // Include the config file

// Create an instance of the Connection class
$connection = new Connection();
$conn = $connection->conn; // Access the database connection

require 'select_logic.php';

$select = new Select();

if (!empty($_SESSION["id"])) {
  $user = $select->selectUserById($_SESSION["id"]);
} else {
  header("Location: login.php");
  exit();
}

// Fetch menu items
$menu_query = "SELECT * FROM menu";
$menu_result = $conn->query($menu_query); // Use the $conn object

// Fetch featured items for the "Handcrafted Curations" section
$featured_query = "SELECT * FROM menu WHERE category = 'featured'";
$featured_result = $conn->query($featured_query);

// Fetch latest offerings for the "Latest Offerings" section
$latest_query = "SELECT * FROM menu WHERE category = 'latest'";
$latest_result = $conn->query($latest_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="./css/home_page.css">
    <!-- magnific popup css link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css">

    <style>
        .footer-logo {
            background-color: white;
            height: 70px;
            width: 70px;
            margin-top: 20px;
            border-radius: 50%;
            padding: 8px;
        }

        .footer-logo:hover {
            transform: scale(1.1);
        }

        .footer h1:hover {
            transform: scale(1.1);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius:10px;
        }

        #modal-product-price{
            font-weight:bold;
        }

        #modal-total-price{
            font-weight:bold;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .quantity-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .quantity-controls button {
            background-color: #00754a;
            color: white;
            border: none;
            padding: 5px 10px;
            margin: 0 5px;
            cursor: pointer;
        }

        .quantity-controls input {
            width: 50px;
            text-align: center;
        }

        #modal-product-image{
            border-radius:50%;
        }

        #add-to-cart-confirm{
            padding:10px;
            border-radius:15px;
            width: 20%;
            background-color:#00754a;
            color:white;
            font-size:1rem;
        }

        #add-to-cart-confirm:hover{
            background-color:#0e382c;
        }
        
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="./images/logo2.jpg" alt="logo" width="60px" height="60px">
        </div>
        <nav class="navbar">
            <a href="#home" id="active">Home</a>
            <a href="gift_page.php">Gift</a>
            <a href="order_page.php">Order</a>
            <a href="about_page.php">About</a>
            <a href="contact_page.php">Contact</a>
            <a href="add_cart.php"><i class="fa-solid fa-cart-shopping" style="color:#00754a;"></i>
                <span id="cart-count" style="margin-left:-3%;">
                <sup>
                    <?php 
                        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                            echo array_sum(array_column($_SESSION['cart'], 'quantity'));
                        } else {
                            echo 0;
                        }
                    ?>
                    </sup>
                </span>
            </a>
            <a href="logout.php"><input type="button" class="btn" value="Logout" style="padding:10px;width:10%;float:right;border-radius:10px;background-color:#00754a;color:#fff;font-weight:bold;"></a> 
        </nav>
    </header>
    
    <div class="welcome">
        <h2>Welcome <?php echo htmlspecialchars($user["name"]); ?>!</h2>
    </div>

    <div class="space"></div>

    <div class="menu">
        <h1>Barista Recommends</h1>
        <br><br>
        <div class="container">
<?php
                        while ($menu_item = $menu_result->fetch_assoc()):
            ?>
            <div class="contain">
                <div class="image">
                    <img src="<?php echo $menu_item['image']; ?>" alt="<?php echo $menu_item['name']; ?>" width="60px" height="60px">
                </div>
                <div class="text">
<?php if ($menu_item['type'] === 'veg'): ?>
                            <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <?php else: ?>
                    <i class="fa-regular fa-square-caret-up" style="color: #e30d0d;"></i>
<?php endif; ?>
                    <h2><?php echo $menu_item['name']; ?></h2><br>
                    <p><?php echo $menu_item['kcal']; ?> kcal</p><br>
                    <div class="buy">
                        <div class="mrp">
                            <h3>₹<?php echo $menu_item['price']; ?></h3>
                </div>
                                        <div class="cart">
                            <input type="button" class="button add-to-cart" data-id="<?php echo $menu_item['id']; ?>" data-name="<?php echo $menu_item['name']; ?>" data-price="<?php echo $menu_item['price']; ?>" data-image="<?php echo $menu_item['image']; ?>" value="Add Cart">
</div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- menu section ends -->

    <div class="handcraft">
        <div class="order">
            <div class="sec1">
                <img src="./images/img2.jpg" alt="Cold Brew Tiramisu" width="60px" height="60px">
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
                        <input type="button" class="orderbtn add-to-cart" data-id="4" data-name="Cold Brew Tiramisu" data-price="449.10" data-image="./images/img2.jpg" value="Order now">
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
                    <img src="./images/img7.jpg" alt="Bestseller" width="60px" height="60px">
                    <h2>Bestseller</h2>
                </div>

                <div class="image">
                    <img src="./images/img6.jpg" alt="Drinks" width="60px" height="60px">
                    <h2>Drinks</h2>
                </div>

                <div class="image">
                    <img src="./images/img11.jpg" alt="Ready to Eat" width="60px" height="60px">
                    <h2>Ready to Eat</h2>
                </div>

                <div class="image">
                    <img src="./images/img13.jpg" alt="Food" width="60px" height="60px">
                    <h2>Food</h2>
                </div>

                <div class="image">
                    <img src="./images/img19.jpg" alt="Coffee At Home" width="60px" height="60px">
                    <h2>Coffee At Home</h2>
                </div>

                <div class="image">
                    <img src="./images/img12.jpg" alt="Merchandise" width="60px" height="60px">
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
                        <img src="./images/img23.jpg" alt="Belgium Chocolate Frappuccino" style="width:300px;height:300px;">
                    </div>
                    <div class="flip-card-back">
                        <div class="text">
                            <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                            <h3>Belgium Chocolate Frappuccino</h3>
                            <h5>TALL(354 ML).470 Kcal</h5>
                            <p>Blend of decadent Belgian chocolate sauce and coffee with a whipped chocolate topping. The beverage is finished with...</p>
                        </div>
                        <div class="buy">
                            <div class="mrp">
                                <h2>₹ 509.25</h2>
                            </div>
                            <div class="cart">
                                <input type="button" class="btn add-to-cart" data-id="5" data-name="Belgium Chocolate Frappuccino" data-price="509.25" data-image="./images/img23.jpg" value="Add Item">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="./images/img24.jpg" alt="Belgium Chocolate Latte" style="width:300px;height:300px;">
                    </div>
                    <div class="flip-card-back">
                        <div class="text">
                            <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                            <h3>Belgium Chocolate Latte</h3> 
                            <h5>SHORT(237 ML).235 Kcal</h5> <br>
                            <p>Espresso with decadent Belgian chocolate sauce, mocha sauce and steamed milk. Topped with whipped chocolate to...</p>
                        </div>

                        <div class="buy">
                            <div class="mrp">
                                <h2>₹ 430.50</h2>
                            </div>
                            <div class="cart">
                                <input type="button" class="btn add-to-cart" data-id="6" data-name="Belgium Chocolate Latte" data-price="430.50" data-image="./images/img24.jpg" value="Add Item">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="./images/img25.jpg" alt="Iced Belgium Chocolate Latte" style="width:300px;height:300px;">
                    </div>
                    <div class="flip-card-back">
                        <div class="text">
                            <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                            <h3>Iced Belgium Chocolate Latte</h3> 
                            <h5>TALL(354 ML).340 Kcal</h5> <br>
                            <p>Espresso with decadent Belgian chocolate sauce, mocha sauce and steamed milk served over ice. Topped with whip...</p>
                        </div>

                        <div class="buy">
                            <div class="mrp">
                                <h2>₹ 472.50</h2>
                            </div>
                            <div class="cart">
                                <input type="button" class="btn add-to-cart" data-id="7" data-name="Iced Belgium Chocolate Latte" data-price="472.50" data-image="./images/img25.jpg" value="Add Item">   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <img class="footer-logo" src="./images/logo2.jpg" alt="Aroma's Cafe Logo" width="90px" height="90px">
        <h1 style="margin-top:15px;">Aroma's Cafe</h1>
    </div>

    <!-- Modal HTML -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modal-product-image" src="" alt="" width="100" height="100"><br><br>
            <h2 id="modal-product-name"></h2><br>
            <p>Price: ₹<span id="modal-product-price"></span></p>
            <div class="quantity-controls">
                <button id="decrease-quantity">-</button>
                <input type="text" id="product-quantity" value="1" readonly>
                <button id="increase-quantity">+</button>
            </div><br>
            <p>Total: ₹<span id="modal-total-price"></span></p><br>
            <button id="add-to-cart-confirm">Add to Cart</button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        const cartCountElement = document.getElementById('cart-count');
        const modal = document.getElementById('myModal');
        const modalProductName = document.getElementById('modal-product-name');
        const modalProductImage = document.getElementById('modal-product-image');
        const modalProductPrice = document.getElementById('modal-product-price');
        const modalTotalPrice = document.getElementById('modal-total-price');
        const productQuantity = document.getElementById('product-quantity');
        const addToCartConfirm = document.getElementById('add-to-cart-confirm');
        let currentProduct;

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = parseFloat(this.getAttribute('data-price'));
                const productImage = this.getAttribute('data-image');

                modalProductName.textContent = productName;
                modalProductImage.src = productImage;
                modalProductPrice.textContent = productPrice.toFixed(2);
                productQuantity.value = 1;
                modalTotalPrice.textContent = productPrice.toFixed(2);

                currentProduct = { id: productId, name: productName, price: productPrice, image: productImage };

                modal.style.display = "block";
            });
        });

        document.querySelector('.close').addEventListener('click', function() {
            modal.style.display = "none";
        });

        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });

        document.getElementById('increase-quantity').addEventListener('click', function() {
            let quantity = parseInt(productQuantity.value);
            quantity++;
            productQuantity.value = quantity;
            modalTotalPrice.textContent = (quantity * currentProduct.price).toFixed(2);
        });

        document.getElementById('decrease-quantity').addEventListener('click', function() {
            let quantity = parseInt(productQuantity.value);
            if (quantity > 1) {
                quantity--;
                productQuantity.value = quantity;
                modalTotalPrice.textContent = (quantity * currentProduct.price).toFixed(2);
            }
        });

        // addToCartConfirm.addEventListener('click', function() {
        //     const quantity = parseInt(productQuantity.value);
        //     addToCart(currentProduct, quantity);
        //     modal.style.display = "none";
        // });

    addToCartConfirm.addEventListener('click', function() {
    const quantity = parseInt(productQuantity.value);
    addToCart(currentProduct, quantity);
    modal.style.display = "none";
        window.location.href = 'add_cart.php';
    });


        function addToCart(product, quantity) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const newCartCount = parseInt(xhr.responseText);
                    cartCountElement.textContent = newCartCount;
                }
            };
            xhr.send(`id=${product.id}&name=${product.name}&price=${product.price}&image=${product.image}&quantity=${quantity}`);
        }
    });

    </script>
</body>
</html>
