<?php
class AdminLogin extends Connection{
    public $id;
    public function login($email, $password){
      $result = mysqli_query($this->conn, "SELECT * FROM coffee_shop_admin WHERE name = '$email' OR email = '$email'");
      $row = mysqli_fetch_assoc($result);
  
      if(mysqli_num_rows($result) > 0){
        if($password == $row["password"]){
          $this->id = $row["id"];
          return 1;
          // Login successful
        }
        else{
          return 10;
          // Wrong password
        }
      }
      else{
        return 100;
        // User not registered
      }
    }
  
    public function idUser(){
      return $this->id;
    }
  }
  
?>