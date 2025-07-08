<?php
/**
 * Fix Cart Links
 * This script links existing cart items to their orders using checkout_token
 */

require_once 'admin/config/dbcon.php';

echo "<h1>Fix Cart Links</h1>";
echo "<p>This script will link existing cart items to their orders using the checkout_token field.</p>";

// Function to run SQL queries
function runSQL($conn, $sql, $description) {
    echo "<h3>$description</h3>";
    try {
        if ($conn->query($sql)) {
            echo "✅ Success: $description<br>";
            return true;
        } else {
            echo "❌ Error: " . $conn->error . "<br>";
            return false;
        }
    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "<br>";
        return false;
    }
}

// Step 1: Check current state
echo "<h2>Step 1: Current State Check</h2>";

// Check cart items without checkout_token
$sql = "SELECT COUNT(*) as count FROM cart WHERE checkout_token IS NULL OR checkout_token = ''";
$result = $conn->query($sql);
$unlinked_cart_items = $result->fetch_assoc()['count'];
echo "Cart items without checkout_token: $unlinked_cart_items<br>";

// Check orders with tokens
$sql = "SELECT COUNT(*) as count FROM checkout WHERE token IS NOT NULL AND token != ''";
$result = $conn->query($sql);
$orders_with_tokens = $result->fetch_assoc()['count'];
echo "Orders with tokens: $orders_with_tokens<br>";

// Step 2: Link cart items to orders using checkout_id
echo "<h2>Step 2: Linking Cart Items to Orders</h2>";

// Update cart items that have checkout_id but no checkout_token
$sql = "UPDATE cart c 
        INNER JOIN checkout co ON c.checkout_id = co.id 
        SET c.checkout_token = co.token 
        WHERE c.checkout_id IS NOT NULL 
        AND (c.checkout_token IS NULL OR c.checkout_token = '')
        AND co.token IS NOT NULL";
runSQL($conn, $sql, "Linking cart items using checkout_id");

// Step 3: Link cart items using session_id and user_id
echo "<h2>Step 3: Linking Cart Items Using Session/User</h2>";

// Update cart items using session_id
$sql = "UPDATE cart c 
        INNER JOIN checkout co ON c.session_id = co.session_id 
        SET c.checkout_token = co.token 
        WHERE c.checkout_id IS NULL 
        AND (c.checkout_token IS NULL OR c.checkout_token = '')
        AND co.token IS NOT NULL
        AND c.cart_status = 'processed'";
runSQL($conn, $sql, "Linking cart items using session_id");

// Step 4: Link cart items using user_id
$sql = "UPDATE cart c 
        INNER JOIN checkout co ON c.user_id = co.user_id 
        SET c.checkout_token = co.token 
        WHERE c.checkout_id IS NULL 
        AND (c.checkout_token IS NULL OR c.checkout_token = '')
        AND co.token IS NOT NULL
        AND c.cart_status = 'processed'
        AND c.session_id = co.session_id";
runSQL($conn, $sql, "Linking cart items using user_id and session");

// Step 5: Update checkout_token field in checkout table
echo "<h2>Step 4: Updating Checkout Table</h2>";

// Set checkout_token to same as token for existing orders
$sql = "UPDATE checkout SET checkout_token = token WHERE checkout_token IS NULL AND token IS NOT NULL";
runSQL($conn, $sql, "Setting checkout_token to token value");

// Step 6: Final check
echo "<h2>Step 5: Final Check</h2>";

// Check remaining unlinked cart items
$sql = "SELECT COUNT(*) as count FROM cart WHERE checkout_token IS NULL OR checkout_token = ''";
$result = $conn->query($sql);
$remaining_unlinked = $result->fetch_assoc()['count'];
echo "Remaining unlinked cart items: $remaining_unlinked<br>";

// Show sample linked items
$sql = "SELECT c.id, c.product_name, c.checkout_token, co.shipment_number 
        FROM cart c 
        LEFT JOIN checkout co ON c.checkout_token = co.token 
        WHERE c.checkout_token IS NOT NULL 
        ORDER BY c.id DESC 
        LIMIT 5";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<h3>Sample Linked Cart Items:</h3>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Cart ID</th><th>Product</th><th>Checkout Token</th><th>Shipment Number</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['product_name'] . "</td>";
        echo "<td>" . substr($row['checkout_token'], 0, 20) . "...</td>";
        echo "<td>" . $row['shipment_number'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Step 7: Test receipt functionality
echo "<h2>Step 6: Test Receipt Functionality</h2>";

// Get a sample order with items
$sql = "SELECT co.id, co.token, co.shipment_number, COUNT(c.id) as item_count 
        FROM checkout co 
        LEFT JOIN cart c ON co.token = c.checkout_token 
        WHERE co.token IS NOT NULL 
        GROUP BY co.id 
        HAVING item_count > 0 
        ORDER BY co.id DESC 
        LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $sample_order = $result->fetch_assoc();
    echo "✅ Found order with items: " . $sample_order['shipment_number'] . " (Token: " . substr($sample_order['token'], 0, 20) . "...)<br>";
    echo "Items in order: " . $sample_order['item_count'] . "<br>";
    echo "<a href='customer-receipts.php?token=" . $sample_order['token'] . "' style='color: #007bff;'>Test Receipt for this Order</a><br>";
} else {
    echo "❌ No orders found with linked cart items<br>";
}

echo "<hr>";
echo "<h2>Fix Complete!</h2>";
echo "<p>The cart items have been linked to their orders. You can now:</p>";
echo "<ul>";
echo "<li><a href='test_receipt.php' style='color: #007bff;'>Test the receipt system</a></li>";
echo "<li><a href='orders.php' style='color: #007bff;'>View your orders</a></li>";
echo "<li><a href='index.php' style='color: #007bff;'>Go back to home</a></li>";
echo "</ul>";

echo "<p><small>Fix completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>

<style>
body { 
    font-family: Arial, sans-serif; 
    margin: 20px; 
    line-height: 1.6; 
    background-color: #f8f9fa;
}
h1 { 
    color: #333; 
    border-bottom: 2px solid #007bff; 
    padding-bottom: 10px; 
}
h2 { 
    color: #666; 
    margin-top: 30px; 
}
h3 { 
    color: #888; 
    margin-top: 20px; 
}
table {
    font-size: 12px;
}
th, td {
    padding: 5px;
    text-align: left;
}
th {
    background-color: #f8f9fa;
}
</style> 