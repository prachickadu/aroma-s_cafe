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
    <link rel="stylesheet" href="./css/contact_page.css">
    <!-- magnific popup css link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <!-- font awesome file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

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
                <a href="about_page.php">About</a>
                <a href="contact_page.php" id="active">Contact</a>
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


    <div class="container">
    <div class="wrapper">
  <h2>Contact Us</h2><br>
  <div class="fields">
      <input type="text" placeholder="User Name" class="name" name="name" id="name" value="<?php echo $user["name"]; ?>" required>
      <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $user["email"]; ?>" required>
      <input type="tel" placeholder="Phone no." class="phone" name="phone" id="phone" maxlength="10" required>
      <textarea name="message" id="message" placeholder="Message" rows="4" required></textarea>

  <div class="btn">
  <input type="button" class="btn-submit" name="submit" value="Send">
  </div>
  </div>
</body>
</html>