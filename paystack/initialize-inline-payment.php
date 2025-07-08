<?php
/**
 * Initialize Inline Payment
 * 
 * This file handles initialization of inline Paystack payments and stores session data
 */

session_start();
require_once __DIR__ . '/../admin/config/dbcon.php';
require_once __DIR__ . '/PaystackHelper.php';

// Set JSON response header
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User not authenticated'
    ]);
    exit();
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit();
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$order_token = $input['order_token'] ?? '';

if (empty($order_token)) {
    echo json_encode([
        'success' => false,
        'message' => 'No order token provided'
    ]);
    exit();
}

try {
    // Get order details
    $stmt = $conn->prepare("SELECT * FROM checkout WHERE token = ? AND user_id = ?");
    $stmt->bind_param("si", $order_token, $_SESSION['auth_user']['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
    
    if (!$order) {
        echo json_encode([
            'success' => false,
            'message' => 'Order not found'
        ]);
        exit();
    }
    
    // Check if order is already paid
    if ($order['status'] === 'paid') {
        echo json_encode([
            'success' => false,
            'message' => 'Order has already been paid'
        ]);
        exit();
    }
    
    // Prepare order data for Paystack
    $orderData = [
        'order_id' => $order['id'],
        'user_id' => $_SESSION['auth_user']['id'],
        'total_amount' => $order['total_amount'],
        'checkout_token' => $order['token'],
        'reference' => 'PAY_' . time() . '_' . $order['token'],
        'email' => $_SESSION['auth_user']['email'] ?? '',
        'metadata' => [
            'order_id' => $order['id'],
            'user_id' => $_SESSION['auth_user']['id'],
            'checkout_token' => $order['token']
        ]
    ];
    
    // Store order data in session for verification
    $_SESSION['inline_payment_data'] = $orderData;
    
    // Initialize Paystack helper
    $paystack = new PaystackHelper($conn);
    
    // Initialize the transaction
    $initialization = $paystack->initializeTransaction($orderData);
    
    if ($initialization['status']) {
        echo json_encode([
            'success' => true,
            'authorization_url' => $initialization['authorization_url'],
            'reference' => $orderData['reference']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $initialization['message'] ?? 'Failed to initialize payment'
        ]);
    }
    
} catch (Exception $e) {
    // Log error
    error_log("Inline payment initialization error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while initializing the payment'
    ]);
}
?> 