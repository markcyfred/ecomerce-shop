<?php
/**
 * Paystack Payment Failure Page
 * 
 * This page is displayed when a payment fails or is cancelled.
 */

session_start();
require_once __DIR__ . '/../admin/config/dbcon.php';

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    header('Location: ../login.php');
    exit();
}

// Get token and error from URL
$token = $_GET['token'] ?? '';
$error = $_GET['error'] ?? 'Payment was not completed';
$user_id = $_SESSION['auth_user']['id'];

if (empty($token)) {
    header('Location: ../index.php?error=Invalid order token');
    exit();
}

// Get order details
$stmt = $conn->prepare("SELECT * FROM checkout WHERE token = ? AND user_id = ?");
$stmt->bind_param("si", $token, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    header('Location: ../index.php?error=Order not found');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - Order Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .failure-icon {
            color: #dc3545;
            font-size: 4rem;
        }
        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .alert-custom {
            border-left: 4px solid #dc3545;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="failure-icon mb-3">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h2 class="text-danger mb-3">Payment Failed</h2>
                        <p class="lead">We're sorry, but your payment could not be processed.</p>
                        <div class="alert alert-danger alert-custom">
                            <strong>Error:</strong> <?= htmlspecialchars($error) ?>
                        </div>
                    </div>
                </div>

                <div class="order-details">
                    <h4><i class="fas fa-info-circle me-2"></i>Order Information</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Order Reference:</strong> <?= htmlspecialchars($order['shipment_number']) ?></p>
                            <p><strong>Order Date:</strong> <?= date('F j, Y', strtotime($order['created_at'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Order Status:</strong> <span class="badge bg-warning">Pending Payment</span></p>
                            <p><strong>Total Amount:</strong> Kes <?= number_format($order['total_amount'], 2) ?></p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <h5><i class="fas fa-lightbulb me-2"></i>What You Can Do</h5>
                    <ul class="mb-0">
                        <li>Try the payment again using a different payment method</li>
                        <li>Check that your card details are correct</li>
                        <li>Ensure you have sufficient funds in your account</li>
                        <li>Contact your bank if you're experiencing issues</li>
                        <li>Contact our customer support for assistance</li>
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <a href="initialize.php?token=<?= urlencode($token) ?>" class="btn btn-primary me-2">
                        <i class="fas fa-credit-card me-1"></i>Try Payment Again
                    </a>
                    <a href="../order-confirmation.php?token=<?= urlencode($token) ?>" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-eye me-1"></i>View Order Details
                    </a>
                    <a href="../index.php" class="btn btn-outline-primary">
                        <i class="fas fa-home me-1"></i>Continue Shopping
                    </a>
                </div>

                <div class="alert alert-warning mt-4">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Important Notice</h5>
                    <p class="mb-0">
                        Your order is still pending. If you don't complete the payment within 24 hours, 
                        your order may be automatically cancelled. You can always try the payment again 
                        or contact us for assistance.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 