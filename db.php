<?php
$servername = "localhost";
$username = "root";  // Default username for MySQL in XAMPP
$password = "";      // Leave this blank if there is no password for root in XAMPP
$database = "practice_db";  // The name of the database you created in phpMyAdmin

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
