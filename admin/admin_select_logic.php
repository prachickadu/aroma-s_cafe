<?php
session_start();
class Select extends Connection{
  public function selectUserById($id){
    $result = mysqli_query($this->conn, "SELECT * FROM coffee_shop_admin WHERE id = $id");
    return mysqli_fetch_assoc($result);
  }
}
?>