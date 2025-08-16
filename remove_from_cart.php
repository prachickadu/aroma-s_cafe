<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];

    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }

    $totalItems = array_sum(array_column($_SESSION['cart'], 'quantity'));
    echo json_encode(array('status' => 'success', 'cart' => $_SESSION['cart'], 'totalItems' => $totalItems));
}
?>
