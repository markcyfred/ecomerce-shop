<?php
session_start();
include_once '../admin/config/dbcon.php';
include_once '../init.php';

header('Content-Type: application/json');

try {
    $session_id = session_id();
    $user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

    // Clear the cart
    $clear_query = "DELETE FROM cart WHERE cart_status = 'unprocessed' AND (session_id = '$session_id'" . ($user_id ? " OR user_id = '$user_id'" : "") . ")";
    $result = mysqli_query($conn, $clear_query);

    if ($result) {
        // Clear all session variables
        unset($_SESSION['promo_code']);
        unset($_SESSION['discount_amount']);
        unset($_SESSION['discount_code']);
        unset($_SESSION['cart_total']);
        unset($_SESSION['cart_items']);

        // Reset session variables
        $_SESSION['cart_total'] = 0;
        $_SESSION['cart_items'] = 0;
        $_SESSION['discount_amount'] = 0;

        echo json_encode(['success' => true, 'message' => 'Cart cleared successfully']);
    } else {
        throw new Exception('Failed to clear cart');
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit; 