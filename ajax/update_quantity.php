<?php
include_once '../admin/config/dbcon.php';
include_once '../init.php';

// Ensure we're sending JSON response
header('Content-Type: application/json');

// Function to send JSON response
function sendJsonResponse($status, $message, $data = []) {
    $response = array_merge([
        'status' => $status,
        'message' => $message
    ], $data);
    
    echo json_encode($response);
    exit;
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse('error', 'Invalid request method');
}

// Validate input
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

if ($product_id <= 0 || $quantity <= 0) {
    sendJsonResponse('error', 'Invalid product ID or quantity');
}

try {
    // First check if we have enough quantity in stock and respect sale_out_limit
    $check_query = "SELECT p.quantity, p.sale_out_limit FROM products p WHERE p.id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    if (!$stmt) {
        throw new Exception('Database prepare error: ' . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Database execute error: ' . mysqli_stmt_error($stmt));
    }
    
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        throw new Exception('Database result error: ' . mysqli_error($conn));
    }
    
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        sendJsonResponse('error', 'Product not found');
    }
    
    $available_quantity = $row['quantity'];
    $sale_out_limit = $row['sale_out_limit'];
    
    if ($quantity > $available_quantity) {
        sendJsonResponse('error', 'Requested quantity exceeds available stock', [
            'available_quantity' => $available_quantity
        ]);
    }
    
    if ($quantity > $sale_out_limit) {
        sendJsonResponse('error', 'Maximum allowed quantity per order is ' . $sale_out_limit, [
            'sale_out_limit' => $sale_out_limit
        ]);
    }
    
    // Update the cart quantity
    $update_query = "UPDATE cart SET quantity = ? WHERE product_id = ? AND cart_status = 'unprocessed' AND (session_id = ?" . ($user_id ? " OR user_id = ?" : "") . ")";
    $stmt = mysqli_prepare($conn, $update_query);
    if (!$stmt) {
        throw new Exception('Database prepare error: ' . mysqli_error($conn));
    }
    
    if ($user_id) {
        mysqli_stmt_bind_param($stmt, "iiss", $quantity, $product_id, $session_id, $user_id);
    } else {
        mysqli_stmt_bind_param($stmt, "iis", $quantity, $product_id, $session_id);
    }
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Database execute error: ' . mysqli_stmt_error($stmt));
    }
    
    // Recalculate cart totals with explicit table references
    $cart_query = "SELECT 
        SUM(c.quantity) as total_items, 
        SUM(c.quantity * p.selling_price) as total_price 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.cart_status = 'unprocessed' 
        AND (c.session_id = ?" . ($user_id ? " OR c.user_id = ?" : "") . ")";
    
    $stmt = mysqli_prepare($conn, $cart_query);
    if (!$stmt) {
        throw new Exception('Database prepare error: ' . mysqli_error($conn));
    }
    
    if ($user_id) {
        mysqli_stmt_bind_param($stmt, "ss", $session_id, $user_id);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $session_id);
    }
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Database execute error: ' . mysqli_stmt_error($stmt));
    }
    
    $cart_result = mysqli_stmt_get_result($stmt);
    if (!$cart_result) {
        throw new Exception('Database result error: ' . mysqli_error($conn));
    }
    
    $cart_data = mysqli_fetch_assoc($cart_result);
    
    // Update session variables
    $_SESSION['cart_items'] = $cart_data['total_items'] ?? 0;
    $_SESSION['cart_total'] = $cart_data['total_price'] ?? 0;
    
    // Send success response
    sendJsonResponse('success', 'Quantity updated successfully', [
        'available_quantity' => $available_quantity,
        'cart_total' => $_SESSION['cart_total'],
        'cart_items' => $_SESSION['cart_items']
    ]);
    
} catch (Exception $e) {
    error_log('Cart update error: ' . $e->getMessage());
    sendJsonResponse('error', 'An error occurred while updating the cart: ' . $e->getMessage());
}
?> 