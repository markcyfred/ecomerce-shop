<?php
/**
 * Order Details Page
 * Shows detailed information about a specific order
 */

include 'admin/config/dbcon.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    header('Location: login.php?error=Please login to view order details');
    exit();
}

$user_id = $_SESSION['auth_user']['id'];

// Get token from URL
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token)) {
    header('Location: orders.php?message=Invalid order token&message_type=error');
    exit();
}

// Get order details
$stmt = $conn->prepare("SELECT c.*, 
                               pt.reference as payment_reference,
                               pt.status as payment_status,
                               pt.amount as payment_amount,
                               pt.created_at as payment_date,
                               pt.gateway_response,
                               pt.payment_method
                        FROM checkout c
                        LEFT JOIN paystack_transactions pt ON c.id = pt.order_id 
                        WHERE c.token = ? AND c.user_id = ?");
$stmt->bind_param("si", $token, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

// Check if order exists and belongs to user
if (!$order) {
    header('Location: orders.php?message=Order not found or access denied&message_type=error');
    exit();
}

// Get order items
$cart_query = "SELECT c.*, pi.image_path, pi.alt_text 
               FROM cart c 
               LEFT JOIN product_images pi ON c.product_id = pi.product_id AND pi.is_primary = 1 
               WHERE c.checkout_token = ? AND c.cart_status = 'processed'
               ORDER BY c.id ASC";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$order_items = [];
while ($row = $result->fetch_assoc()) {
    $order_items[] = $row;
}
$stmt->close();

// Get user details
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Ensure user data is safe
$user = $user ?: [];
$user_first_name = trim($user['first_name'] ?? '');
$user_last_name = trim($user['last_name'] ?? '');
$user_email = trim($user['email'] ?? '');
$user_phone = trim($user['phone'] ?? '');

// Function to get status badge class
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'paid':
            return 'badge-success';
        case 'pending':
            return 'badge-warning';
        case 'cancelled':
            return 'badge-danger';
        default:
            return 'badge-secondary';
    }
}

// Function to get status icon
function getStatusIcon($status) {
    switch ($status) {
        case 'paid':
            return 'fas fa-check-circle';
        case 'pending':
            return 'fas fa-clock';
        case 'cancelled':
            return 'fas fa-times-circle';
        default:
            return 'fas fa-question-circle';
    }
}

// Function to get payment method display name
function getPaymentMethodDisplayName($paymentMethod) {
    switch (strtolower($paymentMethod)) {
        case 'mpesa':
        case 'mobile_money':
            return 'M-Pesa Mobile Money';
        case 'card':
        case 'credit_card':
        case 'debit_card':
            return 'Credit/Debit Card';
        case 'bank':
        case 'bank_transfer':
            return 'Bank Transfer';
        case 'ussd':
            return 'USSD Payment';
        case 'unknown':
            return 'Unknown Payment Method';
        default:
            return ucfirst($paymentMethod);
    }
}

// Function to extract payment method from Paystack response
function getPaymentMethod($gatewayResponse) {
    if (!$gatewayResponse) return 'Unknown';
    
    $response = json_decode($gatewayResponse, true);
    if (!$response) return 'Unknown';
    
    // Check for channel information in the response
    if (isset($response['data']['channel'])) {
        $channel = strtolower($response['data']['channel']);
        switch ($channel) {
            case 'card':
            case 'credit_card':
            case 'debit_card':
                return 'Credit/Debit Card';
            case 'mobile_money':
            case 'mpesa':
                return 'M-Pesa Mobile Money';
            case 'bank':
            case 'bank_transfer':
                return 'Bank Transfer';
            case 'ussd':
                return 'USSD Payment';
            default:
                return ucfirst($channel);
        }
    }
    
    // Check for authorization information
    if (isset($response['data']['authorization']['channel'])) {
        $channel = strtolower($response['data']['authorization']['channel']);
        switch ($channel) {
            case 'card':
                return 'Credit/Debit Card';
            case 'mobile_money':
            case 'mpesa':
                return 'M-Pesa Mobile Money';
            case 'bank':
                return 'Bank Transfer';
            case 'ussd':
                return 'USSD Payment';
            default:
                return ucfirst($channel);
        }
    }
    
    // Check for card_type in authorization
    if (isset($response['data']['authorization']['card_type'])) {
        return 'Credit/Debit Card (' . ucfirst($response['data']['authorization']['card_type']) . ')';
    }
    
    // Check for bank information
    if (isset($response['data']['authorization']['bank'])) {
        return 'Bank Transfer (' . $response['data']['authorization']['bank'] . ')';
    }
    
    // Check for mobile money provider
    if (isset($response['data']['authorization']['mobile_money_provider'])) {
        $provider = strtolower($response['data']['authorization']['mobile_money_provider']);
        if ($provider === 'mpesa') {
            return 'M-Pesa Mobile Money';
        }
        return ucfirst($provider) . ' Mobile Money';
    }
    
    return 'Paystack Payment';
}

