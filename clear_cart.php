<?php
session_start();
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Cart is already empty']);
}
?>
