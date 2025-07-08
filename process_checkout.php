<?php
// Prevent any output before JSON response
ob_start();

// Set proper headers
header('Content-Type: application/json');

// Start session and include files
session_start();
include_once 'admin/config/dbcon.php';
include_once 'init.php';

// Function to generate unique tokens
function generateUniqueToken($prefix = '') {
    $token = $prefix . '_' . uniqid() . '_' . bin2hex(random_bytes(16));
    return $token;
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Log the start of the process
error_log("Starting checkout process");

// Function to send JSON response
function sendJsonResponse($status, $message, $data = []) {
    ob_clean(); // Clear any output
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    error_log("User not logged in");
    sendJsonResponse('error', 'Please login to proceed with checkout');
}

// Get user data
$user_id = $_SESSION['auth_user']['id'];
$session_id = session_id();
error_log("Processing checkout for user_id: $user_id, session_id: $session_id");

// Get cart data using existing cart table fields
$cart_query = "SELECT * FROM cart 
               WHERE cart_status = 'unprocessed' 
               AND (session_id = ? OR user_id = ?)";
               
try {
    $stmt = mysqli_prepare($conn, $cart_query);
    if (!$stmt) {
        throw new Exception("Database error: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "si", $session_id, $user_id);
    mysqli_stmt_execute($stmt);
    $cart_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($cart_result) === 0) {
        error_log("No unprocessed cart items found");
        sendJsonResponse('error', 'Your cart is empty');
    }

    // Calculate totals
    $cart_subtotal = 0;
    $shipping_cost = 0;
    $cart_items = [];

    while ($item = mysqli_fetch_assoc($cart_result)) {
        $cart_subtotal += ($item['selling_price'] * $item['quantity']);
        $cart_items[] = $item;
    }

    error_log("Cart subtotal: $cart_subtotal");

    // Get shipping information from session
    $shipping_info = isset($_SESSION['shipping_info']) ? $_SESSION['shipping_info'] : null;
    if ($shipping_info) {
        $shipping_cost = $shipping_info['shipping_cost'];
        $destination = $shipping_info['destination'];
        $state = isset($_SESSION['shipping_info']['state']) ? $_SESSION['shipping_info']['state'] : '';
        $postcode = isset($_SESSION['shipping_info']['postcode']) ? $_SESSION['shipping_info']['postcode'] : '';
        $user_lat = $shipping_info['lat'];
        $user_lng = $shipping_info['lng'];
        $destination_lat = $shipping_info['lat'];
        $destination_lng = $shipping_info['lng'];
        $distance = $shipping_info['distance'];
        $precise_location_name = isset($shipping_info['precise_location_name']) ? $shipping_info['precise_location_name'] : '';
        $location_method = isset($shipping_info['location_method']) ? $shipping_info['location_method'] : '';
        
        // Debug: Log the precise location name
        error_log("Precise location name from session: " . $precise_location_name);
        error_log("Shipping info: " . print_r($shipping_info, true));
        error_log("Precise location name length: " . strlen($precise_location_name));
        error_log("Precise location name type: " . gettype($precise_location_name));
        error_log("Full session data: " . print_r($_SESSION, true));
    } else {
        $destination = '';
        $state = '';
        $postcode = '';
        $user_lat = null;
        $user_lng = null;
        $destination_lat = null;
        $destination_lng = null;
        $distance = 0;
        $precise_location_name = '';
        $location_method = '';
        error_log("No shipping info in session");
    }

    // Apply discount if promo code exists
    $discount_amount = isset($_SESSION['promo_code']['discount_amount']) ? $_SESSION['promo_code']['discount_amount'] : 0;
    $total_amount = $cart_subtotal + $shipping_cost - $discount_amount;

    error_log("Total amount after discount: $total_amount");

    // Generate unique shipment number
    $shipment_number = 'SH' . date('Ymd') . strtoupper(substr(uniqid(), -6));
    error_log("Generated shipment number: $shipment_number");

    // Generate unique checkout token
    $checkout_token = generateUniqueToken('ord');
    error_log("Generated checkout token: $checkout_token");

    // Start transaction
    mysqli_begin_transaction($conn);

    // Insert into checkout table with token and precise location name
    $checkout_query = "INSERT INTO checkout (
        token,
        user_id, 
        session_id, 
        shipment_number, 
        cart_subtotal, 
        shipping_cost, 
        total_amount,
        discount,
        destination,
        state,
        postcode,
        user_lat,
        user_lng,
        destination_lat,
        destination_lng,
        precise_location_name,
        location_method,
        distance,
        status,
        created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
    
    $stmt = mysqli_prepare($conn, $checkout_query);
    if (!$stmt) {
        throw new Exception("Failed to prepare checkout query: " . mysqli_error($conn));
    }
    
    // Use the correct bind string and parameters (18 parameters)
    mysqli_stmt_bind_param($stmt, "sissddddsssddddssd", 
        $checkout_token,    // 1. token (s)
        $user_id,           // 2. user_id (i)
        $session_id,        // 3. session_id (s)
        $shipment_number,   // 4. shipment_number (s)
        $cart_subtotal,     // 5. cart_subtotal (d)
        $shipping_cost,     // 6. shipping_cost (d)
        $total_amount,      // 7. total_amount (d)
        $discount_amount,   // 8. discount (d)
        $destination,       // 9. destination (s)
        $state,            // 10. state (s)
        $postcode,         // 11. postcode (s)
        $user_lat,         // 12. user_lat (d)
        $user_lng,         // 13. user_lng (d)
        $destination_lat,  // 14. destination_lat (d)
        $destination_lng,  // 15. destination_lng (d)
        $precise_location_name,  // 16. precise_location_name (s)
        $location_method,  // 17. location_method (s)
        $distance          // 18. distance (d)
    );
    
    // Debug: Log what's being inserted
    error_log("About to insert precise_location_name: '$precise_location_name'");
    error_log("Precise location name before insert - length: " . strlen($precise_location_name));
    error_log("Precise location name before insert - type: " . gettype($precise_location_name));
    error_log("Precise location name before insert - value: " . var_export($precise_location_name, true));
    
    // Debug: Log all parameters being bound
    error_log("All parameters being bound:");
    error_log("1. token: $checkout_token");
    error_log("2. user_id: $user_id");
    error_log("3. session_id: $session_id");
    error_log("4. shipment_number: $shipment_number");
    error_log("5. cart_subtotal: $cart_subtotal");
    error_log("6. shipping_cost: $shipping_cost");
    error_log("7. total_amount: $total_amount");
    error_log("8. discount_amount: $discount_amount");
    error_log("9. destination: $destination");
    error_log("10. state: $state");
    error_log("11. postcode: $postcode");
    error_log("12. user_lat: $user_lat");
    error_log("13. user_lng: $user_lng");
    error_log("14. destination_lat: $destination_lat");
    error_log("15. destination_lng: $destination_lng");
    error_log("16. precise_location_name: '$precise_location_name'");
    error_log("17. location_method: '$location_method'");
    error_log("18. distance: $distance");
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Failed to create checkout record: " . mysqli_stmt_error($stmt));
    }
    
    // Debug: Check for any MySQL warnings or errors
    $mysql_error = mysqli_error($conn);
    if ($mysql_error) {
        error_log("MySQL error after insert: " . $mysql_error);
    }
    
    $mysql_warning_count = mysqli_warning_count($conn);
    if ($mysql_warning_count > 0) {
        error_log("MySQL warnings after insert: " . $mysql_warning_count);
    }
    
    $checkout_id = mysqli_insert_id($conn);
    error_log("Created checkout record with ID: $checkout_id");
    
    // Update cart items status to processed and link to checkout using token
    $update_cart = "UPDATE cart 
                   SET cart_status = 'processed',
                       checkout_token = ?,
                       updated_at = CURRENT_TIMESTAMP
                   WHERE cart_status = 'unprocessed' 
                   AND (session_id = ? OR user_id = ?)";
    
    $stmt = mysqli_prepare($conn, $update_cart);
    if (!$stmt) {
        throw new Exception("Failed to prepare cart update query: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "sss", $checkout_token, $session_id, $user_id);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Failed to update cart items: " . mysqli_stmt_error($stmt));
    }
    
    $affected_rows = mysqli_stmt_affected_rows($stmt);
    error_log("Updated $affected_rows cart items to processed status");
    
    // If promo code was used, update its usage
    if (isset($_SESSION['promo_code'])) {
        $promo_id = $_SESSION['promo_code']['id'];
        $update_promo = "UPDATE promocodes 
                        SET usage_count = usage_count + 1 
                        WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $update_promo);
        if (!$stmt) {
            throw new Exception("Failed to prepare promo update query: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "i", $promo_id);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Failed to update promo code usage: " . mysqli_stmt_error($stmt));
        }
        
        error_log("Updated promo code usage for ID: $promo_id");
    }
    
    // Commit transaction
    mysqli_commit($conn);
    error_log("Transaction committed successfully");
    
    // Clear promo code from session
    unset($_SESSION['promo_code']);
    
    // Clear shipping info from session
    unset($_SESSION['shipping_info']);
    
    // Set order_id in session
    $_SESSION['order_id'] = $checkout_id;
    
    // Return success response with correct file name
    sendJsonResponse('success', 'Checkout processed successfully', [
        'checkout_id' => $checkout_id,
        'checkout_token' => $checkout_token,
        'shipment_number' => $shipment_number,
        'redirect' => 'order-confirmation.php?token=' . $checkout_token
    ]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($conn) && mysqli_ping($conn)) {
        mysqli_rollback($conn);
    }
    
    error_log("Checkout Error: " . $e->getMessage());
    sendJsonResponse('error', 'Failed to process checkout: ' . $e->getMessage());
} 