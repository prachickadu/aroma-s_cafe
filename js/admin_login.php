<?php
require '../config.php';
require 'admin_login_logic.php';
require 'admin_select_logic.php';

// session_start();
error_reporting(E_ALL);
if(!empty($_SESSION["id"])){
  header("Location: admin_dashboard.php");
}

if(!isset($_GET['submit'])){
  header("location:../index.php");
  die();
}

$login = new AdminLogin();

if(isset($_POST["submit"])){
  $result = $login->login($_POST["email"], $_POST["password"]);

  if($result == 1){
    $_SESSION["login"] = true;
    $_SESSION["id"] = $login->idUser();
    header("Location: admin_dashboard.php");
  }
  elseif($result == 10){
    echo
    "<script> alert('Wrong Password'); </script>";
  }
  elseif($result == 100){
    echo
    "<script> alert('User Not Registered'); </script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin_page</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

</head>
<body>
    <div class="container">

        <div class="login_form">
            <div class="merge" style="margin-top:15%;">
        <form action="" method="POST">

            <h2>Login </h2><br>
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
        <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="icon">
        <i class="bi bi-eye-slash" id="togglePassword"></i>
        </div>

        <br><br>
        </div>

        <input type="submit" class="btn-submit" name="submit" value="Login">
        </div>
            </div>

            <div class="clip_art">
                <img src="../images/img114.jpg" alt="logo" width="275px" height="275px" style="margin-top:12%;margin-left:20%;">
            </div>

        </div>
</body>
<script src="./js/script.js"></script>
</html>