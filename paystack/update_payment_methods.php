<?php
/**
 * Update Payment Methods Script
 * 
 * This script updates existing paystack_transactions records with payment method information
 * extracted from their gateway_response field.
 */

require_once __DIR__ . '/../admin/config/dbcon.php';

echo "<h1>Update Payment Methods</h1>";

/**
 * Enhanced payment method detection for M-Pesa STK
 */
function detectPaymentMethod($gatewayResponse) {
    if (!$gatewayResponse) return 'unknown';
    
    $response = json_decode($gatewayResponse, true);
    if (!$response) return 'unknown';
    
    // Method 1: Check for channel = mobile_money (most reliable for M-Pesa STK)
    if (isset($response['data']['channel'])) {
        $channel = strtolower($response['data']['channel']);
        if ($channel === 'mobile_money') {
            return 'mpesa';
        }
    }
    
    // Method 2: Check for authorization channel = mobile_money
    if (isset($response['data']['authorization']['channel'])) {
        $channel = strtolower($response['data']['authorization']['channel']);
        if ($channel === 'mobile_money') {
            return 'mpesa';
        }
    }
    
    // Method 3: Check for bank = M-PESA
    if (isset($response['data']['authorization']['bank'])) {
        $bank = strtolower($response['data']['authorization']['bank']);
        if ($bank === 'm-pesa' || $bank === 'mpesa') {
            return 'mpesa';
        }
    }
    
    // Method 4: Check for brand = M-pesa
    if (isset($response['data']['authorization']['brand'])) {
        $brand = strtolower($response['data']['authorization']['brand']);
        if ($brand === 'm-pesa' || $brand === 'mpesa') {
            return 'mpesa';
        }
    }
    
    // Method 5: Check for mobile_money_number (specific to mobile money)
    if (isset($response['data']['authorization']['mobile_money_number'])) {
        return 'mpesa';
    }
    
    // Method 6: Check for mobile_money_provider
    if (isset($response['data']['authorization']['mobile_money_provider'])) {
        $provider = strtolower($response['data']['authorization']['mobile_money_provider']);
        if ($provider === 'mpesa') {
            return 'mpesa';
        }
    }
    
    // Method 7: Check for authorization_code pattern (M-Pesa codes start with QK, QL, etc.)
    if (isset($response['data']['authorization']['authorization_code'])) {
        $authCode = $response['data']['authorization']['authorization_code'];
        if (preg_match('/^Q[KL]/', $authCode)) {
            return 'mpesa';
        }
    }
    
    // Method 8: Check for country_code (Kenya) and no card info
    if (isset($response['data']['authorization']['country_code'])) {
        $countryCode = strtolower($response['data']['authorization']['country_code']);
        if ($countryCode === 'ke') {
            // If it's Kenya and no card info, likely M-Pesa
            if (!isset($response['data']['authorization']['card_type']) && 
                !isset($response['data']['authorization']['last4'])) {
                return 'mpesa';
            }
        }
    }
    
    // Method 9: Check for account_name (M-Pesa shows phone number)
    if (isset($response['data']['authorization']['account_name'])) {
        $accountName = $response['data']['authorization']['account_name'];
        if (preg_match('/^\d{10,12}$/', $accountName)) {
            return 'mpesa';
        }
    }
    
    // Method 10: Check for gateway_response text
    if (isset($response['data']['authorization']['gateway_response'])) {
        $gatewayResponse = strtolower($response['data']['authorization']['gateway_response']);
        if (strpos($gatewayResponse, 'mpesa') !== false || 
            strpos($gatewayResponse, 'mobile money') !== false) {
            return 'mpesa';
        }
    }
    
    // Check for domain in the response
    if (isset($response['data']['domain'])) {
        $domain = strtolower($response['data']['domain']);
        switch ($domain) {
            case 'card':
                return 'card';
            case 'mobile_money':
                return 'mpesa';
            case 'bank':
                return 'bank';
            case 'ussd':
                return 'ussd';
            default:
                return $domain;
        }
    }
    
    // Check for payment_type in the response
    if (isset($response['data']['payment_type'])) {
        $paymentType = strtolower($response['data']['payment_type']);
        switch ($paymentType) {
            case 'card':
                return 'card';
            case 'mobile_money':
                return 'mpesa';
            case 'bank':
                return 'bank';
            default:
                return $paymentType;
        }
    }
    
    // Check for gateway_response in the response (nested response)
    if (isset($response['data']['gateway_response'])) {
        $gatewayResponse = strtolower($response['data']['gateway_response']);
        if (strpos($gatewayResponse, 'mpesa') !== false) {
            return 'mpesa';
        } elseif (strpos($gatewayResponse, 'card') !== false) {
            return 'card';
        } elseif (strpos($gatewayResponse, 'bank') !== false) {
            return 'bank';
        }
    }
    
    return 'unknown';
}

