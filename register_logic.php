<?php

class Register extends Connection{
    public function registration($name, $email, $password){
      $duplicate = mysqli_query($this->conn, "SELECT * FROM coffee_shop WHERE name = '$name' OR email = '$email'");
      if(mysqli_num_rows($duplicate) > 0){
        return 10;
        // email has already taken
      }
      else{
        $query = "INSERT INTO coffee_shop VALUES('', '$name','$email', '$password')";
        mysqli_query($this->conn, $query);
        return 1;
        // sign up successful
      }
    }
  }
    
?>