<?php
require 'config.php';
require 'register_logic.php';
require 'select_logic.php';

if (!empty($_SESSION["id"])){
  header("Location: home_page.php");
}

$register = new Register();

if(isset($_POST["submit"])){
  $result = $register->registration($_POST["name"],$_POST["email"],$_POST["password"]);

  if($result == 1){
    echo
    "<script> alert('Registration Successful'); </script>";
    header("location:login.php");

  }
  elseif($result == 10){
    echo
    "<script> alert('Username or Email Has Already Taken'); </script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/signup.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

</head>
<body>
    <div class="container">
    <div class="clip_art">
                <img src="./images/img27.jpg" alt="logo" width="350px" height="350px">
            </div>

        <div class="login_form">
        <form action="" method="POST">

            <h2>Sign Up</h2><br>
    <div class="name">
    <div class="input">
        <input type="text" placeholder="User Name" class="name" name="name" id="name" required>
        </div>
        <div class="icon">
          <i class="fa fa-fw fa-user"></i>
</div>
          </div>

    <div class="mail">
        <div class="input">
        <input type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="icon">
        <i class="fa fa-envelope"> </i>
        </div>
        </div>

        <div class="password">
            <div class="input">
        <input type="password" name="password" id="password" placeholder=" Password" required>
        </div>
        <div class="icon">
        <i class="bi bi-eye-slash" id="togglePassword"></i>
        </div>

        <br><br>
        </div>

        <input type="submit" class="btn-submit" name="submit" value="Sign Up">

        <div class="register"> Don't have an account?
        <a href="login.php" class="r-link">Login</a>
        </div>
            </div>

            
        </div>
</body>
<script src="./js/script.js"></script>
</html>