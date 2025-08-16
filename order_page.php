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
    <link rel="stylesheet" href="./css/order_page.css">
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
                <a href="gift_page.php">Gift</a>
                <a href="order_page.php" id="active">Order</a>
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
           <a href="home_page.php"><h2>Home > Order &nbsp;🥤</h2></a>
    </div>

    <div class="order_section">
        <h2>Are you looking for...?</h2>
    </div>

<header class="head">
    <div class="navitem">
        <a href="#seller">Bestseller</a>
        <a href="#"> | </a>
        <a href="#drinks" id="click">Drinks</a>
        <a href="#"> | </a>
        <a href="#food" id="click">Food</a>
        <a href="#"> | </a>
        <a href="#desserts" id="click">Desserts</a>
    </div>
</header>

<!-- seller section starts -->
    <section id="seller" class="anytime">
        <div class="title">
        <h1>Bestseller</h1>
        <h2>Everyone's favorite Starbucks put together in a specially curated collection.</h2>
        </div>
        <div class="container">
            <div class="box">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img76.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Java Chip Frappuccino</h2>
                        <h4>TALL(354 ML) .392 kcal</h4>
                        <h3>Mocha sauce and Frappuccino chips blended with with Frappu...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 383.25</h2>
                    </div>

                <div class="btn">
                     <input type="button" class="button add-to-cart" data-id="16" data-name="Java Chip Frappuccino" data-price="383.25" data-image="./images/img76.jpg" value="Add Item">
                </div>

                </div>
            </div>


            <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img78.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Caffe Americano</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>Rich in flavour, full-bodied espresso with hot water in true...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 278.25</h2>
                    </div>
                
                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="17" data-name="Caffe Americano" data-price="278.25" data-image="./images/img78.jpg" value="Add Item">
                </div>
            </div>
        </div>


            <div class="box">
                 <div class="contain">
                    <div class="img">
                        <img src="./images/img77.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Cold Coffee</h2>
                        <h4>TALL(354 ML) .354 kcal</h4>
                        <h3>Our signature rich in flavour espresso blended with delicate...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 372.75</h2>
                    </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="18" data-name="Cold Coffee" data-price="372.75" data-image="./images/img77.jpg" value="Add Item">
                </div>
            </div>
        </div>
        </div>


        <div class="container" style="justify-content:space-between;padding-top:2px;">
            <div class="box" style="margin-left:18%;">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img80.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Cappuccino</h2>
                        <h4>SHORT(237 ML) .104 Kcal</h4>
                        <h3>Dark, Rich in flavour espresso lies in wait under a smoothed...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 299.25</h2>
                    </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="19" data-name="Cappuccino" data-price="299.25" data-image="./images/img80.jpg" value="Add Item">
                </div>
                </div>
            </div>


            <div class="box" style="margin-right:18%;">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img81.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Creamy Spinach Corn Pocket</h2>
                        <h4>PER SERVE (160 g) - 358 Kcal</h4>
                        <h3>"A creamy spinach and corn filling encased in a buttery Fren...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 252.00</h2>
                    </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="20" data-name="Creamy Spinach Corn Pocket" data-price="252.00" data-image="./images/img81.jpg" value="Add Item">
                </div>
            </div>
        </div>
    </section>
<!-- seller section ends -->

