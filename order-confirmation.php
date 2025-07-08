<?php
// order_confirmation.php

include 'admin/config/dbcon.php';  // Database connection
require_once 'paystack/PaystackHelper.php';  // Paystack helper

// Start session if not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Retrieve the token from the URL
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token)) {
    header("Location: index.php?error=Invalid order token");
    exit();
}

// Get the current order details from the checkout table using token.
$stmt = $conn->prepare("SELECT * FROM checkout WHERE token = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

$order = $result->fetch_assoc();
$stmt->close();

// Check if order exists
if (!$order) {
    header("Location: index.php?error=Order not found");
    exit();
}

// If order is already paid, redirect to orders page
if ($order['status'] === 'paid') {
    header("Location: orders.php?message=Order already paid&message_type=success");
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    header("Location: login.php?error=Please login to complete your payment");
    exit();
}

// Get cart items for this specific order using token
$order_token = $order['token'] ?? '';

// Simple direct query to get cart items for this order using token
$order_cart_items = [];
$cart_query = "SELECT c.*, pi.image_path, pi.alt_text 
               FROM cart c 
               LEFT JOIN product_images pi ON c.product_id = pi.product_id AND pi.is_primary = 1 
               WHERE c.checkout_token = '$order_token' AND c.cart_status = 'processed'";
$cart_result = mysqli_query($conn, $cart_query);

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $order_cart_items[] = $row;
    }
}

// Debug: Final cart_items count
error_log("Final cart_items count: " . count($order_cart_items));

// Get user details
$user_id = $_SESSION['auth_user']['id'] ?? null;
$user_details = null;
if ($user_id) {
    $stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_details = $result->fetch_assoc();
    $stmt->close();
}

// Initialize Paystack for inline payment
$paystack = null;
$publicKey = '';
$reference = '';
if ($user_details) {
    try {
        $paystack = new PaystackHelper($conn);
        $publicKey = $paystack->getPublicKey();
        
        // Generate unique reference for this transaction
        $reference = 'PS_' . time() . '_' . $token;
        
        // Store order data in session for payment verification
        $_SESSION['inline_payment_data'] = [
            'order_id' => $order['id'],
            'user_id' => $user_id,
            'checkout_token' => $token,
            'email' => $user_details['email'],
            'customer_name' => $user_details['first_name'] . ' ' . $user_details['last_name'],
            'total_amount' => $order['total_amount'],
            'shipment_number' => $order['shipment_number'],
            'reference' => $reference
        ];
    } catch (Exception $e) {
        error_log("Paystack initialization error: " . $e->getMessage());
    }
}

