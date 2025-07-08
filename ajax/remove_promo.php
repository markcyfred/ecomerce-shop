<?php
session_start();
include_once '../admin/config/dbcon.php';
include_once '../init.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Get cart total from session or default to 0
$cart_total = isset($_SESSION['cart_total']) ? floatval($_SESSION['cart_total']) : 0;

// Remove promo code from session
unset($_SESSION['promo_code']);

echo json_encode([
    'status' => 'success',
    'message' => 'Promo code removed successfully',
    'final_total' => $cart_total
]); 