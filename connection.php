<?php
// Database connection credentials
$servername = "localhost";
$username = "root";
$password = ""; // Leave blank if no password is set for MySQL
$database = "toy_store"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    //echo "Connection successful!";
}
?>
