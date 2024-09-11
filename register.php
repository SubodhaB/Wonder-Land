<?php
session_start(); // Start the session

$conn = new mysqli('localhost', 'root', '', 'toy_store');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash password
        $email = $conn->real_escape_string($_POST['email']);
        
        $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        
        if ($conn->query($query)) {
            $_SESSION['message'] = ['text' => "Registration successful!", 'type' => 'success'];
            header("Location: register.php"); // Redirect to the same page to avoid resubmission
            exit();
        } else {
            $_SESSION['message'] = ['text' => "Error: " . $conn->error, 'type' => 'error'];
        }
    } else {
        $_SESSION['message'] = ['text' => "Please fill out all fields.", 'type' => 'error'];
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Toy Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <a href="index.php">Home</a>
    </header>
    <section>
        <h1>Register</h1>
        <?php
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            echo '<div class="message ' . $message['type'] . '" id="message">' . $message['text'] . '</div>';
            unset($_SESSION['message']); // Clear the message after displaying
        }
        ?>
        <form action="register.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <button type="submit">Register</button>
        </form>
    </section>
    <script>
        // Show the message if there is one
        document.addEventListener('DOMContentLoaded', function () {
            var messageElement = document.getElementById('message');
            if (messageElement) {
                messageElement.style.display = 'block';
                // Hide the message after 5 seconds
                setTimeout(function () {
                    messageElement.style.opacity = 0;
                    setTimeout(function () {
                        messageElement.style.display = 'none';
                    }, 500); // Match this with the transition duration
                }, 5000);
            }
        });
    </script>
</body>
</html>