// Function to get payment method icon
function getPaymentMethodIcon($paymentMethod) {
    $method = strtolower($paymentMethod);
    if (strpos($method, 'card') !== false) {
        return 'fas fa-credit-card';
    } elseif (strpos($method, 'mpesa') !== false || strpos($method, 'mobile') !== false) {
        return 'fas fa-mobile-alt';
    } elseif (strpos($method, 'bank') !== false) {
        return 'fas fa-university';
    } elseif (strpos($method, 'ussd') !== false) {
        return 'fas fa-phone';
    } else {
        return 'fas fa-money-bill-wave';
    }
}

// Function to get M-Pesa code from response
function getMpesaCode($gatewayResponse) {
    if (!$gatewayResponse) return null;
    
    $response = json_decode($gatewayResponse, true);
    if (!$response) return null;
    
    // Check various possible locations for M-Pesa code
    if (isset($response['data']['authorization']['authorization_code'])) {
        return $response['data']['authorization']['authorization_code'];
    }
    
    if (isset($response['data']['reference'])) {
        return $response['data']['reference'];
    }
    
    if (isset($response['data']['access_code'])) {
        return $response['data']['access_code'];
    }
    
    return null;
}

include 'includes/header.php';
?>

<style>
    .order-details-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .order-details-header {
        background: #f8f9fa;
        padding: 20px;
        border-bottom: 1px solid #dee2e6;
    }

    .order-details-content {
        padding: 20px;
    }

    .order-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
        transition: background-color 0.2s;
    }

    .order-item:hover {
        background-color: #f8f9fa;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 15px;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .item-price {
        color: #007bff;
        font-weight: 600;
    }

    .item-quantity {
        color: #6c757d;
        font-size: 0.9em;
    }

    .order-summary {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 5px 0;
    }

    .summary-row.total {
        border-top: 2px solid #dee2e6;
        padding-top: 15px;
        margin-top: 15px;
        font-weight: 600;
        font-size: 1.1em;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-secondary {
        background: #e2e3e5;
        color: #383d41;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9em;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
        text-decoration: none;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .info-card {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }

    .info-card h6 {
        margin-bottom: 10px;
        color: #495057;
        font-weight: 600;
    }

    .info-card p {
        margin-bottom: 5px;
        color: #6c757d;
    }

    .info-card strong {
        color: #333;
    }

    @media (max-width: 768px) {
        .order-item {
            flex-direction: column;
            text-align: center;
        }

        .item-image {
            margin-right: 0;
            margin-bottom: 10px;
        }

        .action-buttons {
            justify-content: center;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<nav style="margin-bottom: 20px;" data-depth="3" class="breadcrumb">
    <div class="container">
        <ol>
            <li>
                <a href="index.php"><span>Home</span></a>
            </li>
            <li>
                <a href="orders.php"><span>My Orders</span></a>
            </li>
            <li>
                <span>Order Details</span>
            </li>
        </ol>
    </div>
</nav>

<section id="wrapper">
    <div class="container">
        <div id="columns_inner">
            <div id="content-wrapper" class="js-content-wrapper">
                <section id="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Order Header -->
                            <div class="order-details-container">
                                <div class="order-details-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h2 class="mb-1">
                                                <i class="fas fa-shopping-bag me-2"></i>
                                                Order #<?= htmlspecialchars($order['shipment_number'] ?? 'N/A') ?>
                                            </h2>
                                            <p class="text-muted mb-0">
                                                Placed on <?= date('F d, Y \a\t H:i', strtotime($order['created_at'] ?? 'now')) ?>
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <span class="status-badge <?= getStatusBadgeClass($order['status'] ?? '') ?>">
                                                <i class="<?= getStatusIcon($order['status'] ?? '') ?>"></i>
                                                <?= ucfirst($order['status'] ?? 'Unknown') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="order-details-content">
                                    <!-- Order Information Grid -->
                                    <div class="info-grid">
                                        <!-- Customer Information -->
                                        <div class="info-card">
                                            <h6><i class="fas fa-user me-2"></i>Customer Information</h6>
                                            <p><strong>Name:</strong> <?= htmlspecialchars($user_first_name . ' ' . $user_last_name) ?></p>
                                            <p><strong>Email:</strong> <?= htmlspecialchars($user_email) ?></p>
                                            <?php if (!empty($user_phone)): ?>
                                                <p><strong>Phone:</strong> <?= htmlspecialchars($user_phone) ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Shipping Information -->
                                        <div class="info-card">
                                            <h6><i class="fas fa-shipping-fast me-2"></i>Shipping Address</h6>
                                            <p><strong>Address:</strong> <?= htmlspecialchars($order['destination'] ?? 'N/A') ?></p>
                                            <p><strong>State:</strong> <?= htmlspecialchars($order['state'] ?? 'N/A') ?></p>
                                            <p><strong>Postal Code:</strong> <?= htmlspecialchars($order['postcode'] ?? 'N/A') ?></p>
                                        </div>

                                        <!-- Payment Information -->
                                        <div class="info-card">
                                            <h6><i class="fas fa-credit-card me-2"></i>Payment Details</h6>
                                            <?php if (($order['status'] ?? '') === 'paid' && !empty($order['payment_reference'] ?? '')): ?>
                                                <?php 
                                                // Get payment method - first try database column, then fallback to parsing gateway_response
                                                $payment_method = '';
                                                if (!empty($order['payment_method']) && $order['payment_method'] !== 'unknown') {
                                                    $payment_method = getPaymentMethodDisplayName($order['payment_method']);
                                                } else {
                                                    $payment_method = getPaymentMethod($order['gateway_response'] ?? '');
                                                }
                                                $payment_method_icon = getPaymentMethodIcon($payment_method);
                                                $mpesa_code = getMpesaCode($order['gateway_response'] ?? '');
                                                ?>
                                                <p><strong>Payment Reference:</strong> <?= htmlspecialchars($order['payment_reference']) ?></p>
                                                <p><strong>Payment Method:</strong> 
                                                    <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 8px; background: #007bff; color: white; border-radius: 12px; font-size: 0.8em;">
                                                        <i class="<?= $payment_method_icon ?>"></i>
                                                        <?= htmlspecialchars($payment_method) ?>
                                                    </span>
                                                </p>
                                                <?php if ($mpesa_code): ?>
                                                    <p><strong>M-Pesa Code:</strong> <?= htmlspecialchars($mpesa_code) ?></p>
                                                <?php endif; ?>
                                                <p><strong>Payment Date:</strong> <?= date('M d, Y H:i', strtotime($order['payment_date'] ?? 'now')) ?></p>
                                                <p><strong>Amount Paid:</strong> Kes <?= number_format($order['payment_amount'] ?? 0, 2) ?></p>
                                            <?php else: ?>
                                                <p><strong>Status:</strong> <?= ucfirst($order['status'] ?? 'Unknown') ?></p>
                                                <p><strong>Amount Due:</strong> Kes <?= number_format($order['total_amount'] ?? 0, 2) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Order Items -->
                                    <h5 class="mb-3"><i class="fas fa-box me-2"></i>Order Items (<?= count($order_items) ?> items)</h5>
                                    
                                    <?php if (empty($order_items)): ?>
                                        <div class="text-center py-4">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No items found for this order.</p>
                                        </div>
                                    <?php else: ?>
                                        <div class="order-details-container">
                                            <?php foreach ($order_items as $item): ?>
                                                <?php 
                                                // Ensure item is an array and has required keys
                                                if (!is_array($item)) continue;
                                                
                                                $item_name = $item['product_name'] ?? 'Unknown Product';
                                                $item_price = floatval($item['selling_price'] ?? 0);
                                                $item_quantity = intval($item['quantity'] ?? 0);
                                                $item_image = $item['image_path'] ?? 'uploads/shop/default.png';
                                                $item_alt = $item['alt_text'] ?? $item_name;
                                                ?>
                                                <div class="order-item">
                                                    <img src="<?= htmlspecialchars($item_image) ?>" 
                                                         alt="<?= htmlspecialchars($item_alt) ?>" 
                                                         class="item-image">
                                                    
                                                    <div class="item-details">
                                                        <div class="item-name"><?= htmlspecialchars($item_name) ?></div>
                                                        <div class="item-price">Kes <?= number_format($item_price, 2) ?></div>
                                                        <div class="item-quantity">Quantity: <?= $item_quantity ?></div>
                                                    </div>
                                                    
                                                    <div class="text-end">
                                                        <div class="item-total">
                                                            <strong>Kes <?= number_format($item_price * $item_quantity, 2) ?></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Order Summary -->
                                    <div class="order-summary">
                                        <h6 class="mb-3"><i class="fas fa-calculator me-2"></i>Order Summary</h6>
                                        
                                        <div class="summary-row">
                                            <span>Subtotal:</span>
                                            <span>Kes <?= number_format($order['cart_subtotal'] ?? 0, 2) ?></span>
                                        </div>
                                        
                                        <?php if (($order['discount'] ?? 0) > 0): ?>
                                            <div class="summary-row">
                                                <span>Discount:</span>
                                                <span>- Kes <?= number_format($order['discount'], 2) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="summary-row">
                                            <span>Shipping:</span>
                                            <span>Kes <?= number_format($order['shipping_cost'] ?? 0, 2) ?></span>
                                        </div>
                                        
                                        <div class="summary-row total">
                                            <span>Total:</span>
                                            <span>Kes <?= number_format($order['total_amount'] ?? 0, 2) ?></span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="action-buttons mt-4">
                                        <a href="orders.php" class="btn btn-info">
                                            <i class="fas fa-arrow-left"></i> Back to Orders
                                        </a>
                                        
                                        <?php if (($order['status'] ?? '') === 'paid'): ?>
                                            <a href="customer-receipts.php?token=<?= urlencode($token) ?>" class="btn btn-success">
                                                <i class="fas fa-receipt"></i> View Receipt
                                            </a>
                                        <?php elseif (($order['status'] ?? '') === 'pending'): ?>
                                            <a href="order-confirmation.php?token=<?= urlencode($token) ?>" class="btn btn-primary">
                                                <i class="fas fa-credit-card"></i> Pay Now
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Handle URL parameters for SweetAlert messages -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    const messageType = urlParams.get('message_type');
    
    // If message parameters exist, show SweetAlert
    if (message && messageType) {
        // Determine icon based on message type
        let icon = 'info';
        switch(messageType) {
            case 'success':
                icon = 'success';
                break;
            case 'error':
            case 'danger':
                icon = 'error';
                break;
            case 'warning':
                icon = 'warning';
                break;
            default:
                icon = 'info';
        }
        
        // Show SweetAlert toast
        Swal.fire({
            position: 'top-end',
            icon: icon,
            title: message,
            toast: true,
            showConfirmButton: false,
            timer: 3000,
            width: 'auto',
            padding: '0.1em',
            background: 'white',
            customClass: {
                container: 'my-swal-container'
            }
        });
        
        // Clean up URL parameters without page reload
        const newUrl = window.location.pathname + '?token=' + urlParams.get('token');
        window.history.replaceState({}, document.title, newUrl);
    }
});
</script>

</body>
</html> 