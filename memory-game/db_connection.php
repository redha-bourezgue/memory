<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Update with your database password
$dbname = "memory_game";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
