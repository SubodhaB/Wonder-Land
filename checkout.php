<?php
include 'connection.php'; // Ensure this file contains the correct database connection code
session_start(); // Start the session

// Initialize the cart if not already done
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle adding items to the cart
if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']); // Ensure the ID is an integer
    if ($product_id > 0) {
        // Increment product quantity if it already exists in the cart, otherwise set it to 1
        $_SESSION['cart'][$product_id] = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id] + 1 : 1;
    } else {
        echo "Invalid product ID.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Toy Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['username'])): ?>
            <div class="user-info" style="float: right;">
                <span>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="logout.php">Logout</a>
            </div>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </header>

    <!-- Main Section -->
    <section>
        <h1>Your Cart</h1>
        <ul>
            <?php
            $total = 0; // Initialize the total cost variable
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id => $quantity) {
                    $query = "SELECT * FROM products WHERE id = ?";
                    if ($stmt = $conn->prepare($query)) {
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $product = $result->fetch_assoc();
                            // Display product name, quantity, and price
                            echo "<li>{$product['name']} x $quantity - " . number_format($product['price'], 2) . " USD</li>";
                            $total += $product['price'] * $quantity; // Calculate the total cost
                        } else {
                            echo "<li>Invalid cart item: ID $id</li>";
                        }
                        $stmt->close();
                    } else {
                        echo "<li>Error preparing SQL statement.</li>";
                    }
                }
                // Display the total cost of the cart items
                echo "<p>Total: " . number_format($total, 2) . " USD</p>";
            } else {
                // If the cart is empty, display a message
                echo "<p>Your cart is empty!</p>";
            }
            ?>
        </ul>
        <a href="checkout.php">Proceed to Checkout</a> <!-- Link to proceed to checkout -->
    </section>
</body>
</html>
