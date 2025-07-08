<?php
/**
 * Paystack Payment Failure Page
 * 
 * This page is displayed after a failed payment attempt.
 * It shows the error message and allows the user to retry or go back.
 */

session_start();

$reference = $_GET['reference'] ?? '';
$error = $_GET['error'] ?? 'Payment failed.';

// Clean up error message for user display
$error_display = htmlspecialchars($error);
if (stripos($error_display, 'approved') !== false) {
    $error_display = 'Payment failed or was not approved.';
}
if (stripos($error_display, 'insufficient') !== false) {
    $error_display = 'Insufficient funds.';
}
if (stripos($error_display, 'declined') !== false) {
    $error_display = 'Payment was declined.';
}
if (stripos($error_display, 'cancelled') !== false) {
    $error_display = 'Payment was cancelled.';
}
if (stripos($error_display, 'wrong') !== false || stripos($error_display, 'pin') !== false) {
    $error_display = 'Wrong PIN or password.';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fail-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 40px 30px;
            text-align: center;
            max-width: 420px;
            width: 100%;
        }
        .fail-icon {
            width: 70px;
            height: 70px;
            background: #dc3545;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }
        .fail-icon i {
            font-size: 36px;
            color: white;
        }
        h1 {
            color: #dc3545;
            margin-bottom: 10px;
            font-size: 2em;
        }
        .error-message {
            color: #333;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 18px;
            font-size: 1.1em;
        }
        .reference {
            color: #888;
            font-size: 0.95em;
            margin-bottom: 18px;
        }
        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 18px;
            flex-wrap: wrap;
        }
        .btn {
            padding: 12px 22px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-outline {
            background: transparent;
            color: #007bff;
            border: 2px solid #007bff;
        }
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        @media (max-width: 600px) {
            .fail-container {
                padding: 25px 8px;
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
    <div class="fail-container">
        <div class="fail-icon">
            <i class="fas fa-times"></i>
        </div>
        <h1>Payment Failed</h1>
        <div class="error-message">
            <?= $error_display ?>
        </div>
        <div class="reference">
            <strong>Reference:</strong> <?= htmlspecialchars($reference) ?>
        </div>
        <div class="action-buttons">
            <a href="javascript:window.history.back();" class="btn btn-primary">
                <i class="fas fa-undo"></i> Retry Payment
            </a>
            <a href="../orders.php" class="btn btn-outline">
                <i class="fas fa-list"></i> Back to Orders
            </a>
        </div>
    </div>
</body>
</html> 