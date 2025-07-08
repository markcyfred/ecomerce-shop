<?php
/**
 * Payment Flow Test Script
 * 
 * This script tests the payment flow and status updates
 */

include 'admin/config/dbcon.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    echo "Please login first to test payment flow.";
    exit();
}

$user_id = $_SESSION['auth_user']['id'];

echo "<h2>Payment Flow Test Results</h2>";

// Test 1: Check recent orders and their payment status
echo "<h3>1. Recent Orders and Payment Status</h3>";
$stmt = $conn->prepare("
    SELECT c.*, 
           pt.reference as payment_reference,
           pt.status as payment_status,
           pt.amount as payment_amount,
           pt.created_at as payment_date
    FROM checkout c
    LEFT JOIN paystack_transactions pt ON c.id = pt.order_id 
    WHERE c.user_id = ?
    ORDER BY c.created_at DESC
    LIMIT 5
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Order ID</th><th>Token</th><th>Status</th><th>Amount</th><th>Payment Ref</th><th>Payment Status</th><th>Payment Date</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['token']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>KES " . number_format($row['total_amount'], 2) . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_reference'] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_status'] ?? 'N/A') . "</td>";
        echo "<td>" . ($row['payment_date'] ? date('Y-m-d H:i:s', strtotime($row['payment_date'])) : 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No orders found for this user.</p>";
}
$stmt->close();

// Test 2: Check Paystack transactions table
echo "<h3>2. Paystack Transactions</h3>";
$stmt = $conn->prepare("
    SELECT * FROM paystack_transactions 
    WHERE user_id = ? 
    ORDER BY created_at DESC 
    LIMIT 5
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Reference</th><th>Order ID</th><th>Amount</th><th>Status</th><th>Payment Method</th><th>Created At</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['reference']) . "</td>";
        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
        echo "<td>KES " . number_format($row['amount'], 2) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_method']) . "</td>";
        echo "<td>" . date('Y-m-d H:i:s', strtotime($row['created_at'])) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No Paystack transactions found for this user.</p>";
}
$stmt->close();

// Test 3: Check session data
echo "<h3>3. Session Data</h3>";
echo "<p><strong>Inline Payment Data:</strong></p>";
if (isset($_SESSION['inline_payment_data'])) {
    echo "<pre>" . print_r($_SESSION['inline_payment_data'], true) . "</pre>";
} else {
    echo "<p>No inline payment data in session.</p>";
}

echo "<p><strong>Paystack Pending Transactions:</strong></p>";
if (isset($_SESSION['paystack_pending_transactions'])) {
    echo "<pre>" . print_r($_SESSION['paystack_pending_transactions'], true) . "</pre>";
} else {
    echo "<p>No pending transactions in session.</p>";
}

// Test 4: Check for any orders with mismatched status
echo "<h3>4. Status Mismatch Check</h3>";
$stmt = $conn->prepare("
    SELECT c.id, c.token, c.status as order_status, 
           pt.status as payment_status, pt.reference
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
    echo "<p style='color: red;'><strong>Found orders with successful payments but unpaid status:</strong></p>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Order ID</th><th>Token</th><th>Order Status</th><th>Payment Status</th><th>Reference</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['token']) . "</td>";
        echo "<td>" . htmlspecialchars($row['order_status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['reference']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: green;'>No status mismatches found.</p>";
}
$stmt->close();

// Test 5: Database table structure check
echo "<h3>5. Database Table Structure</h3>";

// Check checkout table
$result = $conn->query("DESCRIBE checkout");
if ($result) {
    echo "<p><strong>Checkout table columns:</strong></p>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['Field'] . " - " . $row['Type'] . "</li>";
    }
    echo "</ul>";
}

// Check paystack_transactions table
$result = $conn->query("DESCRIBE paystack_transactions");
if ($result) {
    echo "<p><strong>Paystack transactions table columns:</strong></p>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['Field'] . " - " . $row['Type'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: red;'>Paystack transactions table does not exist!</p>";
}

echo "<h3>6. Recommendations</h3>";
echo "<ul>";
echo "<li>Ensure all payment callbacks are properly handled</li>";
echo "<li>Verify that session data is being stored correctly</li>";
echo "<li>Check that the PaystackHelper is updating order status properly</li>";
echo "<li>Monitor payment logs for any errors</li>";
echo "</ul>";

echo "<p><a href='orders.php'>Back to Orders</a></p>";
?> 