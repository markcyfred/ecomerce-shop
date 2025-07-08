<?php
include 'admin/config/dbcon.php';

$reference = 'PS_1751107669_ord_685fc7f71c1ad_48a1bd57cc1341814bbdb354a2e6fdea';

echo "<h1>Simple Test</h1>";

$stmt = $conn->prepare("SELECT gateway_response FROM paystack_transactions WHERE reference = ?");
$stmt->bind_param("s", $reference);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();
$stmt->close();

if ($transaction) {
    echo "<h3>Raw Gateway Response:</h3>";
    echo "<pre>" . htmlspecialchars($transaction['gateway_response']) . "</pre>";
    
    $response = json_decode(html_entity_decode($transaction['gateway_response']), true);
    
    echo "<h3>JSON Decode Result:</h3>";
    if ($response) {
        echo "<p style='color: green;'>✅ JSON decoded successfully</p>";
        
        echo "<h3>Key Fields:</h3>";
        echo "<ul>";
        echo "<li><strong>data.channel:</strong> " . ($response['data']['channel'] ?? 'NOT FOUND') . "</li>";
        echo "<li><strong>data.authorization.channel:</strong> " . ($response['data']['authorization']['channel'] ?? 'NOT FOUND') . "</li>";
        echo "<li><strong>data.authorization.bank:</strong> " . ($response['data']['authorization']['bank'] ?? 'NOT FOUND') . "</li>";
        echo "<li><strong>data.authorization.brand:</strong> " . ($response['data']['authorization']['brand'] ?? 'NOT FOUND') . "</li>";
        echo "<li><strong>data.authorization.mobile_money_number:</strong> " . ($response['data']['authorization']['mobile_money_number'] ?? 'NOT FOUND') . "</li>";
        echo "</ul>";
        
        // Test detection
        $channel = $response['data']['channel'] ?? '';
        $authChannel = $response['data']['authorization']['channel'] ?? '';
        $bank = $response['data']['authorization']['bank'] ?? '';
        $brand = $response['data']['authorization']['brand'] ?? '';
        $mobileNumber = $response['data']['authorization']['mobile_money_number'] ?? '';
        
        echo "<h3>Detection Test:</h3>";
        echo "<ul>";
        echo "<li>Channel check: " . ($channel === 'mobile_money' ? '✅ MATCH' : '❌ NO MATCH') . "</li>";
        echo "<li>Auth Channel check: " . ($authChannel === 'mobile_money' ? '✅ MATCH' : '❌ NO MATCH') . "</li>";
        echo "<li>Bank check: " . (strtolower($bank) === 'm-pesa' ? '✅ MATCH' : '❌ NO MATCH') . "</li>";
        echo "<li>Brand check: " . (strtolower($brand) === 'm-pesa' ? '✅ MATCH' : '❌ NO MATCH') . "</li>";
        echo "<li>Mobile number check: " . (!empty($mobileNumber) ? '✅ MATCH' : '❌ NO MATCH') . "</li>";
        echo "</ul>";
        
        // Determine result
        if ($channel === 'mobile_money' || $authChannel === 'mobile_money' || 
            strtolower($bank) === 'm-pesa' || strtolower($brand) === 'm-pesa' || 
            !empty($mobileNumber)) {
            echo "<p style='color: green; font-weight: bold;'>🎉 DETECTED AS M-PESA!</p>";
        } else {
            echo "<p style='color: red; font-weight: bold;'>❌ NOT DETECTED AS M-PESA</p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ JSON decode failed</p>";
        echo "<p>JSON Error: " . json_last_error_msg() . "</p>";
    }
} else {
    echo "<p style='color: red;'>Transaction not found</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
h3 { color: #888; margin-top: 20px; }
pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; max-height: 300px; }
ul { margin: 10px 0; padding-left: 20px; }
li { margin: 5px 0; }
</style> 