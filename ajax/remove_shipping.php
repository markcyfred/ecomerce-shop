<?php
session_start();
header('Content-Type: application/json');

// Remove shipping information from session
unset($_SESSION['shipping_info']);

// Get cart total for response
$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

include '../admin/config/dbcon.php';

$cart_query = "SELECT SUM(p.selling_price * c.quantity) as total_price FROM cart c 
               JOIN products p ON c.product_id = p.id 
               WHERE c.cart_status = 'unprocessed' 
               AND (c.session_id = '$session_id'" . ($user_id ? " OR c.user_id = '$user_id'" : "") . ")";

$cart_result = mysqli_query($conn, $cart_query);
$cart_row = mysqli_fetch_assoc($cart_result);
$cart_total = $cart_row['total_price'] ?? 0;

// Apply discount if exists
$discount_amount = isset($_SESSION['promo_code']['discount_amount']) ? $_SESSION['promo_code']['discount_amount'] : 0;
$final_total = $cart_total - $discount_amount;

echo json_encode([
    'status' => 'success',
    'message' => 'Shipping information removed successfully',
    'cart_total' => (float)$cart_total,
    'final_total' => (float)$final_total
]);

$conn->close();
?> 