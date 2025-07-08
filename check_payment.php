<?php
/**
 * Payment Verification Tool
 * 
 * This tool allows users to verify their payment status
 */

include 'admin/config/dbcon.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$message = '';
$payment_status = null;
$order_details = null;
$cart_items = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mpesa_code = trim($_POST['mpesa_code'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    
    if (!empty($token)) {
        // Search by token
        $stmt = $conn->prepare("SELECT * FROM checkout WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $order_details = $result->fetch_assoc();
        $stmt->close();
        
        if ($order_details) {
            $message = "Order found with token.";
        } else {
            $message = "Order not found with this token.";
        }
    } elseif (!empty($mpesa_code)) {
        // Search by M-Pesa code in Paystack transactions
        $stmt = $conn->prepare("SELECT pt.*, c.* FROM paystack_transactions pt 
                               JOIN checkout c ON pt.order_id = c.id 
                               WHERE pt.gateway_response LIKE ? 
                               ORDER BY pt.created_at DESC LIMIT 1");
        $search_term = '%' . $mpesa_code . '%';
        $stmt->bind_param("s", $search_term);
        $stmt->execute();
        $result = $stmt->get_result();
        $payment_status = $result->fetch_assoc();
        $stmt->close();
        
        if ($payment_status) {
            // Get order details
            $stmt = $conn->prepare("SELECT * FROM checkout WHERE id = ?");
            $stmt->bind_param("i", $payment_status['order_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $order_details = $result->fetch_assoc();
            $stmt->close();
            
            $message = "Payment found with M-Pesa code! Status: " . ucfirst($payment_status['status']);
        } else {
            $message = "No payment found with this M-Pesa code.";
        }
    } elseif (!empty($phone)) {
        // Search by phone number
        $stmt = $conn->prepare("SELECT c.* FROM checkout c 
                               JOIN users u ON c.user_id = u.id 
                               WHERE u.phone LIKE ? 
                               ORDER BY c.created_at DESC 
                               LIMIT 5");
        $phone_search = '%' . $phone . '%';
        $stmt->bind_param("s", $phone_search);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();
        
        if (!empty($orders)) {
            $message = "Found " . count($orders) . " order(s) for this phone number.";
            // Use the most recent order
            $order_details = $orders[0];
        } else {
            $message = "No orders found for this phone number.";
        }
    } elseif (!empty($email)) {
        // Search by email
        $stmt = $conn->prepare("SELECT c.* FROM checkout c 
                               JOIN users u ON c.user_id = u.id 
                               WHERE u.email = ? 
                               ORDER BY c.created_at DESC 
                               LIMIT 5");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();
        
        if (!empty($orders)) {
            $message = "Found " . count($orders) . " order(s) for this email.";
            // Use the most recent order
            $order_details = $orders[0];
        } else {
            $message = "No orders found for this email.";
        }
    } else {
        $message = "Please provide at least one search criteria.";
    }
    
    // If we have order details, get cart items and payment status
    if ($order_details) {
        $token = $order_details['token'];
        
        // Get cart items for this order
        $cart_query = "SELECT c.*, pi.image_path, pi.alt_text 
                      FROM cart c 
                      LEFT JOIN product_images pi ON c.product_id = pi.product_id AND pi.is_primary = 1 
                      WHERE c.checkout_token = ? AND c.cart_status = 'processed'";
        $stmt = $conn->prepare($cart_query);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $cart_items[] = $row;
        }
        $stmt->close();
        
        // If we don't already have payment status, get it
        if (!$payment_status) {
            $stmt = $conn->prepare("SELECT * FROM paystack_transactions WHERE order_id = ? ORDER BY created_at DESC LIMIT 1");
            $stmt->bind_param("i", $order_details['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $payment_status = $result->fetch_assoc();
            $stmt->close();
        }
    }
}

// Function to get payment method display name
function getPaymentMethodName($method) {
    switch ($method) {
        case 'mpesa':
            return 'M-Pesa Mobile Money';
        case 'card':
            return 'Credit/Debit Card';
        case 'bank':
            return 'Bank Transfer';
        case 'ussd':
            return 'USSD Payment';
        default:
            return ucfirst($method);
    }
}

// Function to extract M-Pesa code from gateway response
function extractMpesaCode($gatewayResponse) {
    if (!$gatewayResponse) return null;
    
    $response = json_decode($gatewayResponse, true);
    
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Payment - Market Place</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .verification-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin: 20px 0;
        }
        .status-success {
            color: #28a745;
            font-weight: bold;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-failed {
            color: #dc3545;
            font-weight: bold;
        }
        .cart-item {
            border-bottom: 1px solid #dee2e6;
            padding: 15px 0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        .payment-method-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .payment-method-mpesa {
            background: #00a651;
            color: white;
        }
        .payment-method-card {
            background: #007bff;
            color: white;
        }
        .payment-method-bank {
            background: #6c757d;
            color: white;
        }
        .search-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 20px;
        }
        .search-tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .search-tab.active {
            border-bottom-color: #007bff;
            color: #007bff;
            font-weight: bold;
        }
        .search-tab:hover {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="verification-section">
                    <h2 class="text-center mb-4">
                        <i class="fas fa-search me-2"></i>
                        Verify Payment Status
                    </h2>
                    
                    <?php if ($message): ?>
                        <div class="alert alert-info">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Search Tabs -->
                    <div class="search-tabs">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="search-tab active" data-tab="mpesa">
                                    <i class="fas fa-mobile-alt me-1"></i>M-Pesa Code
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="search-tab" data-tab="phone">
                                    <i class="fas fa-phone me-1"></i>Phone Number
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="search-tab" data-tab="email">
                                    <i class="fas fa-envelope me-1"></i>Email
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="search-tab" data-tab="token">
                                    <i class="fas fa-key me-1"></i>Order Token
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form method="POST" class="mb-4">
                        <!-- M-Pesa Code Search -->
                        <div class="search-content" id="mpesa-content">
                            <div class="mb-3">
                                <label for="mpesa_code" class="form-label">
                                    <i class="fas fa-mobile-alt me-1"></i>M-Pesa Code
                                </label>
                                <input type="text" class="form-control" id="mpesa_code" name="mpesa_code" 
                                       placeholder="Enter your M-Pesa transaction code (e.g., QK123456789)" 
                                       value="<?= htmlspecialchars($_POST['mpesa_code'] ?? '') ?>">
                                <div class="form-text">Enter the code you received from M-Pesa SMS</div>
                            </div>
                        </div>
                        
                        <!-- Phone Number Search -->
                        <div class="search-content" id="phone-content" style="display: none;">
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>Phone Number
                                </label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       placeholder="Enter your phone number" 
                                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                                <div class="form-text">Enter the phone number used for the order</div>
                            </div>
                        </div>
                        
                        <!-- Email Search -->
                        <div class="search-content" id="email-content" style="display: none;">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Email Address
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="Enter your email address"
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                                <div class="form-text">We'll show your recent orders</div>
                            </div>
                        </div>
                        
                        <!-- Token Search -->
                        <div class="search-content" id="token-content" style="display: none;">
                            <div class="mb-3">
                                <label for="token" class="form-label">
                                    <i class="fas fa-key me-1"></i>Order Token
                                </label>
                                <input type="text" class="form-control" id="token" name="token" 
                                       placeholder="Enter your order token" 
                                       value="<?= htmlspecialchars($_POST['token'] ?? '') ?>">
                                <div class="form-text">You can find this in your order confirmation email or URL</div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>
                                Verify Payment
                            </button>
                        </div>
                    </form>
                    
                    <?php if ($order_details): ?>
                        <!-- Order Summary -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="fas fa-shopping-cart me-2"></i>Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Order Reference:</strong> <?= htmlspecialchars($order_details['shipment_number']) ?></p>
                                        <p><strong>Order Date:</strong> <?= date('M d, Y H:i', strtotime($order_details['created_at'])) ?></p>
                                        <p><strong>Order Status:</strong> 
                                            <span class="status-<?= $order_details['status'] === 'paid' ? 'success' : 'pending' ?>">
                                                <?= ucfirst($order_details['status']) ?>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Total Amount:</strong> <span class="h5 text-primary">Kes <?= number_format($order_details['total_amount'], 2) ?></span></p>
                                        <p><strong>Subtotal:</strong> Kes <?= number_format($order_details['cart_subtotal'] ?? 0, 2) ?></p>
                                        <p><strong>Shipping:</strong> Kes <?= number_format($order_details['shipping_cost'] ?? 0, 2) ?></p>
                                        <?php if (($order_details['discount'] ?? 0) > 0): ?>
                                            <p><strong>Discount:</strong> -Kes <?= number_format($order_details['discount'], 2) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <?php if (!empty($cart_items)): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5><i class="fas fa-box me-2"></i>Order Items (<?= count($cart_items) ?> items)</h5>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($cart_items as $item): ?>
                                        <div class="cart-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <img src="<?= htmlspecialchars($item['image_path'] ?? 'uploads/shop/default.png') ?>" 
                                                         alt="<?= htmlspecialchars($item['alt_text'] ?? $item['product_name']) ?>" 
                                                         class="product-image">
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="mb-1"><?= htmlspecialchars($item['product_name']) ?></h6>
                                                    <p class="text-muted mb-0">Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                                                    <p class="text-muted mb-0">Unit Price: Kes <?= number_format($item['selling_price'], 2) ?></p>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <strong>Kes <?= number_format($item['selling_price'] * $item['quantity'], 2) ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Shipping Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="fas fa-shipping-fast me-2"></i>Shipping Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Delivery Address:</strong><br>
                                        <?= htmlspecialchars($order_details['destination']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>State:</strong> <?= htmlspecialchars($order_details['state']) ?></p>
                                        <p><strong>Postal Code:</strong> <?= htmlspecialchars($order_details['postcode']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Details -->
                        <?php if ($payment_status): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5><i class="fas fa-credit-card me-2"></i>Payment Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Payment Reference:</strong> <?= htmlspecialchars($payment_status['reference']) ?></p>
                                            <p><strong>Payment Method:</strong> 
                                                <span class="payment-method-badge payment-method-<?= strtolower($payment_status['payment_method'] ?? 'card') ?>">
                                                    <?= getPaymentMethodName($payment_status['payment_method'] ?? 'card') ?>
                                                </span>
                                            </p>
                                            <p><strong>Payment Status:</strong> 
                                                <span class="status-<?= $payment_status['status'] === 'success' ? 'success' : ($payment_status['status'] === 'failed' ? 'failed' : 'pending') ?>">
                                                    <?= ucfirst($payment_status['status']) ?>
                                                </span>
                                            </p>
                                            <?php 
                                            $mpesa_code = extractMpesaCode($payment_status['gateway_response']);
                                            if ($mpesa_code): ?>
                                                <p><strong>M-Pesa Code:</strong> <?= htmlspecialchars($mpesa_code) ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Amount Paid:</strong> Kes <?= number_format($payment_status['amount'], 2) ?></p>
                                            <p><strong>Payment Date:</strong> <?= $payment_status['paid_at'] ? date('M d, Y H:i', strtotime($payment_status['paid_at'])) : 'Not paid yet' ?></p>
                                            <?php if ($payment_status['gateway_response']): ?>
                                                <?php 
                                                $response = json_decode($payment_status['gateway_response'], true);
                                                if (isset($response['data']['authorization']['authorization_code'])): ?>
                                                    <p><strong>Authorization Code:</strong> <?= htmlspecialchars($response['data']['authorization']['authorization_code']) ?></p>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <?php if ($payment_status['status'] === 'success'): ?>
                                        <div class="alert alert-success mt-3">
                                            <h6><i class="fas fa-check-circle me-2"></i>Payment Successful!</h6>
                                            <p>Your payment has been processed successfully. You will receive an email confirmation shortly.</p>
                                            <a href="paystack/success.php?token=<?= urlencode($order_details['token']) ?>" class="btn btn-success">
                                                <i class="fas fa-eye me-1"></i>View Order Confirmation
                                            </a>
                                        </div>
                                    <?php elseif ($payment_status['status'] === 'failed'): ?>
                                        <div class="alert alert-danger mt-3">
                                            <h6><i class="fas fa-times-circle me-2"></i>Payment Failed</h6>
                                            <p>Your payment was not successful. Please try again.</p>
                                            <a href="order-confirmation.php?token=<?= urlencode($order_details['token']) ?>" class="btn btn-primary">
                                                <i class="fas fa-redo me-1"></i>Try Payment Again
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning mt-3">
                                            <h6><i class="fas fa-clock me-2"></i>Payment Pending</h6>
                                            <p>Your payment is being processed. Please wait a few minutes and check again.</p>
                                            <p><strong>Note:</strong> If you used M-Pesa, please check your phone for the payment confirmation SMS.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>No Payment Record Found</h6>
                                <p>No payment has been made for this order yet. Please proceed with the payment.</p>
                                <a href="order-confirmation.php?token=<?= urlencode($order_details['token']) ?>" class="btn btn-primary">
                                    <i class="fas fa-credit-card me-1"></i>Proceed to Payment
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-1"></i>Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.search-tab');
            const contents = document.querySelectorAll('.search-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.style.display = 'none');
                    
                    // Add active class to clicked tab and show content
                    this.classList.add('active');
                    document.getElementById(targetTab + '-content').style.display = 'block';
                });
            });
        });
    </script>
</body>
</html> 