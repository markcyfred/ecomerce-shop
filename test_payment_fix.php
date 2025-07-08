<?php
/**
 * Test Payment Fix
 * 
 * This script tests the payment verification and database update process
 */

require_once 'admin/config/dbcon.php';
require_once 'paystack/PaystackHelper.php';

// Start session
session_start();

echo "<h1>Payment Flow Test</h1>";

// Test 1: Check database connection
echo "<h2>1. Database Connection Test</h2>";
if ($conn) {
    echo "✅ Database connection successful<br>";
} else {
    echo "❌ Database connection failed<br>";
    exit();
}

// Test 2: Check if paystack_transactions table exists
echo "<h2>2. Paystack Transactions Table Test</h2>";
$result = $conn->query("SHOW TABLES LIKE 'paystack_transactions'");
if ($result && $result->num_rows > 0) {
    echo "✅ paystack_transactions table exists<br>";
    
    // Check table structure
    $result = $conn->query("DESCRIBE paystack_transactions");
    echo "<h3>Table Structure:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "❌ paystack_transactions table does not exist<br>";
}

// Test 3: Check checkout table structure
echo "<h2>3. Checkout Table Test</h2>";
$result = $conn->query("SHOW TABLES LIKE 'checkout'");
if ($result && $result->num_rows > 0) {
    echo "✅ checkout table exists<br>";
    
    // Check if status column exists
    $result = $conn->query("SHOW COLUMNS FROM checkout LIKE 'status'");
    if ($result && $result->num_rows > 0) {
        echo "✅ status column exists in checkout table<br>";
    } else {
        echo "❌ status column does not exist in checkout table<br>";
    }
    
    // Check if token column exists
    $result = $conn->query("SHOW COLUMNS FROM checkout LIKE 'token'");
    if ($result && $result->num_rows > 0) {
        echo "✅ token column exists in checkout table<br>";
    } else {
        echo "❌ token column does not exist in checkout table<br>";
    }
} else {
    echo "❌ checkout table does not exist<br>";
}

// Test 4: Check recent orders
echo "<h2>4. Recent Orders Test</h2>";
$sql = "SELECT id, token, status, total_amount, created_at FROM checkout ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Token</th><th>Status</th><th>Amount</th><th>Created</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['token']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>KES " . number_format($row['total_amount'], 2) . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No orders found<br>";
}

// Test 5: Check recent paystack transactions
echo "<h2>5. Recent Paystack Transactions Test</h2>";
$sql = "SELECT id, reference, order_id, user_id, amount, status, payment_method, created_at FROM paystack_transactions ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Reference</th><th>Order ID</th><th>User ID</th><th>Amount</th><th>Status</th><th>Payment Method</th><th>Created</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['reference']) . "</td>";
        echo "<td>" . $row['order_id'] . "</td>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>KES " . number_format($row['amount'], 2) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['payment_method']) . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No paystack transactions found<br>";
}

// Test 6: Test PaystackHelper initialization
echo "<h2>6. PaystackHelper Test</h2>";
try {
    $paystack = new PaystackHelper($conn);
    echo "✅ PaystackHelper initialized successfully<br>";
    
    $publicKey = $paystack->getPublicKey();
    if ($publicKey) {
        echo "✅ Public key retrieved: " . substr($publicKey, 0, 20) . "...<br>";
    } else {
        echo "❌ Failed to get public key<br>";
    }
} catch (Exception $e) {
    echo "❌ PaystackHelper initialization failed: " . $e->getMessage() . "<br>";
}

// Test 7: Test session data simulation
echo "<h2>7. Session Data Test</h2>";
if (isset($_SESSION['inline_payment_data'])) {
    echo "✅ Session data exists:<br>";
    echo "<pre>" . print_r($_SESSION['inline_payment_data'], true) . "</pre>";
} else {
    echo "❌ No session data found<br>";
    
    // Simulate session data for testing
    $_SESSION['inline_payment_data'] = [
        'order_id' => 1,
        'user_id' => 1,
        'checkout_token' => 'test_token',
        'email' => 'test@example.com',
        'customer_name' => 'Test User',
        'total_amount' => 100.00,
        'shipment_number' => 'TEST123',
        'reference' => 'PS_' . time() . '_test'
    ];
    echo "✅ Created test session data<br>";
}

// Test 8: Test database update simulation
echo "<h2>8. Database Update Test</h2>";
$testOrderId = 1; // Use a test order ID
$testReference = 'PS_' . time() . '_test';

// Test order status update
$updateSql = "UPDATE checkout SET status = 'paid' WHERE id = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("i", $testOrderId);
$updateResult = $updateStmt->execute();
$updateStmt->close();

if ($updateResult) {
    echo "✅ Order status update test successful<br>";
} else {
    echo "❌ Order status update test failed: " . $conn->error . "<br>";
}

// Test transaction insert
$insertSql = "INSERT INTO paystack_transactions 
             (reference, order_id, user_id, amount, currency, status, payment_method, gateway_response, paid_at) 
             VALUES (?, ?, ?, ?, 'KES', 'success', ?, ?, NOW())";

$insertStmt = $conn->prepare($insertSql);
$testAmount = 100.00;
$testPaymentMethod = 'test';
$testGatewayResponse = json_encode(['test' => 'data']);
$insertStmt->bind_param("siidss", $testReference, $testOrderId, 1, $testAmount, $testPaymentMethod, $testGatewayResponse);
$insertResult = $insertStmt->execute();
$insertStmt->close();

if ($insertResult) {
    echo "✅ Transaction insert test successful<br>";
} else {
    echo "❌ Transaction insert test failed: " . $conn->error . "<br>";
}

echo "<hr>";
echo "<p><strong>Test completed at: " . date('Y-m-d H:i:s') . "</strong></p>";
echo "<p><a href='order-confirmation.php?token=test'>Test Payment Page</a></p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
h2 { color: #666; margin-top: 30px; }
h3 { color: #888; margin-top: 20px; }
table { margin: 10px 0; border-collapse: collapse; }
th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
th { background: #f8f9fa; font-weight: bold; }
pre { background: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto; }
</style> 