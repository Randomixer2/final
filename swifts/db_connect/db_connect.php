<?php
$servername = "localhost";
$username = "your_db_username"; // Update with your database username
$password = "your_db_password"; // Update with your database password
$dbname = "project_webapp"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
