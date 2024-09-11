<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure cart exists
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "Your cart is empty.";
        exit();
    }

    // Gather user data
    $username = $_SESSION['username'];
    $address = $_POST['address'];
    $paymentMethod = $_POST['payment'];

    // Process order (store in database)
    $cart = $_SESSION['cart'];
    $totalPrice = 0;

    foreach ($cart as $product) {
        $totalPrice += $product['price'] * $product['quantity'];
        // Store order in database (you can improve this by adding more details)
        $query = "INSERT INTO orders (username, product_id, quantity, total_price, address, payment_method)
                  VALUES ('$username', '{$product['id']}', '{$product['quantity']}', '$totalPrice', '$address', '$paymentMethod')";
        $conn->query($query);
    }

    // Clear the cart after processing
    unset($_SESSION['cart']);

    // Redirect to confirmation page
    header("Location: order_confirmation.php");
    exit();
}
?>
