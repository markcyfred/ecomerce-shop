<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Log the request
error_log("Cart removal request received: " . print_r($_POST, true));

// Include database connection
require_once '../admin/config/dbcon.php';

// Set header to return JSON
header('Content-Type: application/json');

// Initialize response array
$response = array(
    'success' => false,
    'message' => '',
    'total_items' => 0,
    'total_price' => 0
);

// Check if cart_id is provided
if (!isset($_POST['cart_id']) || empty($_POST['cart_id'])) {
    $response['message'] = 'Invalid cart item ID';
    echo json_encode($response);
    exit;
}

$cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

// Build the WHERE clause based on user authentication
$where_clause = "id = '$cart_id' AND (session_id = '$session_id'";
if ($user_id) {
    $where_clause .= " OR user_id = '$user_id'";
}
$where_clause .= ")";

// Delete the cart item
$delete_query = "DELETE FROM cart WHERE $where_clause";
$delete_result = mysqli_query($conn, $delete_query);

if ($delete_result) {
    // Get updated cart totals
    $cart_query = "
        SELECT 
            COUNT(*) as total_items,
            SUM(selling_price * quantity) as total_price
        FROM cart 
        WHERE cart_status = 'unprocessed' 
        AND (
            session_id = '$session_id'
            " . ($user_id ? " OR user_id = '$user_id'" : "") . "
        )
    ";
    
    $cart_result = mysqli_query($conn, $cart_query);
    if ($cart_result) {
        $cart_data = mysqli_fetch_assoc($cart_result);
        $response['success'] = true;
        $response['message'] = 'Item removed successfully';
        $response['total_items'] = $cart_data['total_items'] ?? 0;
        $response['total_price'] = number_format($cart_data['total_price'] ?? 0, 2);
    }
} else {
    $response['message'] = 'Failed to remove item from cart';
}

// Return JSON response
echo json_encode($response);
exit;
?> 