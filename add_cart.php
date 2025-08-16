<?php
session_start();
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$conn = new mysqli('localhost', 'root', '', 'phpdb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (!empty($_SESSION['cart'])) {
        $total_price = 0;
        $order_items = [];
        $order_date = date('Y-m-d H:i:s'); // Current date and time

        foreach ($_SESSION['cart'] as $id => $item) {
            $item_name = $item['name'];
            $item_price = $item['price'];
            $item_quantity = $item['quantity'];
            $item_total = $item_price * $item_quantity;
            $total_price += $item_total;

            $order_items[] = [
                'name' => $item_name,
                'quantity' => $item_quantity,
                'price' => $item_price,
                'total' => $item_total
            ];
        }

        // Store order details in session for Razorpay
        $_SESSION['order'] = [
            'total_price' => $total_price,
            'order_items' => $order_items,
            'order_date' => $order_date
        ];

        // Redirect to payment processing
        header("Location: process_payment.php");
        exit();
    } else {
        echo "Your cart is empty.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $newQuantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
        echo json_encode(['status' => 'success']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found in cart']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="./css/add_cart.css">
    <!-- magnific popup css link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        .product-info {
            display: flex;
            align-items: center;
        }

        .product-info img {
            margin-left: 30px; /* Adjust the margin as needed */
        }

        .product-info span {
            margin-left: 40px; /* Adjust the margin as needed */
        }

        .product-heading{
            text-align: center;
        }

        #total{
            padding-left:3%;
        }
        
        .quantity-change {
            font-size: 12px; 
            padding: 4px 8px; 
            color: black;
            font-weight:bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
        }


        #decrease {
            font-size: 20px; 
        }

        #increase {
            margin-left:-9%;
        }

        .quantity-input {
            margin-left: 6%;
        }

        .remove-item {
            margin-left: 18%;
        }

    .modal-content {
    padding: 15px;
    font-size: 14px;
    border-radius: 10px;
    background-color: #ecf0f3;
}

.modal-header, .modal-footer {
    padding: 10px;
}

.modal-body {
    padding: 10px;
}

.modal-title {
    font-size: 16px;
}

.form-group {
    margin-bottom: 10px;
}

.form-control {
    height: 30px;
    padding: 5px 10px;
    font-size: 14px;
}

.btn {
    padding: 5px 10px;
    font-size: 14px;
}

label{
    font-weight:lighter;
}

#color{
    background-color:#613722;
    color:#fff;
    transition: background-color 0.3s ease;
}

#color:hover{
    background-color: #6d3a1a;
}


.form-group input[type="text"],
.form-group input[type="tel"]{
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 15px;
    box-sizing: border-box;
    box-shadow: inset 8px 8px 8px#cbc3d1,inset -8px -8px 8px #ffffff ;
}

    </style>

</head>
<body>
<header class="header">
    <div class="logo">
        <img src="./images/logo2.jpg" alt="logo" width="60px" height="60px">
    </div>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="gift_page.php">Gift</a>
        <a href="order_page.php">Order</a>
        <a href="about_page.php">About</a>
        <a href="contact_page.php">Contact</a>
        <a href="add_cart.php"><i class="fa-solid fa-cart-shopping" style="color:#00754a;"></i>
                <span id="cart-count" style="margin-left:-3%;">
                <sup>
                    <?php 
                        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                            echo array_sum(array_column($_SESSION['cart'], 'quantity'));
                        } else {
                            echo 0;
                        }
                    ?>
                    </sup>
                </span>
            </a>
            <a href="logout.php"><input type="button" class="btn" value="Logout" style="padding:7px;width:10%;float:right;border-radius:10px;background-color:#00754a;color:#fff;font-weight:bold;"></a>  
    </nav>
</header>

<h1>Your Cart</h1>
<div class="cart-items">
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <?php $total = 0; ?>
        <table class="table table" style="margin-top:60px;">
            <thead>
                <tr>
                    <th class="product-heading">Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <?php $itemTotal = $item['price'] * $item['quantity']; ?>
                    <?php $total += $itemTotal; ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="60px" height="60px">
                                <span><?php echo $item['name']; ?></span>
                            </div>
                        </td>
                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <button class="quantity-change" id="decrease" data-id="<?php echo $id; ?>" data-change="decrease">-</button>
                            <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1" max="10" readonly>
                            <button class="quantity-change" id="increase" data-id="<?php echo $id; ?>" data-change="increase">+</button>
                        </td>
                        <td>₹<?php echo number_format($itemTotal, 2); ?></td>
                        <td><button class="remove-item" data-id="<?php echo $id; ?>"><i class="fa-solid fa-trash-can" style="color: #ad1f14;"></i></button></td>
                    </tr>
                <?php endforeach; ?>
                
    <tr>
    <td colspan="3" class="table-danger" id="total"><strong>Total</strong></td>
    <td class="table-danger">₹<?php echo number_format($total, 2); ?></td>
    <td class="table-danger">
        <form method="POST" action="add_cart.php">
            <button type="submit" name="place_order" class="btn" id="color" style="width:60%;font-weight:bold;">Place Order</button>
        </form>
    </td>
        </tr>            
    </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Integration -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalAmount = <?php echo $total; ?>;
    const buyButton = document.getElementById('color');
    buyButton.addEventListener('click', function() {
        var options = {
            "key": "rzp_test_zd2XtvTDAInLSE", 
            "amount": totalAmount * 100, // Amount is in currency subunits 
            "currency": "INR",
            "name": "Aroma's Cafe",
            "description": "Test Transaction",
            "image": "./images/logo2.jpg",
            "handler": function (response){
                alert("Payment Successful!");
                fetch('clear_cart.php', {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = 'home_page.php'; 
                    } else {
                        alert('Failed to clear the cart.');
                    }
                })
                .catch(error => console.error('Error:', error));
            },
            "prefill": {
                "name": "Your Name",
                "email": "your.email@example.com",
                "contact": "9999999999"
            },
            "notes": {
                "address": "Your Address"
            },
            "theme": {
                "color": "#00754a"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    });

    // Manage quantity 
    const quantityChangeButtons = document.querySelectorAll('.quantity-change');
    quantityChangeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const changeType = this.getAttribute('data-change');
            const inputElement = this.parentElement.querySelector('.quantity-input');
            let newQuantity = parseInt(inputElement.value);

            if (changeType === 'increase') {
                newQuantity++;
            } else if (changeType === 'decrease' && newQuantity > 1) {
                newQuantity--;
            }

            inputElement.value = newQuantity;

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', newQuantity);

            fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload(); 
                } else {
                    alert('Failed to update quantity.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Remove items from the cart
    const removeButtons = document.querySelectorAll('.remove-item');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');

            const formData = new FormData();
            formData.append('product_id', productId);

            fetch('remove_from_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload(); 
                                } else {
                    alert('Failed to remove item from cart.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>

</body>
</html>
