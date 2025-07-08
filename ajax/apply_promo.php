<?php
session_start();
include_once '../admin/config/dbcon.php';
include_once '../init.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Log incoming request
error_log('Promo code request received: ' . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log('Invalid request method: ' . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    error_log('User not logged in');
    echo json_encode(['status' => 'error', 'message' => 'Please login to apply promo code']);
    exit;
}

$promo_code = trim($_POST['promo_code'] ?? '');
$cart_total = floatval($_POST['cart_total'] ?? 0);
$user_id = $_SESSION['auth_user']['id'];

error_log("Processing promo code: $promo_code, Cart total: $cart_total, User ID: $user_id");

if (empty($promo_code)) {
    error_log('Empty promo code provided');
    echo json_encode(['status' => 'error', 'message' => 'Please enter a promo code']);
    exit;
}

if ($cart_total <= 0) {
    error_log('Invalid cart total: ' . $cart_total);
    echo json_encode(['status' => 'error', 'message' => 'Cart total must be greater than 0']);
    exit;
}

// Check if promo code exists and is valid
$current_date = date('Y-m-d H:i:s');
error_log("Current date for comparison: " . $current_date);

// First, let's check if the promo code exists at all
$check_query = "SELECT * FROM promocodes WHERE code = ?";
$stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt, "s", $promo_code);
mysqli_stmt_execute($stmt);
$check_result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($check_result) === 0) {
    error_log("Promo code not found in database: $promo_code");
    echo json_encode(['status' => 'error', 'message' => 'Invalid promo code']);
    exit;
}

$promo = mysqli_fetch_assoc($check_result);
error_log("Found promo code in database: " . print_r($promo, true));

// Now check all validation conditions
if ($promo['status'] != 1) {
    error_log("Promo code is not active. Status: " . $promo['status']);
    echo json_encode(['status' => 'error', 'message' => 'This promo code is not active']);
    exit;
}

// Convert dates to timestamps for comparison
$current_timestamp = strtotime($current_date);
$start_timestamp = strtotime($promo['start_date']);
$end_timestamp = strtotime($promo['end_date']);

error_log("Date comparison - Current: $current_timestamp, Start: $start_timestamp, End: $end_timestamp");

if ($current_timestamp < $start_timestamp) {
    error_log("Promo code not yet started. Start date: " . $promo['start_date'] . " (timestamp: $start_timestamp)");
    echo json_encode(['status' => 'error', 'message' => 'This promo code is not yet active']);
    exit;
}

if ($current_timestamp > $end_timestamp) {
    error_log("Promo code has expired. End date: " . $promo['end_date'] . " (timestamp: $end_timestamp)");
    echo json_encode(['status' => 'error', 'message' => 'This promo code has expired']);
    exit;
}

if ($promo['usage_limit'] > 0 && $promo['usage_count'] >= $promo['usage_limit']) {
    error_log("Promo code usage limit reached. Usage: " . $promo['usage_count'] . "/" . $promo['usage_limit']);
    echo json_encode(['status' => 'error', 'message' => 'This promo code has reached its usage limit']);
    exit;
}

// Check minimum purchase requirement
if ($cart_total < $promo['min_purchase']) {
    error_log("Minimum purchase requirement not met. Required: {$promo['min_purchase']}, Cart total: $cart_total");
    echo json_encode(['status' => 'error', 'message' => 'Minimum purchase amount of Kes ' . number_format($promo['min_purchase'], 2) . ' required']);
    exit;
}

// Check if user has already used this promo code
$usage_query = "SELECT COUNT(*) as usage_count FROM promocode_usage 
                WHERE promocode_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $usage_query);
mysqli_stmt_bind_param($stmt, "ii", $promo['id'], $user_id);
mysqli_stmt_execute($stmt);
$usage_result = mysqli_stmt_get_result($stmt);
$usage_count = mysqli_fetch_assoc($usage_result)['usage_count'];
error_log("User usage count: $usage_count");

if ($usage_count > 0) {
    error_log("User has already used this promo code");
    echo json_encode(['status' => 'error', 'message' => 'You have already used this promo code']);
    exit;
}

// Calculate discount amount
$discount_amount = 0;
if ($promo['discount_type'] === 'fixed') {
    $discount_amount = min($promo['discount_value'], $promo['max_discount']);
} else { // percentage
    $discount_amount = min(($cart_total * $promo['discount_value'] / 100), $promo['max_discount']);
}
error_log("Calculated discount amount: $discount_amount");

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Record promo code usage
    $usage_insert = "INSERT INTO promocode_usage (promocode_id, user_id, discount_amount, used_at) 
                     VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $usage_insert);
    mysqli_stmt_bind_param($stmt, "iids", $promo['id'], $user_id, $discount_amount, $current_date);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Failed to record promo code usage");
    }

    // Update promo code usage count
    $update_usage = "UPDATE promocodes SET usage_count = usage_count + 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_usage);
    mysqli_stmt_bind_param($stmt, "i", $promo['id']);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Failed to update promo code usage count");
    }

    // Commit transaction
    mysqli_commit($conn);

    // Store promo code info in session
    $_SESSION['promo_code'] = [
        'id' => $promo['id'],
        'code' => $promo['code'],
        'discount_amount' => $discount_amount
    ];
    error_log("Stored promo code in session: " . print_r($_SESSION['promo_code'], true));

    // Update cart total with discount
    $final_total = $cart_total - $discount_amount;
    error_log("Final total after discount: $final_total");

    echo json_encode([
        'status' => 'success',
        'message' => 'Promo code applied successfully',
        'discount_amount' => $discount_amount,
        'final_total' => $final_total,
        'promo_code' => $promo['code']
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    error_log("Error applying promo code: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to apply promo code. Please try again.'
    ]);
} 