// First, ensure the payment_method column exists
echo "<h2>Step 1: Ensuring payment_method column exists</h2>";
$sql = "ALTER TABLE paystack_transactions ADD COLUMN IF NOT EXISTS payment_method VARCHAR(50) AFTER status";
if ($conn->query($sql)) {
    echo "✅ Payment method column exists<br>";
} else {
    echo "❌ Error creating payment_method column: " . $conn->error . "<br>";
}

// Fix currency for existing transactions
echo "<h2>Step 2: Fixing currency for existing transactions</h2>";
$sql = "UPDATE paystack_transactions SET currency = 'KES' WHERE currency = 'NGN'";
$result = $conn->query($sql);
if ($result) {
    $affected = $conn->affected_rows;
    echo "✅ Updated {$affected} transactions from NGN to KES<br>";
} else {
    echo "❌ Error updating currency: " . $conn->error . "<br>";
}

// Get all transactions that don't have payment_method set
echo "<h2>Step 3: Finding transactions to update</h2>";
$sql = "SELECT id, reference, gateway_response, payment_method FROM paystack_transactions WHERE payment_method IS NULL OR payment_method = '' OR payment_method = 'unknown'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "Found " . $result->num_rows . " transactions to update<br><br>";
    
    $updated = 0;
    $errors = 0;
    
    while ($row = $result->fetch_assoc()) {
        $paymentMethod = detectPaymentMethod($row['gateway_response']);
        
        // Update the record
        $updateSql = "UPDATE paystack_transactions SET payment_method = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $paymentMethod, $row['id']);
        
        if ($stmt->execute()) {
            echo "✅ Updated transaction {$row['reference']}: {$paymentMethod}<br>";
            $updated++;
        } else {
            echo "❌ Error updating transaction {$row['reference']}: " . $stmt->error . "<br>";
            $errors++;
        }
        
        $stmt->close();
    }
    
    echo "<br><strong>Summary:</strong><br>";
    echo "✅ Successfully updated: {$updated} transactions<br>";
    echo "❌ Errors: {$errors} transactions<br>";
    
} else {
    echo "✅ All transactions already have payment_method set or no transactions found<br>";
}

// Show current payment method distribution
echo "<h2>Step 4: Current Payment Method Distribution</h2>";
$sql = "SELECT payment_method, COUNT(*) as count FROM paystack_transactions GROUP BY payment_method ORDER BY count DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Payment Method</th><th>Count</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $method = $row['payment_method'] ?: 'Not Set';
        echo "<tr><td>{$method}</td><td>{$row['count']}</td></tr>";
    }
    
    echo "</table>";
} else {
    echo "No transactions found<br>";
}

// Show sample transactions for verification
echo "<h2>Step 5: Sample Transactions</h2>";
$sql = "SELECT reference, payment_method, LEFT(gateway_response, 200) as response_preview FROM paystack_transactions ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Reference</th><th>Payment Method</th><th>Response Preview</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $method = $row['payment_method'] ?: 'Not Set';
        $preview = htmlspecialchars(substr($row['response_preview'], 0, 100)) . '...';
        echo "<tr><td>{$row['reference']}</td><td>{$method}</td><td>{$preview}</td></tr>";
    }
    
    echo "</table>";
}

echo "<hr>";
echo "<p><small>Script completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
h2 { color: #666; margin-top: 30px; }
table { margin: 10px 0; }
th, td { padding: 8px; text-align: left; }
th { background: #f8f9fa; }
</style> 