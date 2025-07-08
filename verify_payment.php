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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    if (!empty($token)) {
        // Search by token
        $stmt = $conn->prepare("SELECT * FROM checkout WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $order_details = $result->fetch_assoc();
        $stmt->close();
        
        if ($order_details) {
            // Check Paystack transactions
            $stmt = $conn->prepare("SELECT * FROM paystack_transactions WHERE order_id = ? ORDER BY created_at DESC LIMIT 1");
            $stmt->bind_param("i", $order_details['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $payment_status = $result->fetch_assoc();
            $stmt->close();
            
            if ($payment_status) {
                $message = "Payment found! Status: " . ucfirst($payment_status['status']);
            } else {
                $message = "Order found but no payment record found. Please try the payment again.";
            }
        } else {
            $message = "Order not found with this token.";
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
        } else {
            $message = "No orders found for this email.";
        }
    } else {
        $message = "Please provide either a token or email address.";
    }
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                    
                    <form method="POST" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>
                                Verify Payment
                            </button>
                        </div>
                    </form>
                    
                    <?php if ($order_details): ?>
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-shopping-cart me-2"></i>Order Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Order Reference:</strong> <?= htmlspecialchars($order_details['shipment_number']) ?></p>
                                        <p><strong>Total Amount:</strong> Kes <?= number_format($order_details['total_amount'], 2) ?></p>
                                        <p><strong>Order Status:</strong> 
                                            <span class="status-<?= $order_details['status'] === 'paid' ? 'success' : 'pending' ?>">
                                                <?= ucfirst($order_details['status']) ?>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Order Date:</strong> <?= date('M d, Y H:i', strtotime($order_details['created_at'])) ?></p>
                                        <p><strong>Delivery Address:</strong> <?= htmlspecialchars($order_details['destination']) ?></p>
                                    </div>
                                </div>
                                
                                <?php if ($payment_status): ?>
                                    <hr>
                                    <h6><i class="fas fa-credit-card me-2"></i>Payment Details</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Payment Reference:</strong> <?= htmlspecialchars($payment_status['reference']) ?></p>
                                            <p><strong>Payment Status:</strong> 
                                                <span class="status-<?= $payment_status['status'] === 'success' ? 'success' : ($payment_status['status'] === 'failed' ? 'failed' : 'pending') ?>">
                                                    <?= ucfirst($payment_status['status']) ?>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Amount Paid:</strong> Kes <?= number_format($payment_status['amount'], 2) ?></p>
                                            <p><strong>Payment Date:</strong> <?= $payment_status['paid_at'] ? date('M d, Y H:i', strtotime($payment_status['paid_at'])) : 'Not paid yet' ?></p>
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
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="alert alert-warning mt-3">
                                        <h6><i class="fas fa-exclamation-triangle me-2"></i>No Payment Record Found</h6>
                                        <p>No payment has been made for this order yet. Please proceed with the payment.</p>
                                        <a href="order-confirmation.php?token=<?= urlencode($order_details['token']) ?>" class="btn btn-primary">
                                            <i class="fas fa-credit-card me-1"></i>Proceed to Payment
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
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
</body>
</html> 