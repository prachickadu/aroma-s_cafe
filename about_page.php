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
    <link rel="stylesheet" href="./css/about_page.css">
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
                <a href="order_page.php">Order</a>
                <a href="about_page.php" id="active">About</a>
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
           <a href="home_page.php"><h2>Home > About Us &nbsp;🥤</h2></a>
    </div>
    
    <div class="main">
      <div class="space">
        <h2>Know Us</h2>
      </div>

      <div class="container">

      <div class="text">
            <h1>We Develop & Create<br>Future. Stop Dreaming<br>Start Doing</h1>
            <br>
            <img src="./images/img103.jpg" alt="logo" width="350px" height="350px">
        </div>

        <div class="img">
          <img src="./images/img96.jpg" alt="logo" width="350px" height="350px">
          <h3>Indulge in the invigorating embrace of coffee, not just a<br>beloved beverage, but if a of numerous health benefits.<br>Beyond its aromatic allure and rich flavor.</h3>
        </div>

      </div>

<!-- container1 starts -->
      <div class="container1">
        <div class="text">
          <h1>We Develop & Create Digital Future.</h1>
          <h2>Coffee powerhouse of antioxidants,offering protection against cell damage.</h2>
          <h3>Its caffeine content provides a natural energy boost & it's enhancing focus and productivity. Studies suggest that moderate lower the risk of depression.</h3>
          <br><br>
          <input type="button" class="btn" value="About Us" style='font-weight: bold;'>
        </div>

        <div class="img">
          <img src="./images/img99.jpg" alt="logo" width="375px" height="370px">
        </div>
      </div>
<!-- container1 ends -->

<!-- container2 strats -->
      <div class="container2">
      <div class="img">
          <img src="./images/img107.jpg" class="img1" alt="logo" width="500px" height="300px">
          <img src="./images/img106.jpg" class="img2" alt="logo" width="400px" height="300px">
        </div>


        <div class="text">
          <h1>We Develop & Create<br>Digital Future.</h1>
          <h2>Coffee is a powerhouse of antioxidants,offering<br>protection against cell damage.</h2>
          <h3>Its caffeine content provides a natural energy boost & enhancing<br>focus and productivity. Studies suggest that moderate lower the<br>risk of depression.</h3>
          <br><br>
          <input type="button" class="btn" value="Explore" style='font-weight: bold;'>
        </div>

      </div>
<!-- container2 ends -->


<!-- container3 starts -->
<div class="container3">
        <div class="text">
          <h1>We Develop & Create<br>Digital Future.</h1>
          <h2>Coffee is a powerhouse of antioxidant, offering protection against cell damage.</h2>
          <h3>Its caffeine content provides a natural energy boost & enhancing focus and productivity. Studies suggest that moderate lower the risk of depression.</h3>
          <br><br>
          <input type="button" class="btn" value="Go For It" style='font-weight: bold;'>
        </div>

        <div class="img">
        <img src="./images/img108.jpg" class="img1" alt="logo" width="550px" height="300px">
        </div>

      </div>
<!-- container2 ends -->


<div class="footer">
        <img class="footer-logo" src="./images/logo2.jpg" alt="Aroma's Cafe Logo" width="90px" height="90px">
        <h1 style="margin-top:15px;">Aroma's Cafe</h1>
    </div>

    </div>

</body>
</html>
