<?php
include 'connection.php';  
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy Store - Home</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style for the pop-up ad */
        .popup-ad {
            position: fixed;
            right: 50px;
            bottom: 500px; 
            width: 250px; 
            background-color: #f9f9f9;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
            padding: 15px;
            z-index: 1000; 
            display: none; 
        }

        .popup-ad img {
            width: 100%;
            height: auto;
        }

        .popup-ad .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header style="padding: 20px;"> 
        <div class="logo">
            <img src="images/logo2.png" alt="Toy Store Logo">
        </div>
        <nav>
            <a href="index.php">Home</a>
            <?php if (isset($_SESSION['username'])): ?>
                <div class="user-info" style="float: right;">
                    <span>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <a href="logout.php">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
            <a href="cart.php">View Cart</a>
        </nav>
    </header>

    <!-- Main Section -->
    <section>
        <h2>Featured Toys</h2>
        <div class="product-grid">
            <?php
            $query = "SELECT * FROM products ORDER BY created_at DESC"; 
            $result = $conn->query($query);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <div class="product-item">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-img">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><?php echo number_format($row['price'], 2); ?> USD</p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Details</a>
                </div>
            <?php
                endwhile;
            else:
                echo "<p>No products available.</p>";
            endif;
            ?>
        </div>
    </section>

    <!-- Pop-up Ad Section -->
    <div class="popup-ad" id="popupAd">
        <span class="close-btn" id="closeAd">&times;</span>
        <img src="images/ad.jpg" alt="Advertisement">
        <p>Check out our special offers!</p>
        <a href="special-offers.php" class="btn">See Offers</a>
    </div>

    <!-- Footer Section -->
    <footer>
        <div class="footer-copyright">
            <p>&copy; 2024 Wonder Land. All rights reserved | Bringing Joy to Every Child | BY SUBODHA BANDARA</p>
        </div>
        <div class="footer-social">
            <a href="https://web.facebook.com/subodha.bandara.1/" target="_blank">
                <img src="images/fb.png" alt="Facebook">
            </a>
            <a href="https://instagram.com" target="_blank">
                <img src="images/Insta.png" alt="Instagram">
            </a>
            <a href="number.html" target="_blank">
                <img src="images/wp.png" alt="WhatsApp">
            </a>
        </div>
    </footer>

    <!-- JavaScript for Pop-up Ad -->
    <script>
        
        setTimeout(function() {
            document.getElementById('popupAd').style.display = 'block';
        }, 1000); 

        // Close the pop-up ad when the close button is clicked
        document.getElementById('closeAd').onclick = function() {
            document.getElementById('popupAd').style.display = 'none';
        };
//JavaScript for hidden header
        let lastScrollTop = 0;
        const header = document.querySelector('header');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scroll Down
                header.style.top = '-100px'; 
            } else {
                // Scroll Up
                header.style.top = '0';
            }

            lastScrollTop = scrollTop;
        });
    </script>
</body>
</html>
