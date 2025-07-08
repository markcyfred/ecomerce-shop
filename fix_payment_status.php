<?php
/**
 * Fix Payment Status Script
 * 
 * This script fixes orders that have successful payments but unpaid status
 */

include 'admin/config/dbcon.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    echo "Please login first to fix payment status.";
    exit();
}

$user_id = $_SESSION['auth_user']['id'];

echo "<h2>Payment Status Fix Results</h2>";

// Find orders with successful payments but unpaid status
$stmt = $conn->prepare("
    SELECT c.id, c.token, c.status as order_status, 
           pt.status as payment_status, pt.reference, pt.amount
    FROM checkout c
    LEFT JOIN paystack_transactions pt ON c.id = pt.order_id 
    WHERE c.user_id = ? 
    AND pt.status = 'success' 
    AND c.status != 'paid'
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<p><strong>Found " . $result->num_rows . " orders with successful payments but unpaid status:</strong></p>";
    
    $fixed_count = 0;
    
    while ($row = $result->fetch_assoc()) {
        echo "<p>Fixing order ID: " . $row['id'] . " (Token: " . $row['token'] . ")</p>";
        
        // Update the order status to paid
        $update_stmt = $conn->prepare("UPDATE checkout SET status = 'paid' WHERE id = ?");
        $update_stmt->bind_param("i", $row['id']);
        $update_result = $update_stmt->execute();
        $update_stmt->close();
        
        if ($update_result) {
            echo "<p style='color: green;'>✓ Successfully updated order " . $row['id'] . " to paid status</p>";
            $fixed_count++;
        } else {
            echo "<p style='color: red;'>✗ Failed to update order " . $row['id'] . "</p>";
        }
    }
    
    echo "<h3>Summary</h3>";
    echo "<p>Fixed " . $fixed_count . " out of " . $result->num_rows . " orders.</p>";
    
} else {
    echo "<p style='color: green;'>No orders found with mismatched payment status.</p>";
}
$stmt->close();

// Also check for any orders with 'paid' status but no successful payment record
echo "<h3>Checking for orders with paid status but no payment record</h3>";
$stmt = $conn->prepare("
    SELECT c.id, c.token, c.status as order_status, 
           pt.status as payment_status
    FROM checkout c
    LEFT JOIN paystack_transactions pt ON c.id = pt.order_id 
    WHERE c.user_id = ? 
    AND c.status = 'paid' 
    AND (pt.status IS NULL OR pt.status != 'success')
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<p style='color: orange;'><strong>Found " . $result->num_rows . " orders with paid status but no successful payment record:</strong></p>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Order ID</th><th>Token</th><th>Order Status</th><th>Payment Status</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['token']) . "</td>";
        echo "<td>" . htmlspecialchars($row['order_status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_status'] ?? 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p><em>These orders may need manual verification.</em></p>";
} else {
    echo "<p style='color: green;'>All paid orders have corresponding payment records.</p>";
}
$stmt->close();

echo "<h3>Database Cleanup</h3>";

// Clean up any abandoned transactions older than 24 hours
$cleanup_stmt = $conn->prepare("
    DELETE FROM paystack_transactions 
    WHERE status = 'pending' 
    AND created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR)
");
$cleanup_stmt->execute();
$cleaned_count = $cleanup_stmt->affected_rows;
$cleanup_stmt->close();

echo "<p>Cleaned up " . $cleaned_count . " abandoned transactions older than 24 hours.</p>";

echo "<p><a href='orders.php'>Back to Orders</a> | <a href='test_payment_flow.php'>Test Payment Flow</a></p>";
?> 