<?php
/**
 * Verify Inline Payment
 * 
 * This file handles verification of inline Paystack payments via AJAX
 */

session_start();
require_once __DIR__ . '/../admin/config/dbcon.php';
require_once __DIR__ . '/PaystackHelper.php';

// Set JSON response header
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User not authenticated'
    ]);
    exit();
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit();
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$reference = $input['reference'] ?? '';

if (empty($reference)) {
    echo json_encode([
        'success' => false,
        'message' => 'No reference provided'
    ]);
    exit();
}

try {
    // Initialize Paystack helper
    $paystack = new PaystackHelper($conn);
    
    // Verify the transaction with Paystack
    $verification = $paystack->verifyTransaction($reference);
    
    if (!$verification['status']) {
        // Check for specific error types
        $errorMessage = $verification['message'] ?? 'Failed to verify transaction';
        
        if (strpos(strtolower($errorMessage), 'unable to process transaction') !== false) {
            echo json_encode([
                'success' => false,
                'message' => 'Too many failed attempts. Please wait a few minutes before trying again.',
                'original_message' => $errorMessage
            ]);
        } else if (strpos(strtolower($errorMessage), 'rate limit') !== false || strpos(strtolower($errorMessage), 'too many requests') !== false) {
            echo json_encode([
                'success' => false,
                'message' => 'Too many payment attempts. Please wait a few minutes before trying again.',
                'original_message' => $errorMessage
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to verify transaction: ' . $errorMessage
            ]);
        }
        exit();
    }
    
    $transaction = $verification['data'];
    
    // Check if payment was successful
    if ($verification['status'] && $verification['data']['status'] === 'success') {
        // Payment successful - update order status and insert transaction record
        
        // Debug logging
        error_log("Payment verification successful for reference: " . $reference);
        error_log("Session data: " . print_r($_SESSION['inline_payment_data'] ?? 'No session data', true));
        
        // First, try to get order data from session
        $orderData = $_SESSION['inline_payment_data'] ?? null;
        $orderId = null;
        
        if ($orderData && isset($orderData['order_id'])) {
            $orderId = $orderData['order_id'];
            error_log("Found order_id from session: " . $orderId);
        } else {
            // Try to extract from Paystack metadata
            $metadata = $transaction['metadata'] ?? [];
            $orderId = $metadata['order_id'] ?? null;
            error_log("Trying to get order_id from metadata: " . ($orderId ?? 'Not found'));
            
            // If still no order_id, try to find by reference pattern
            if (!$orderId) {
                // Extract token from reference (PS_timestamp_token format)
                $parts = explode('_', $reference);
                if (count($parts) >= 3) {
                    $token = $parts[2];
                    error_log("Extracting token from reference: " . $token);
                    $stmt = $conn->prepare("SELECT id FROM checkout WHERE token = ?");
                    $stmt->bind_param("s", $token);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $order = $result->fetch_assoc();
                    $stmt->close();
                    
                    if ($order) {
                        $orderId = $order['id'];
                        error_log("Found order_id from token lookup: " . $orderId);
                    } else {
                        error_log("No order found for token: " . $token);
                    }
                }
            }
        }
        
        if ($orderId) {
            // Update order status to paid
            $updateSql = "UPDATE checkout SET status = 'paid' WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("i", $orderId);
            $updateResult = $updateStmt->execute();
            $updateStmt->close();
            
            error_log("Order status update result: " . ($updateResult ? 'Success' : 'Failed'));
            
            // Insert transaction record
            $amount = $transaction['amount'] / 100; // Convert from kobo to naira
            $paymentMethod = 'unknown'; // Will be extracted by PaystackHelper
            
            // Extract payment method from transaction data
            if (isset($transaction['authorization']['channel'])) {
                $channel = strtolower($transaction['authorization']['channel']);
                if ($channel === 'mobile_money') {
                    $paymentMethod = 'mpesa';
                } elseif ($channel === 'card') {
                    $paymentMethod = 'card';
                } elseif ($channel === 'bank') {
                    $paymentMethod = 'bank';
                }
            }
            
            $insertSql = "INSERT INTO paystack_transactions 
                         (reference, order_id, user_id, amount, currency, status, payment_method, gateway_response, paid_at) 
                         VALUES (?, ?, ?, ?, 'KES', 'success', ?, ?, NOW())";
            
            $insertStmt = $conn->prepare($insertSql);
            $gatewayResponse = json_encode($transaction);
            $insertStmt->bind_param("siidss", $reference, $orderId, $_SESSION['auth_user']['id'], $amount, $paymentMethod, $gatewayResponse);
            $insertResult = $insertStmt->execute();
            $insertStmt->close();
            
            error_log("Transaction insert result: " . ($insertResult ? 'Success' : 'Failed'));
            
            // Clean up session data
            unset($_SESSION['inline_payment_data']);
            
            echo json_encode([
                'success' => true,
                'status' => 'success',
                'message' => 'Payment completed successfully!',
                'reference' => $reference,
                'amount' => $amount,
                'currency' => $transaction['currency'],
                'order_id' => $orderId
            ]);
        } else {
            error_log("No order_id found for reference: " . $reference);
            echo json_encode([
                'success' => false,
                'status' => 'error',
                'message' => 'Order data not found. Please contact support.'
            ]);
        }
    } else {
        // Payment failed or pending
        $transactionData = $verification['data'] ?? [];
        $failureReason = $transactionData['failure_reason'] ?? '';
        $gatewayResponse = $transactionData['gateway_response'] ?? '';
        $transactionStatus = $transactionData['status'] ?? 'unknown';
        
        // Determine specific error message
        $errorMessage = 'Payment verification failed';
        
        if (strpos(strtolower($failureReason), 'incorrect pin') !== false || 
            strpos(strtolower($gatewayResponse), 'incorrect pin') !== false ||
            strpos(strtolower($failureReason), 'wrong pin') !== false ||
            strpos(strtolower($gatewayResponse), 'wrong pin') !== false) {
            $errorMessage = 'Incorrect PIN or password entered. Please try again.';
        } elseif (strpos(strtolower($failureReason), 'insufficient funds') !== false || 
                 strpos(strtolower($gatewayResponse), 'insufficient funds') !== false) {
            $errorMessage = 'Insufficient funds in your account. Please check your balance.';
        } elseif (strpos(strtolower($failureReason), 'network') !== false || 
                 strpos(strtolower($gatewayResponse), 'network') !== false) {
            $errorMessage = 'Network error occurred during payment. Please try again.';
        } elseif (strpos(strtolower($failureReason), 'mobile_money') !== false || 
                 strpos(strtolower($gatewayResponse), 'mobile_money') !== false) {
            $errorMessage = 'Mobile money payment error. Please try using a card or bank transfer.';
        } elseif (strpos(strtolower($failureReason), 'unable to process') !== false || 
                 strpos(strtolower($gatewayResponse), 'unable to process') !== false) {
            $errorMessage = 'Payment processing error. Please try a different payment method.';
        } elseif ($transactionStatus === 'abandoned' || $transactionStatus === 'cancelled') {
            $errorMessage = 'Payment was cancelled or abandoned. Please try again.';
        } elseif ($transactionStatus === 'failed') {
            $errorMessage = 'Payment failed. Please try again or contact support.';
        } elseif ($transactionStatus === 'pending') {
            $errorMessage = 'Payment is still being processed. Please wait a few minutes and check again.';
        }
        
        echo json_encode([
            'success' => false,
            'status' => 'failed',
            'message' => $errorMessage,
            'failure_reason' => $failureReason,
            'gateway_response' => $gatewayResponse,
            'transaction_status' => $transactionStatus
        ]);
    }
    
} catch (Exception $e) {
    // Log error
    error_log("Inline payment verification error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while verifying the payment'
    ]);
}
?> 