<?php
// db_connect.php
$servername = "localhost";
$username = "appuser";      // change if needed
$password = "AppPass123!";  // change to your password
$dbname = "hooshungry";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");
?>