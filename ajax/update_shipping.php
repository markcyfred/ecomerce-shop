<?php
include '../admin/config/dbcon.php';
session_start();

header('Content-Type: application/json');

if (!isset($_POST['token']) || !isset($_POST['shipping_cost'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit;
}

$token = $_POST['token'];
$shipping_cost = $_POST['shipping_cost'];

// Update the checkout table with new shipping cost
$stmt = $conn->prepare("UPDATE checkout SET 
    shipping_cost = ?,
    total_amount = cart_subtotal + ? 
    WHERE token = ?");

$stmt->bind_param("dds", $shipping_cost, $shipping_cost, $token);

if ($stmt->execute()) {
    // Get the updated total
    $stmt = $conn->prepare("SELECT total_amount FROM checkout WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    echo json_encode([
        'status' => 'success',
        'final_total' => $row['total_amount']
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update shipping cost']);
}

$stmt->close();
$conn->close();
?> 