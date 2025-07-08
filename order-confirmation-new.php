<?php
// order-confirmation-new.php

include 'admin/config/dbcon.php';  // Database connection

// Start session if not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Retrieve the token from the URL
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token)) {
    header("Location: index.php?error=Invalid order token");
    exit();
}

// Get the current order details from the checkout table using token.
$stmt = $conn->prepare("SELECT * FROM checkout WHERE token = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

$order = $result->fetch_assoc();
$stmt->close();

// Check if order exists
if (!$order) {
    header("Location: index.php?error=Order not found");
    exit();
}

// If order is already paid, redirect to orders page with paid notification
if ($order['status'] === 'paid') {
    // Redirect to orders page with URL parameters for SweetAlert
    $message = "Order #" . htmlspecialchars($order['shipment_number']) . " has already been paid and confirmed!";
    $message_type = "success";
    
    header("Location: orders.php?message=" . urlencode($message) . "&message_type=" . urlencode($message_type));
    exit();
}

// If order is cancelled or failed, redirect to orders page with appropriate message
if ($order['status'] === 'cancelled' || $order['status'] === 'failed') {
    $message = "Order #" . htmlspecialchars($order['shipment_number']) . " was cancelled or failed. Please try again.";
    $message_type = "warning";
    
    header("Location: orders.php?message=" . urlencode($message) . "&message_type=" . urlencode($message_type));
    exit();
}

// If we reach here, the order is pending payment, so redirect to the main order confirmation page
header("Location: order-confirmation.php?token=" . urlencode($token));
exit();
?> 