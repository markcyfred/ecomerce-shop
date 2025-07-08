<?php
// Simple test version of orders page
echo "Orders page test<br>";

// Test database connection
include 'admin/config/dbcon.php';
if ($conn) {
    echo "Database connection: OK<br>";
} else {
    echo "Database connection: FAILED<br>";
}

// Test session
session_start();
if (isset($_SESSION['auth_user']['id'])) {
    echo "User logged in: " . $_SESSION['auth_user']['id'] . "<br>";
} else {
    echo "User not logged in<br>";
}

echo "PHP is working correctly!";
?> 