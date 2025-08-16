<?php
require 'config.php';
require 'select_logic.php';

$select = new Select();

if (!empty($_SESSION["id"])){
  $user = $select->selectUserById($_SESSION["id"]);
}
else{
  header("Location: login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing_page</title>
    <link rel="stylesheet" href="./css/gift_page.css">
    <!-- magnific popup css link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <!-- font awesome file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        .footer-logo {
            background-color: white;
            height:70px;
            width: 70px;
            margin-top:20px;
            border-radius: 50%;
            padding: 8px;
        }

        .footer-logo:hover {
            transform: scale(1.1);
        }

        .footer h1:hover{
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

        #modal-product-price{
            font-weight:bold;
        }

        #modal-total-price{
            font-weight:bold;
        }

        #modal-product-image{
            border-radius:50%;
        }

        #add-to-cart-confirm{
            padding:8px;
            border-radius:15px;
            width: 25%;
            background-color:#00754a;
            color:white;
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
                <a href="home_page.php">Home</a>
                <a href="gift_page.php" id="active">Gift</a>
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

    <div class="section">
           <a href="home_page.php"><h2>Home > Gift Cards &nbsp;🥤</h2></a>
    </div>

    <div class="order_section">
        <div class="container">

            <div class="img">
            <img src="./images/img26.jpg" alt="logo" width="200px" height="220px">
            </div>

            <div class="text">
                <h2>New Merch Alert</h2>
                <h1>Summer Collection</h1>
                <h2>Welcome Summer with our Seaside Gateway collection-let every sip feel like a beachside vacation.</h2>
                <h3>Starting From</h3>
                <h2 style="padding-top:7px;font-weight:bold;">₹ 1500</h2>
            </div>
            <div class="btn">
            <input type="button" class="button add-to-cart" data-id="8" data-name="Summer Collection" data-price="1500" data-image="./images/img26.jpg" value="Order Now">   
            </div>
        </div>
    </div>
<header class="head">
    <div class="navitem">
        <a href="#anytime">Featured</a>
        <a href="#"> | </a>
        <a href="#anytime">Anytime</a>
        <a href="#"> | </a>
        <a href="#congratulations">Congratulations</a>
        <a href="#"> | </a>
        <a href="#thanks">Thank_You</a>
    </div>
</header>

    <section id="anytime" class="anytime">
        <h1>Anytime</h1>
        <div class="line"></div>

        <div class="container">
            <div class="box1">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img37.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <h2>India Exclusive</h2>
                        <h3>Bring in the festive season and make each celebration memorable.</h3>
                    </div>
                </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="9" data-name="India Exclusive" data-price="1600" data-image="./images/img37.jpg" value="Add Item">   
                </div>
            </div>


            <div class="box2">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img49.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <h2>Aroma's Coffee</h2>
                        <h3>Aroma's coffee is best when shared. Treat your pals to a good cup of coffee.</h3>
                    </div>
                </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="10" data-name="Aroma's Coffee" data-price="1500" data-image="./images/img49.jpg" value="Add Item">   
                </div>
            </div>


            <div class="box3">
                 <div class="contain">
                    <div class="img">
                        <img src="./images/img47.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <h2>U Keep Me Warm</h2>
                        <h3>Captivating, cosy, coffee. Gift your loved ones this Aroma's Gift Card.</h3>
                    </div>
                </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="11" data-name="U Keep Me Warm" data-price="2000" data-image="./images/img47.jpg" value="Add Item">   
                </div>
            </div>
        </div>

    </section>
<br>
    <section id="congratulations" class="anytime">
        <h1>Congratulations</h1>
        <div class="line"></div>

        <div class="container">
            <div class="box1" style="margin-left:-65%;width: 350px;">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img69.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <h2>Congrats</h2>
                        <h3>Coffee, Cheer, Celebrate. Enjoy each of your special moments with Aroma's cafe.</h3>
                    </div>
                </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="12" data-name="Congrats" data-price="3000" data-image="./images/img69.jpg" value="Add Item">   
                </div>
            </div>


        </div>

    </section>
<br>

<section id="thanks" class="anytime">
        <h1>Thank You</h1>
        <div class="line"></div>

        <div class="container">
            <div class="box1">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img72.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <h2>Invest in the whole experience</h2>
                        <h3>Bring in the festive season and make each celebration memorable.</h3>
                    </div>
                </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="13" data-name="Invest in the whole experience" data-price="1700" data-image="./images/img72.jpg" value="Add Item">   
                </div>
            </div>


            <div class="box2">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img73.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <h2>Experience the Aroma</h2>
                        <h3>Aroma's coffee is best when shared. Treat your pals to a good cup of coffee.</h3>
                    </div>
                </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="14" data-name="Experience the Aroma" data-price="1800" data-image="./images/img73.jpg" value="Add Item">   
                </div>
            </div>


            <div class="box3">
                 <div class="contain">
                    <div class="img">
                        <img src="./images/img74.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <h2>Combined art and coffee</h2>
                        <h3>Captivating, cosy, coffee. Gift your loved ones this Aroma's Gift Card.</h3>
                    </div>
                </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="15" data-name="Combined art and coffee" data-price="2000" data-image="./images/img74.jpg" value="Add Item">   
                </div>
            </div>
        </div>

    </section>
<br><br>
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