<!-- drink section starts -->
    <section id="drinks" class="anytime">
        <div class="title">
        <h1>Espresso</h1>
        <h2>Our smooth signature Espresso Roast with rich flavor and caramelly sweetness is at the very heart of everything we do.</h2>
        </div>
        <div class="container">
            <div class="box">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img46.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Lemonade</h2>
                        <h4>TALL(354 ML) .392 kcal</h4>
                        <h3>Refreshing and tangy flavor profile, perfect for quenching thirst on a hot day.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 383.25</h2>
                    </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="21" data-name="Lemonade" data-price="283.25" data-image="./images/img46.jpg" value="Add Item">
                </div>

                </div>
            </div>


            <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img82.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Blue Smurf Mojito</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>Refreshing known for its combination of citrus, sweetness, and minty freshness.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 278.25</h2>
                    </div>
                
                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="22" data-name="Blue Smurf Mojito" data-price="278.25" data-image="./images/img82.jpg" value="Add Item">
                </div>
            </div>
        </div>


            <div class="box">
                 <div class="contain">
                    <div class="img">
                        <img src="./images/img83.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Strawberry Orange Lemonade</h2>
                        <h4>TALL(354 ML) .354 kcal</h4>
                        <h3>Our signature rich in flavour espresso blended with delicate...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 372.75</h2>
                    </div>

                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="23" data-name="Strawberry Orange Lemonade" data-price="372.75" data-image="./images/img83.jpg" value="Add Item">
                </div>
            </div>
        </div>
        </div>


        <div class="container" style="padding-top:2px;">
            <div class="box">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img79.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Cappuccino</h2>
                        <h4>SHORT(237 ML) .104 Kcal</h4>
                        <h3>Dark, Rich in flavour espresso lies in wait under a smoothed...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 299.25</h2>
                    </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="24" data-name="Cappuccino" data-price="299.25" data-image="./images/img79.jpg" value="Add Item">
                </div>
                </div>
            </div>


            <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img50.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Latte Lush</h2>
                        <h4>PER SERVE (160 g) - 358 Kcal</h4>
                        <h3>The rich, velvety texture of steamed milk with the bold flavor of espresso.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 252.00</h2>
                    </div>

                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="25" data-name="Latte Lush" data-price="252.00" data-image="./images/img50.jpg" value="Add Item">
                </div>
            </div>
        </div>

        <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img42.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Tea</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>A flavorful and comforting beverage with a warm, spicy aroma and a rich, creamy texture.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 100.00</h2>
                    </div>
                
                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="26" data-name="Tea" data-price="100.00" data-image="./images/img42.jpg" value="Add Item">
                </div>
            </div>
        </div>
</div>

<div class="container" style="justify-content:space-between;margin-left:1%;padding-top:2px;">
        <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img48.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Orange sparkle</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>A vibrant, citrusy flavor reminiscent of fresh oranges.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 278.25</h2>
                    </div>
                
                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="27" data-name="Orange sparkle" data-price="278.25" data-image="./images/img48.jpg" value="Add Item">
                </div>
            </div>
        </div>

</div>
    </section>
 <!-- drink section ends    -->

<!-- food section starts -->
    <section id="food" class="anytime">
        <div class="title">
        <h1>Sandwiches & Wraps</h1>
        <h2>Signature breads made with fresh ingredients and in-house sauces.</h2>
        </div>
        <div class="container">
            <div class="box">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img51.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Veg Corn Puff</h2>
                        <h4>TALL(354 ML) .392 kcal</h4>
                        <h3>The combination of the buttery pastry and flavorful filling.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 100.25</h2>
                    </div>

                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="28" data-name="Veg Corn Puff" data-price="100.25" data-image="./images/img51.jpg" value="Add Item">
                </div>

                </div>
            </div>


            <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img53.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Fruit Sandwich</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>Creamy, rich texture and versatile fillings, ranging from simple combinations.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 200.75</h2>
                    </div>
                
                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="29" data-name="Fruit Sandwich" data-price="200.75" data-image="./images/img53.jpg" value="Add Item">
                </div>
            </div>
        </div>


            <div class="box">
                 <div class="contain">
                    <div class="img">
                        <img src="./images/img55.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Crunchy Cutlet</h2>
                        <h4>TALL(354 ML) .354 kcal</h4>
                        <h3>Delightful crunch on the outside and the soft, flavorful filling on the inside.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 100.50</h2>
                    </div>

                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="30" data-name="Crunchy Cutlet" data-price="100.50" data-image="./images/img55.jpg" value="Add Item">
                </div>
            </div>
        </div>
        </div>


        <div class="container" style="padding-top:2px;">
            <div class="box">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img60.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Honey Chilli Potato</h2>
                        <h4>SHORT(237 ML) .104 Kcal</h4>
                        <h3>Crispy texture and the perfect balance of flavors, dish that's both sweet and savory.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 299.25</h2>
                    </div>

                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="31" data-name="Honey Chilli Potato" data-price="299.25" data-image="./images/img60.jpg" value="Add Item">
                </div>
                </div>
            </div>


            <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img58.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Veg Cutlet</h2>
                        <h4>PER SERVE (160 g) - 358 Kcal</h4>
                        <h3>Savory, with a blend of spices, along with the natural sweetness of the vegetables.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 100.00</h2>
                    </div>

                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="32" data-name="Veg Cutlet" data-price="100.00" data-image="./images/img58.jpg" value="Add Item">
                </div>
            </div>
        </div>

        <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img65.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Szechuan Momos</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>Blend of spices and herbs, Szechuan pepper, chili peppers, garlic, ginger, and soy sauce.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 250.25</h2>
                    </div>
                
                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="33" data-name="Szechuan Momos" data-price="250.25" data-image="./images/img65.jpg" value="Add Item">
                </div>
            </div>
        </div>
