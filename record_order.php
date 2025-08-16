<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'phpdb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['payment_id']) && isset($data['order'])) {
    $payment_id = $data['payment_id'];
    $order = $data['order'];
    $total_price = $order['total_price'];
    $order_date = $order['order_date'];

    // Insert order into the database
    $insert_order_query = "INSERT INTO orders (order_date, total_price, payment_id) VALUES ('$order_date', '$total_price', '$payment_id')";
    if ($conn->query($insert_order_query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to record order']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
?>