<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$totalItems = array_sum(array_column($_SESSION['cart'], 'quantity'));
echo json_encode(array('status' => 'success', 'cart' => $_SESSION['cart'], 'totalItems' => $totalItems));
?>
