<?php
/**
 * Test Receipt Page
 * This page tests the receipt functionality with sample data
 */

include 'admin/config/dbcon.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    echo "<h2>Please login first to test receipts</h2>";
    echo "<a href='login.php'>Login</a>";
    exit();
}

$user_id = $_SESSION['auth_user']['id'];

echo "<h1>Receipt Test Page</h1>";
echo "<p>Testing receipt functionality for user ID: $user_id</p>";

// Get user's orders
$stmt = $conn->prepare("SELECT c.*, 
                               pt.reference as payment_reference,
                               pt.status as payment_status,
                               pt.amount as payment_amount,
                               pt.created_at as payment_date
                        FROM checkout c
                        LEFT JOIN paystack_transactions pt ON c.id = pt.order_id 
                        WHERE c.user_id = ?
                        ORDER BY c.created_at DESC
                        LIMIT 5");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
$stmt->close();

echo "<h2>Your Recent Orders:</h2>";

if (empty($orders)) {
    echo "<p>No orders found for this user.</p>";
    echo "<p><a href='shop.php'>Go shopping to create an order</a></p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr>";
    echo "<th>Order ID</th>";
    echo "<th>Order Number</th>";
    echo "<th>Token</th>";
    echo "<th>Status</th>";
    echo "<th>Total</th>";
    echo "<th>Payment Status</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    
    foreach ($orders as $order) {
        echo "<tr>";
        echo "<td>" . $order['id'] . "</td>";
        echo "<td>" . htmlspecialchars($order['shipment_number']) . "</td>";
        echo "<td>" . htmlspecialchars($order['token']) . "</td>";
        echo "<td>" . ucfirst($order['status']) . "</td>";
        echo "<td>Kes " . number_format($order['total_amount'], 2) . "</td>";
        echo "<td>" . ($order['payment_status'] ? ucfirst($order['payment_status']) : 'N/A') . "</td>";
        echo "<td>";
        
        // Test receipt link
        if ($order['status'] === 'paid') {
            echo "<a href='customer-receipts.php?token=" . urlencode($order['token']) . "' target='_blank'>View Receipt</a> | ";
        }
        
        // Test with ID
        echo "<a href='customer-receipts.php?id=" . $order['id'] . "' target='_blank'>View Receipt (by ID)</a>";
        
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
}

// Test cart items for first order
if (!empty($orders)) {
    $first_order = $orders[0];
    echo "<h2>Testing Cart Items for Order: " . $first_order['shipment_number'] . "</h2>";
    
    $cart_query = "SELECT c.*, p.product_name, p.description, p.original_price, p.selling_price, p.image
                   FROM cart c
                   LEFT JOIN products p ON c.product_id = p.id
                   WHERE c.checkout_token = ? AND c.cart_status = 'processed'
                   ORDER BY c.cart_order ASC";
    $stmt = $conn->prepare($cart_query);
    $stmt->bind_param("s", $first_order['token']);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart_items = [];
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
    $stmt->close();
    
    echo "<p>Found " . count($cart_items) . " cart items for this order.</p>";
    
    if (!empty($cart_items)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr>";
        echo "<th>Product Name</th>";
        echo "<th>Price</th>";
        echo "<th>Quantity</th>";
        echo "<th>Total</th>";
        echo "</tr>";
        
        foreach ($cart_items as $item) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($item['product_name']) . "</td>";
            echo "<td>Kes " . number_format($item['selling_price'], 2) . "</td>";
            echo "<td>" . $item['quantity'] . "</td>";
            echo "<td>Kes " . number_format($item['selling_price'] * $item['quantity'], 2) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
}

echo "<hr>";
echo "<h2>Quick Links:</h2>";
echo "<ul>";
echo "<li><a href='orders.php'>View All Orders</a></li>";
echo "<li><a href='shop.php'>Go Shopping</a></li>";
echo "<li><a href='index.php'>Home</a></li>";
echo "</ul>";
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