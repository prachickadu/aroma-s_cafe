<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'phpdb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['order'])) {
    header("Location: add_cart.php");
    exit();
}

$order = $_SESSION['order'];
$total_price = $order['total_price'];
$order_items = $order['order_items'];
$order_date = $order['order_date'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h1>Processing Payment...</h1>
    <script>
        var options = {
            "key": "rzp_test_zd2XtvTDAInLSE", // Replace with your Razorpay API key
            "amount": <?php echo $total_price * 100; ?>, // Amount in paise
            "currency": "INR",
            "name": "Aroma's Cafe",
            "description": "Order Payment",
            "image": "./images/logo2.jpg",
            "handler": function (response) {
                // On successful payment, send data to the server
                fetch('record_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_id: response.razorpay_payment_id,
                        order: <?php echo json_encode($order); ?>
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Payment Successful! Order Recorded.');
                        window.location.href = 'home_page.php';
                    } else {
                        alert('Payment Successful, but failed to record the order.');
                    }
                })
                .catch(error => console.error('Error:', error));
            },
            "prefill": {
                "name": "Your Name",
                "email": "your.email@example.com",
                "contact": "9999999999"
            },
            "theme": {
                "color": "#00754a"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    </script>
</body>
</html>