</div>

<div class="container" style="padding-top:2px;">
        <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img84.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Hakka Noodles</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>As you twirl your chopsticks around, the first sensation that greets the comforting warmth.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 250.00</h2>
                    </div>
                
                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="34" data-name="Hakka Noodles" data-price="250.00" data-image="./images/img84.jpg" value="Add Item">
                </div>
            </div>
        </div>

        <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img89.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Paneer Tikka</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>Soft mouth melting paneer with a burst of smoky flavour.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 300.02</h2>
                    </div>
                
                <div class="btn">
                <input type="button" class="button add-to-cart" data-id="35" data-name="Paneer Tikka" data-price="300.02" data-image="./images/img89.jpg" value="Add Item">                
            </div>
            </div>
        </div>

        <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img66.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Steamed Vegetable Momos</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>Taste isn't just about satisfying hunger – it's about embracing a rich tapestry of flavors.</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 200.00</h2>
                    </div>
                
                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="36" data-name="Steamed Vegetable Momos" data-price="200.00" data-image="./images/img66.jpg" value="Add Item">                
                </div>
                </div>
            </div>
        </div>
</div>
</section>
<!-- food section ends -->

<!-- sweets section starts -->
<section id="desserts" class="anytime">
        <div class="title">
        <h1>Desserts</h1>
        <h2>Everyone's favorite mood fresher and treats collection.</h2>
        </div>
        <div class="container">
            <div class="box">

                <div class="contain">
                    <div class="img">
                        <img src="./images/img88.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Chip Frappuccino</h2>
                        <h4>TALL(354 ML) .392 kcal</h4>
                        <h3>Blended heavenly with chocolate syrup and chips chips blended with with Frappu...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 300.25</h2>
                    </div>

                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="37" data-name="Chip Frappuccino" data-price="300.25" data-image="./images/img88.jpg" value="Add Item">                
                </div>

                </div>
            </div>


            <div class="box">
                <div class="contain">
                    <div class="img">
                        <img src="./images/img93.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Gulab Jamun Ice Cream</h2>
                        <h4>SHORT(237 Ml) .0 kcal</h4>
                        <h3>Traditional gulab jamun with the creamy goodness of ice cream...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 275.00</h2>
                    </div>
                
                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="38" data-name="Gulab Jamun Ice Cream" data-price="275.00" data-image="./images/img93.jpg" value="Add Item">                
                </div>
            </div>
        </div>


            <div class="box">
                 <div class="contain">
                    <div class="img">
                        <img src="./images/img92.jpg" alt="logo" width="100px" height="100px">
                    </div>

                    <div class="text">
                        <i class="fa-regular fa-square-caret-up" style="color: #12ba45;"></i>
                        <h2>Mix Flavour Dessert</h2>
                        <h4>TALL(354 ML) .354 kcal</h4>
                        <h3>A unique dessert that combines the delightful flavours...</h3>
                    </div>
                </div>

                <div class="buy">
                    <div class="price">
                        <h2>₹ 370.75</h2>
                    </div>

                <div class="btn">
                    <input type="button" class="button add-to-cart" data-id="39" data-name="Mix Flavour Dessert" data-price="370.75" data-image="./images/img92.jpg" value="Add Item">                
                </div>
            </div>
        </div>
        </div>

    </section>
<!-- sweets section ends -->

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