<?php
include 'connection.php'; // Include your database connection
$id = $_GET['id'];
$query = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($query);
$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Toy Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <a href="index.php">Home</a>
    </header>
    <!-- Product Details Section -->
    <div class="product-details-box">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img">
        <div class="product-info">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
            <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" class="add-to-cart-btn">Add to Cart</a>
        </div>
    </div>

    <!-- Slideshow Section -->
    <section class="slideshow-container">
        <div class="mySlides fade">
            <img src="ad1.jpg" alt="Ad 1">
        </div>

        <div class="mySlides fade">
            <img src="ad2.jpg" alt="Ad 2">
        </div>

        <div class="mySlides fade">
            <img src="ad3.jpg" alt="Ad 3">
        </div>
    </section>

    <!-- JavaScript for Auto Slideshow -->
    <script>
        let slideIndex = 0;
        autoShowSlides();

        function autoShowSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1 }    
            slides[slideIndex - 1].style.display = "block";  
            setTimeout(autoShowSlides, 3000); // Change image every 3 seconds
        }
    </script>
</body>
</html>