// Get list of countries for dropdown
$countries = [
    'Kenya' => 'Kenya',
    'Uganda' => 'Uganda',
    'Tanzania' => 'Tanzania',
    'Rwanda' => 'Rwanda',
    'Burundi' => 'Burundi',
    'Ethiopia' => 'Ethiopia',
    'South Sudan' => 'South Sudan',
    'Somalia' => 'Somalia'
];
?>
<!doctype html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation - Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .payment-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .payment-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }
        
        .payment-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .payment-button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .loading {
            display: none;
            text-align: center;
            margin: 20px 0;
        }
        
        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .error-message {
            display: none;
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #c33;
        }
        
        .success-message {
            display: none;
            background: #efe;
            color: #363;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #363;
        }
        
        .retry-button {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            font-size: 14px;
        }
        
        .dismiss-button {
            background: #6c757d;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .order-summary h3 {
            margin-top: 0;
            color: #333;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .summary-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 18px;
            color: #667eea;
        }
        
        /* Fireworks container */
        #fireworks-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            pointer-events: none;
            display: none;
        }
        
        /* Success overlay */
        .success-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10000;
            display: none;
            justify-content: center;
            align-items: center;
            pointer-events: none;
        }
        
        .success-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            pointer-events: auto;
            animation: successPop 0.6s ease-out;
        }
        
        @keyframes successPop {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .success-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }
        
        .success-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .success-message {
            font-size: 16px;
            color: #666;
            margin-bottom: 25px;
        }
        
        .success-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .success-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .success-btn.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .success-btn.secondary {
            background: #6c757d;
            color: white;
        }
        
        .success-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body id="checkout" class="lang-en country-us currency-usd layout-full-width page-order tax-display-disabled">

    <main id="page">
        <!--header was here-->
        <?php include "includes/header.php"; ?>

        <aside id="notifications">
            <div class="container">
            </div>
        </aside>

        <nav data-depth="1" class="breadcrumb">
            <div class="container">
                <ol>
                    <li>
                        <span>Home</span>
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
                                <div class="col-md-8">
                                    <!-- Payment Section -->
                                    <div class="payment-section">
                                        <h2 class="mb-4">
                                            <i class="fas fa-credit-card me-2"></i>
                                            Complete Your Payment
                                        </h2>
                                        
                                        <div class="alert alert-info">
                                            <h5><i class="fas fa-info-circle me-2"></i>Order Summary</h5>
                                            <p><strong>Order Reference:</strong> <?= htmlspecialchars($order['shipment_number']) ?></p>
                                            <p><strong>Total Amount:</strong> <span class="h4 text-primary">Kes <?= number_format($order['total_amount'], 2) ?></span></p>
                                        </div>

                                        <!-- Payment Methods -->
                                        <div class="payment-methods mb-4">
                                            <h5 class="mb-3">Payment Method</h5>
                                            
                                            <div class="payment-method selected" data-method="paystack">
                                                <div class="d-flex align-items-center">
                                                    <div class="payment-icon text-primary">
                                                        <i class="fas fa-credit-card"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">Paystack Payment Gateway</h6>
                                                        <p class="mb-0 text-muted">Secure payment via credit/debit card, bank transfer, or mobile money</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Button -->
                                        <div class="text-center">
                                            <button type="button" id="payButton" class="btn btn-primary btn-lg" <?= empty($publicKey) ? 'disabled' : '' ?>>
                                                <i class="fas fa-lock me-2"></i>
                                                Pay Securely with Paystack
                                            </button>
                                            <p class="text-muted mt-2">
                                                <small>
                                                    <i class="fas fa-shield-alt me-1"></i>
                                                    Your payment information is encrypted and secure
                                                </small>
                                            </p>
                                            
                                            <!-- Loading indicator -->
                                            <div id="paymentLoading" class="mt-3" style="display: none;">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Processing payment...</span>
                                                </div>
                                                <p class="mt-2">Processing your payment...</p>
                                            </div>
                                            
                                            <!-- Error message -->
                                            <div id="paymentError" class="alert alert-danger mt-3" style="display: none;">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                                    <div class="flex-grow-1">
                                                        <span id="errorMessage"></span>
                                                        <div class="mt-2">
                                                            <button type="button" class="btn btn-outline-danger btn-sm me-2" onclick="retryPayment()">
                                                                <i class="fas fa-redo me-1"></i>Try Again
                                                            </button>
                                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="hideError()">
                                                                <i class="fas fa-times me-1"></i>Dismiss
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>

                                        <!-- Payment Security Info -->
                                        <div class="alert alert-light mt-4">
                                            <h6><i class="fas fa-shield-alt me-2"></i>Payment Security</h6>
                                            <ul class="mb-0">
                                                <li>All transactions are secured with SSL encryption</li>
                                                <li>We never store your payment card details</li>
                                                <li>Paystack is PCI DSS compliant</li>
                                                <li>24/7 fraud monitoring and protection</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Order Information -->
                                    <div class="payment-section">
                                        <h4><i class="fas fa-shipping-fast me-2"></i>Shipping Information</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Delivery Address:</strong><br>
                                                <?= htmlspecialchars($order['destination']) ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>State:</strong> <?= htmlspecialchars($order['state']) ?></p>
                                                <p><strong>Postal Code:</strong> <?= htmlspecialchars($order['postcode']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <section id="js-checkout-summary" class="card js-cart">
                                        <div class="card-block">

                                            <div class="cart-summary-top js-cart-summary-top">

                                            </div>




                                            <div class="cart-summary-products js-cart-summary-products">
                                                <p><?= count($order_cart_items) ?> items</p>
                                                
                                                <!-- Debug information -->
                                                <?php if (count($order_cart_items) == 0): ?>
                                                <div style="background: #f8f9fa; padding: 10px; margin: 10px 0; border: 1px solid #dee2e6;">
                                                    <strong>Debug Info:</strong><br>
                                                    Order ID: <?= $order_token ?><br>
                                                    Cart Items Count: <?= count($order_cart_items) ?><br>
                                                    Query Executed: <?= $cart_query ?><br>
                                                    Query Result: <?= $cart_result ? 'Success' : 'Failed' ?><br>
                                                    Num Rows: <?= $cart_result ? mysqli_num_rows($cart_result) : 'N/A' ?><br>
                                                    
                                                    <?php
                                                    // Direct query to see what's in the database
                                                    $debug_query = "SELECT * FROM cart WHERE checkout_token = '$order_token'";
                                                    $debug_result = mysqli_query($conn, $debug_query);
                                                    echo "Direct DB Query: $debug_query<br>";
                                                    echo "Items in DB with checkout_token=$order_token: " . mysqli_num_rows($debug_result) . "<br>";
                                                    
                                                    if (mysqli_num_rows($debug_result) > 0) {
                                                        while ($debug_row = mysqli_fetch_assoc($debug_result)) {
                                                            echo "- " . $debug_row['product_name'] . " (Status: " . $debug_row['cart_status'] . ")<br>";
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    <small>If you see 0 items but totals are correct, the cart items may not have the correct checkout_token set.</small>
                                                </div>
                                                <?php endif; ?>

                                                <p>
                                                    <a href="#" data-toggle="collapse" data-target="#cart-summary-product-list" class="js-show-details">
                                                        show details
                                                        <i class="material-icons">expand_more</i>
                                                    </a>
                                                </p>


                                                <div class="collapse" id="cart-summary-product-list">
                                                    <?php
                                                    if (!empty($order_cart_items)):
                                                        foreach ($order_cart_items as $cart_item):
                                                            $item_total = $cart_item['selling_price'] * $cart_item['quantity'];
                                                    ?>
                                                            <ul class="media-list">
                                                                <li class="media">
                                                                    <div class="media-left">
                                                                        <a href="shop-product.php?id=<?php echo htmlspecialchars($cart_item['product_id']); ?>" title="<?php echo htmlspecialchars($cart_item['product_name']); ?>">
                                                                            <img class="media-object" src="<?php echo htmlspecialchars($cart_item['image_path'] ?? 'uploads/shop/default.png'); ?>" alt="<?php echo htmlspecialchars($cart_item['alt_text'] ?? $cart_item['product_name']); ?>" loading="lazy">
                                                                        </a>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <span class="product-name">
                                                                            <a href="shop-product.php?id=<?php echo htmlspecialchars($cart_item['product_id']); ?>" target="_blank" rel="noopener noreferrer nofollow"><?php echo htmlspecialchars($cart_item['product_name']); ?></a>
                                                                        </span>
                                                                        <span class="product-quantity"><?php echo htmlspecialchars($cart_item['quantity']); ?></span>
                                                                        <span class="product-price float-xs-right">Kes <?php echo number_format($item_total, 2); ?></span>
                                                                        <br />
                                                                    </div>

                                                                </li>

                                                            </ul>
                                                    <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>

                                            </div>



                                            <div class="card-block cart-summary-subtotals-container js-cart-summary-subtotals-container">

                                                <div class="cart-summary-line cart-summary-subtotals" id="cart-subtotal-products">

                                                    <span class="label">
                                                        Subtotal
                                                    </span>

                                                    <span class="value">
                                                        Kes <?php echo number_format($order['cart_subtotal'] ?? 0, 2); ?>
                                                    </span>
                                                </div>
                                                <?php if (($order['discount'] ?? 0) > 0): ?>
                                                <div class="cart-summary-line cart-summary-subtotals" id="cart-subtotal-discount">

                                                    <span class="label">
                                                        Discount(s)
                                                    </span>

                                                    <span class="value">
                                                        -&nbsp;Kes <?php echo number_format($order['discount'] ?? 0, 2); ?>
                                                    </span>
                                                </div>
                                                <?php endif; ?>
                                                <div class="cart-summary-line cart-summary-subtotals" id="cart-subtotal-shipping">

                                                    <span class="label">
                                                        Shipping
                                                    </span>

                                                    <span class="value">
                                                        Kes <?php echo number_format($order['shipping_cost'] ?? 0, 2); ?>
                                                    </span>
                                                </div>

                                            </div>


                                        </div>


                                        <div class="card-block cart-summary-totals js-cart-summary-totals">


                                            <div class="cart-summary-line cart-total">
                                                <span class="label">Total&nbsp;</span>
                                                <span class="value">Kes <?php echo number_format($order['total_amount'] ?? 0, 2); ?></span>
                                            </div>





                                        </div>




                                        <div class="block-promo">
                                            <?php if (isset($_SESSION['promo_code'])): ?>
                                            <div class="cart-voucher js-cart-voucher">

                                                <ul class="promo-name card-block">
                                                    <li class="cart-summary-line">
                                                        <span class="label">Promo Code: <?php echo htmlspecialchars($_SESSION['promo_code']['code']); ?></span>
                                                        <div class="float-xs-right">
                                                            <span>-Kes <?php echo number_format($_SESSION['promo_code']['discount_amount'], 2); ?></span>
                                                            <a href="#" class="remove-promo" data-link-action="remove-voucher"><i class="material-icons">&#xE872;</i></a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php endif; ?>

                                            <p class="promo-code-button display-promo">
                                                <a class="collapse-button" href="#promo-code">
                                                    Have a promo code?
                                                </a>
                                            </p>

                                            <div id="promo-code" class="collapse">
                                                <div class="promo-code">
                                                    <form id="promo-form" action="ajax/apply_promo.php" method="post">
                                                        <input type="hidden" name="cart_total" value="<?php echo $order['total_amount'] ?? 0; ?>">
                                                        <input class="promo-input" type="text" name="promo_code" placeholder="Enter promo code">
                                                        <button type="submit" class="btn btn-primary"><span>Apply</span></button>
                                                    </form>

                                                    <div class="alert alert-danger js-error" role="alert" style="display: none;">
                                                        <i class="material-icons">&#xE001;</i><span class="ml-1 js-error-text"></span>
                                                    </div>

                                                    <a class="collapse-button promo-code-button cancel-promo" role="button" data-toggle="collapse" data-target="#promo-code" aria-expanded="true" aria-controls="promo-code">
                                                        Close
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <div class="blockreassurance_product">
                                        <div>
                                            <span class="item-product">
                                                <img class="svg invisible" src="/prestashop/PRS21/PRS210518/default/modules/blockreassurance/views/img/reassurance/pack2/security.svg">
                                                &nbsp;
                                            </span>
                                            <span class="block-title" style="color:#000000;">Security policy</span>
                                            <p style="color:#000000;">(edit with the Customer Reassurance module)</p>
                                        </div>
                                        <div>
                                            <span class="item-product">
                                                <img class="svg invisible" src="/prestashop/PRS21/PRS210518/default/modules/blockreassurance/views/img/reassurance/pack2/carrier.svg">
                                                &nbsp;
                                            </span>
                                            <span class="block-title" style="color:#000000;">Delivery policy</span>
                                            <p style="color:#000000;">(edit with the Customer Reassurance module)</p>
                                        </div>
                                        <div>
                                            <span class="item-product">
                                                <img class="svg invisible" src="/prestashop/PRS21/PRS210518/default/modules/blockreassurance/views/img/reassurance/pack2/parcel.svg">
                                                &nbsp;
                                            </span>
                                            <span class="block-title" style="color:#000000;">Return policy</span>
                                            <p style="color:#000000;">(edit with the Customer Reassurance module)</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>

        <?php include_once __DIR__ . '/includes/footer.php'; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Particles.js Library -->
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        <!-- Paystack Script -->
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script>
        // Promo code handling
        document.addEventListener('DOMContentLoaded', function() {
            // Paystack payment handling
            const payButton = document.getElementById('payButton');
            const paymentLoading = document.getElementById('paymentLoading');
            const paymentError = document.getElementById('paymentError');
            const errorMessage = document.getElementById('errorMessage');
            
            if (payButton) {
                payButton.addEventListener('click', function() {
                    // Show loading
                    paymentLoading.style.display = 'block';
                    paymentError.style.display = 'none';
                    payButton.disabled = true;
                    
                    // Initialize Paystack payment
                    const handler = PaystackPop.setup({
                        key: '<?= $publicKey ?>',
                        email: '<?= $user_details['email'] ?? '' ?>',
                        amount: <?= (int)($order['total_amount'] * 100) ?>, // Amount in kobo
                        currency: 'KES',
                        ref: '<?= $reference ?>',
                        callback: function(response) {
                            // Payment successful
                            console.log('Paystack callback triggered with response:', response);
                            
                            // Set success flag to prevent onClose from showing error
                            window.paymentSuccessTriggered = true;
                            
                            // Verify payment with backend first
                            verifyPayment(response.reference);
                        },
                        onClose: function() {
                            // Payment modal closed - check if it was cancelled or failed
                            console.log('Paystack modal closed, paymentSuccessTriggered:', window.paymentSuccessTriggered);
                            
                            // Clear error checking interval
                            if (window.errorCheckInterval) {
                                clearInterval(window.errorCheckInterval);
                                window.errorCheckInterval = null;
                            }
                            
                            // Check if there was a recent error or cancellation
                            setTimeout(() => {
                                // If no success callback was triggered, it was likely cancelled
                                if (!window.paymentSuccessTriggered) {
                                    console.log('Payment was cancelled by user');
                                    showError('Payment was cancelled. Please try again or contact support if you need assistance.');
                                }
                            }, 100);
                            
                            // Hide loading and enable button
                            paymentLoading.style.display = 'none';
                            payButton.disabled = false;
                        }
                    });
                    
                    // Reset payment success flag
                    window.paymentSuccessTriggered = false;
                    
                    // Open the payment popup
                    handler.openIframe();
                });
            }
            
            function verifyPayment(reference) {
                // Show loading
                paymentLoading.style.display = 'block';
                paymentError.style.display = 'none';
                
                console.log('Starting payment verification for reference:', reference);
                
                fetch('paystack/verify-inline-payment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ reference: reference })
                })
                .then(response => {
                    console.log('Payment verification response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Payment verification response data:', data);
                    paymentLoading.style.display = 'none';
                    
                    if (data.success) {
                        // Payment successful - show success message and redirect
                        console.log('Payment successful, redirecting to orders page');
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful!',
                            text: 'Your order has been confirmed and payment processed successfully.',
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            // Redirect to orders page
                            window.location.href = 'orders.php?payment_success=true&reference=' + reference;
                        });
                    } else {
                        // Payment failed - show specific error message
                        console.log('Payment failed:', data.message);
                        let errorMsg = data.message || 'Payment verification failed';
                        
                        // Handle specific error types for better user experience
                        if (data.transaction_status === 'cancelled' || data.transaction_status === 'abandoned') {
                            errorMsg = 'Payment was cancelled. Please try again.';
                        } else if (data.message && data.message.includes('Incorrect PIN')) {
                            errorMsg = 'Incorrect PIN or password entered. Please try again.';
                        } else if (data.message && data.message.includes('Insufficient funds')) {
                            errorMsg = 'Insufficient funds in your account. Please check your balance.';
                        } else if (data.message && data.message.includes('Network error')) {
                            errorMsg = 'Network error occurred. Please try again.';
                        } else if (data.message && data.message.includes('Mobile money')) {
                            errorMsg = 'Mobile money payment error. Please try using a card or bank transfer.';
                        } else if (data.message && data.message.includes('Unable to process')) {
                            errorMsg = 'Payment processing error. Please try a different payment method.';
                        }
                        
                        showError(errorMsg);
                    }
                })
                .catch(error => {
                    console.error('Payment verification error:', error);
                    paymentLoading.style.display = 'none';
                    showError('Network error. Please try again.');
                });
            }
            
            function showError(message) {
                errorMessage.textContent = message;
                paymentError.style.display = 'block';
                paymentLoading.style.display = 'none';
                payButton.disabled = false;
                
                // Auto-hide error after 15 seconds
                setTimeout(() => {
                    paymentError.style.display = 'none';
                }, 15000);
                
                // Scroll to error message
                paymentError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            function retryPayment() {
                // Hide error and retry payment
                paymentError.style.display = 'none';
                payButton.click();
            }
            
            function hideError() {
                // Hide error message
                paymentError.style.display = 'none';
            }
            
            const promoForm = document.getElementById('promo-form');
            if (promoForm) {
                promoForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const form = this;
                    const promoInput = form.querySelector('input[name="promo_code"]');
                    const errorDiv = form.closest('.promo-code').querySelector('.js-error');
                    const errorText = errorDiv ? errorDiv.querySelector('.js-error-text') : null;
                    const submitBtn = form.querySelector('button[type="submit"]');
                    
                    // Clear previous errors
                    if (errorDiv) {
                        errorDiv.style.display = 'none';
                    }
                    if (errorText) {
                        errorText.textContent = '';
                    }
                    
                    // Validate input
                    if (!promoInput.value.trim()) {
                        if (errorText) {
                            errorText.textContent = 'Please enter a promo code';
                        }
                        if (errorDiv) {
                            errorDiv.style.display = 'block';
                        }
                        return;
                    }
                    
                    // Show loading state
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Applying...';
                    submitBtn.disabled = true;
                    
                    // Create form data
                    const formData = new FormData(form);
                    
                    // Make the AJAX request
                    fetch('ajax/apply_promo.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new URLSearchParams(formData)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text().then(text => {
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                console.error('Invalid JSON response:', text);
                                throw new Error('Invalid server response');
                            }
                        });
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Reload the page to update all totals
                                window.location.reload();
                            });
                        } else {
                            // Show error message
                            if (errorText) {
                                errorText.textContent = data.message || 'Failed to apply promo code';
                            }
                            if (errorDiv) {
                                errorDiv.style.display = 'block';
                            }
                            
                            // Show error in SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message || 'Failed to apply promo code'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Show error message
                        if (errorText) {
                            errorText.textContent = 'An error occurred. Please try again.';
                        }
                        if (errorDiv) {
                            errorDiv.style.display = 'block';
                        }
                        
                        // Show error in SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while applying the promo code. Please try again.'
                        });
                    })
                    .finally(() => {
                        // Reset button state
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.disabled = false;
                    });
                });
            }

            // Handle promo code removal
            const removePromoBtn = document.querySelector('.remove-promo');
            if (removePromoBtn) {
                removePromoBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const removeBtn = this;
                    const originalBtnHtml = removeBtn.innerHTML;
                    
                    // Show loading state
                    removeBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                    removeBtn.disabled = true;
                    
                    fetch('ajax/remove_promo.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text().then(text => {
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                console.error('Invalid JSON response:', text);
                                throw new Error('Invalid server response');
                            }
                        });
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Reload the page to update the promo code display
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Failed to remove promo code');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Show error in SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: error.message || 'An error occurred while removing the promo code. Please try again.'
                        });
                    })
                    .finally(() => {
                        // Reset button state
                        removeBtn.innerHTML = originalBtnHtml;
                        removeBtn.disabled = false;
                    });
                });
            }

            // Handle Paystack errors
            window.addEventListener('message', function(event) {
                if (event.origin !== 'https://checkout.paystack.com') return;
                
                const data = event.data;
                
                if (data.status === 'success') {
                    // Payment successful
                    if (!window.paymentSuccessTriggered) {
                        window.paymentSuccessTriggered = true;
                        clearInterval(window.errorCheckInterval);
                        window.errorCheckInterval = null;
                        
                        // Verify payment with backend
                        verifyPayment(data.reference);
                    }
                } else if (data.status === 'error' || data.status === 'cancelled') {
                    // Payment failed or cancelled
                    if (!window.paymentSuccessTriggered) {
                        window.paymentSuccessTriggered = true;
                        clearInterval(window.errorCheckInterval);
                        window.errorCheckInterval = null;
                        
                        let errorMessage = 'Payment was cancelled or failed';
                        
                        if (data.message) {
                            // Handle specific error messages for better user experience
                            const message = data.message.toLowerCase();
                            
                            if (message.includes('unable to process transaction') || 
                                message.includes('400 bad request')) {
                                errorMessage = 'Payment processing error. Please try a different payment method.';
                            } else if (message.includes('mobile_money')) {
                                errorMessage = 'Mobile money payment error. Please try using a card or bank transfer.';
                            } else if (message.includes('incorrect pin') || message.includes('wrong pin')) {
                                errorMessage = 'Incorrect PIN or password entered. Please try again.';
                            } else if (message.includes('insufficient funds')) {
                                errorMessage = 'Insufficient funds in your account. Please check your balance.';
                            } else if (message.includes('network error') || message.includes('connection')) {
                                errorMessage = 'Network error occurred. Please try again.';
                            } else if (message.includes('cancelled') || message.includes('abandoned')) {
                                errorMessage = 'Payment was cancelled. Please try again.';
                            } else if (message.includes('declined') || message.includes('failed')) {
                                errorMessage = 'Payment was declined. Please try again or use a different payment method.';
                            } else {
                                errorMessage = data.message;
                            }
                        }
                        
                        showError(errorMessage);
                    }
                }
            });
            
            // Listen for console errors to catch API errors
            const originalError = console.error;
            console.error = function(...args) {
                const errorMessage = args.join(' ');
                
                // Check for specific Paystack errors
                if (errorMessage.includes('Unable to process transaction') || 
                    errorMessage.includes('400 (Bad Request)') ||
                    errorMessage.includes('mobile_money') ||
                    errorMessage.includes('incorrect pin') ||
                    errorMessage.includes('wrong pin') ||
                    errorMessage.includes('insufficient funds') ||
                    errorMessage.includes('network error') ||
                    errorMessage.includes('connection error') ||
                    errorMessage.includes('cancelled') ||
                    errorMessage.includes('abandoned') ||
                    errorMessage.includes('declined')) {
                    
                    if (!window.paymentSuccessTriggered) {
                        window.paymentSuccessTriggered = true;
                        clearInterval(window.errorCheckInterval);
                        window.errorCheckInterval = null;
                        
                        let userMessage = 'Payment processing error. Please try a different payment method.';
                        
                        // Provide specific error messages based on the error type
                        if (errorMessage.includes('mobile_money')) {
                            userMessage = 'Mobile money payment error. Please try using a card or bank transfer instead.';
                        } else if (errorMessage.includes('incorrect pin') || errorMessage.includes('wrong pin')) {
                            userMessage = 'Incorrect PIN or password entered. Please try again.';
                        } else if (errorMessage.includes('insufficient funds')) {
                            userMessage = 'Insufficient funds in your account. Please check your balance.';
                        } else if (errorMessage.includes('network error') || errorMessage.includes('connection error')) {
                            userMessage = 'Network error occurred. Please try again.';
                        } else if (errorMessage.includes('cancelled') || errorMessage.includes('abandoned')) {
                            userMessage = 'Payment was cancelled. Please try again.';
                        } else if (errorMessage.includes('declined')) {
                            userMessage = 'Payment was declined. Please try again or use a different payment method.';
                        }
                        
                        showError(userMessage);
                    }
                }
                
                // Call original console.error
                originalError.apply(console, args);
            };
            
            // Fireworks Configuration
            const fireworksConfig = {
                particles: {
                    number: {
                        value: 0,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: ["#ff0000", "#00ff00", "#0000ff", "#ffff00", "#ff00ff", "#00ffff"]
                    },
                    shape: {
                        type: "circle",
                        stroke: {
                            width: 0,
                            color: "#000000"
                        },
                        polygon: {
                            nb_sides: 5
                        }
                    },
                    opacity: {
                        value: 1,
                        random: false,
                        anim: {
                            enable: false,
                            speed: 1,
                            opacity_min: 0.1,
                            sync: false
                        }
                    },
                    size: {
                        value: 3,
                        random: true,
                        anim: {
                            enable: false,
                            speed: 40,
                            size_min: 0.1,
                            sync: false
                        }
                    },
                    line_linked: {
                        enable: false,
                        distance: 150,
                        color: "#ffffff",
                        opacity: 0.4,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 6,
                        direction: "none",
                        random: false,
                        straight: false,
                        out_mode: "out",
                        bounce: false,
                        attract: {
                            enable: false,
                            rotateX: 600,
                            rotateY: 1200
                        }
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: {
                            enable: true,
                            mode: "repulse"
                        },
                        onclick: {
                            enable: true,
                            mode: "push"
                        },
                        resize: true
                    },
                    modes: {
                        grab: {
                            distance: 400,
                            line_linked: {
                                opacity: 1
                            }
                        },
                        bubble: {
                            distance: 400,
                            size: 40,
                            duration: 2,
                            opacity: 8,
                            speed: 3
                        },
                        repulse: {
                            distance: 200,
                            duration: 0.4
                        },
                        push: {
                            particles_nb: 4
                        },
                        remove: {
                            particles_nb: 2
                        }
                    }
                },
                retina_detect: true
            };
            
            // Initialize fireworks
            let fireworksParticles;
            
            function initFireworks() {
                const container = document.getElementById('fireworks-container');
                container.style.display = 'block';
                
                fireworksParticles = particlesJS('fireworks-container', fireworksConfig);
            }
            
            function stopFireworks() {
                if (fireworksParticles) {
                    fireworksParticles.destroy();
                }
                const container = document.getElementById('fireworks-container');
                container.style.display = 'none';
            }
            
            // Success function with fireworks
            function showSuccess() {
                // Show fireworks
                initFireworks();
                
                // Show success overlay after a short delay
                setTimeout(() => {
                    const overlay = document.getElementById('successOverlay');
                    overlay.style.display = 'flex';
                    overlay.style.pointerEvents = 'auto';
                }, 500);
                
                // Stop fireworks after 5 seconds
                setTimeout(() => {
                    stopFireworks();
                }, 5000);
            }
            
            // Function to hide success overlay
            function hideSuccess() {
                const overlay = document.getElementById('successOverlay');
                overlay.style.display = 'none';
                overlay.style.pointerEvents = 'none';
                stopFireworks();
            }
        });
        </script>
    </div>
    
    <!-- Fireworks Container -->
    <div id="fireworks-container"></div>
    
    <!-- Success Overlay -->
    <div class="success-overlay" id="successOverlay">
        <div class="success-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="success-title">Payment Successful!</div>
            <div class="success-message">
                Your order has been confirmed and payment processed successfully.
                <br>You will receive a confirmation email shortly.
            </div>
            <div class="success-actions">
                <button class="success-btn primary" onclick="window.location.href='orders.php'">
                    <i class="fas fa-shopping-bag"></i> View Orders
                </button>
                <button class="success-btn secondary" onclick="window.location.href='index.php'">
                    <i class="fas fa-home"></i> Continue Shopping
                </button>
            </div>
        </div>
    </div>
</body>
</html>