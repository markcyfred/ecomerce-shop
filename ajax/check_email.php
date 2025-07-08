<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON
header('Content-Type: application/json');

// Include database connection
include '../admin/config/dbcon.php';

// Check if email is provided
if (!isset($_POST['email']) || empty($_POST['email'])) {
    echo json_encode(['error' => 'Email is required']);
    exit;
}

$email = mysqli_real_escape_string($conn, $_POST['email']);

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Invalid email format']);
    exit;
}

// Check if email exists in database
$check_email_query = "SELECT id FROM users WHERE email = '$email'";
$check_email_result = mysqli_query($conn, $check_email_query);

if (!$check_email_result) {
    echo json_encode(['error' => 'Database error']);
    exit;
}

$email_exists = mysqli_num_rows($check_email_result) > 0;

// Return JSON response
echo json_encode([
    'available' => !$email_exists,
    'email' => $email,
    'message' => $email_exists ? 'Email is already registered' : 'Email is available'
]);
?> 