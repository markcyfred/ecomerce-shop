<?php
/**
 * Paystack Payment Success Page
 * 
 * This page is displayed after a successful payment.
 * It shows a success message and waits for user to continue.
 */

session_start();
require_once __DIR__ . '/../admin/config/dbcon.php';

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    header('Location: ../login.php');
    exit();
}

// Get token from URL
$token = $_GET['token'] ?? '';
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

// Get payment details
$stmt = $conn->prepare("SELECT * FROM paystack_transactions WHERE order_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("i", $order['id']);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();
$stmt->close();

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

$payment_method = getPaymentMethodDisplayName($payment['payment_method'] ?? 'unknown');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Order #<?= htmlspecialchars($order['shipment_number']) ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }

        .success-icon i {
            font-size: 40px;
            color: white;
        }

        h1 {
            color: #28a745;
            margin-bottom: 10px;
            font-size: 2em;
        }

        .order-number {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .payment-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }

        .payment-details h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.2em;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        .amount {
            color: #28a745;
            font-size: 1.2em;
        }

        .payment-method-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9em;
        }

        .payment-method-mpesa {
            background: #00a651;
        }

        .payment-method-card {
            background: #007bff;
        }

        .payment-method-bank {
            background: #6c757d;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-outline {
            background: transparent;
            color: #007bff;
            border: 2px solid #007bff;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .countdown {
            margin-top: 20px;
            color: #666;
            font-size: 0.9em;
        }

        .countdown-number {
            color: #007bff;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .success-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1>Payment Successful!</h1>
        <div class="order-number">Order #<?= htmlspecialchars($order['shipment_number']) ?></div>
        
        <div class="payment-details">
            <h3><i class="fas fa-credit-card"></i> Payment Details</h3>
            
            <div class="detail-row">
                <span class="detail-label">Amount Paid:</span>
                <span class="detail-value amount">Kes <?= number_format($order['total_amount'], 2) ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Payment Method:</span>
                <span class="payment-method-badge payment-method-<?= strtolower(str_replace(['/', ' ', '-'], '_', $payment_method)) ?>">
                    <i class="fas fa-<?= strpos(strtolower($payment_method), 'card') !== false ? 'credit-card' : (strpos(strtolower($payment_method), 'mpesa') !== false ? 'mobile-alt' : 'money-bill-wave') ?>"></i>
                    <?= htmlspecialchars($payment_method) ?>
                </span>
            </div>
            
            <?php if ($payment): ?>
            <div class="detail-row">
                <span class="detail-label">Payment Reference:</span>
                <span class="detail-value"><?= htmlspecialchars($payment['reference']) ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Payment Date:</span>
                <span class="detail-value"><?= date('M d, Y H:i', strtotime($payment['created_at'])) ?></span>
            </div>
            <?php endif; ?>
            
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value" style="color: #28a745; font-weight: bold;">COMPLETED</span>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="../customer-receipts.php?token=<?= urlencode($token) ?>" class="btn btn-success">
                <i class="fas fa-receipt"></i> View Receipt
            </a>
            <a href="../order-details.php?token=<?= urlencode($token) ?>" class="btn btn-primary">
                <i class="fas fa-eye"></i> Order Details
            </a>
            <a href="../orders.php" class="btn btn-outline">
                <i class="fas fa-list"></i> All Orders
            </a>
        </div>
        
        <div class="countdown">
            <p>Redirecting to orders page in <span class="countdown-number" id="countdown">10</span> seconds...</p>
            <p><small>Or click any button above to continue immediately</small></p>
        </div>
    </div>

    <script>
        // Countdown timer
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');
        
        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = '../orders.php';
            }
        }, 1000);
        
        // Stop countdown if user clicks any button
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', () => {
                clearInterval(timer);
            });
        });
    </script>
</body>
</html> 