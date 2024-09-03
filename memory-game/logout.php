<?php
session_start();

// Destroy the current session and clear all session data
session_destroy();

// Redirect to the game page or login page
header('Location: index.php'); // Adjust to your desired redirect location
exit;
?>
