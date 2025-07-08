<?php
/**
 * Paystack Callback Handler
 * 
 * This file handles Paystack webhook callbacks and processes successful payments
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/PaystackHelper.php';
require_once __DIR__ . '/../admin/config/dbcon.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    // Get the reference from the callback
    $reference = $_GET['reference'] ?? $_POST['reference'] ?? '';
    
    if (empty($reference)) {
        throw new Exception('No reference provided in callback');
    }
    
    // Initialize Paystack helper
    $paystack = new PaystackHelper($conn);
    
    // Verify the transaction with Paystack
    $verification = $paystack->verifyTransaction($reference);
    
    if (!$verification['status']) {
        throw new Exception('Failed to verify transaction: ' . $verification['message']);
    }
    
    $transaction = $verification['data'];
    
    // Check if payment was successful
    if ($transaction['status'] === 'success') {
        // Get order details from session or database
        $orderData = null;
        if (isset($_SESSION['paystack_pending_transactions'][$reference])) {
            $orderData = $_SESSION['paystack_pending_transactions'][$reference]['order_data'];
            // Clean up session data immediately
            unset($_SESSION['paystack_pending_transactions'][$reference]);
        }
        
        // Update order status to paid
        if ($orderData) {
            $orderId = $orderData['order_id'];
            $sql = "UPDATE checkout SET status = 'paid' WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $stmt->close();
            
            // Redirect to success page with order token (let success page handle the countdown)
            $orderToken = $orderData['checkout_token'] ?? '';
            if ($orderToken) {
                header('Location: success.php?token=' . urlencode($orderToken));
            } else {
                // Fallback: set success message and redirect to orders page
                $_SESSION['message'] = "Payment successful! Your order has been confirmed.";
                $_SESSION['message_type'] = "success";
                header('Location: ../orders.php');
            }
            exit();
        } else {
            // Try to get order data from paystack_transactions table
            $stmt = $conn->prepare("SELECT order_id FROM paystack_transactions WHERE reference = ?");
            $stmt->bind_param("s", $reference);
            $stmt->execute();
            $result = $stmt->get_result();
            $transaction_record = $result->fetch_assoc();
            $stmt->close();
            
            if ($transaction_record) {
                // Update order status to paid
                $orderId = $transaction_record['order_id'];
                $sql = "UPDATE checkout SET status = 'paid' WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $orderId);
                $stmt->execute();
                $stmt->close();
                
                // Get order token for redirect
                $stmt = $conn->prepare("SELECT token FROM checkout WHERE id = ?");
                $stmt->bind_param("i", $orderId);
                $stmt->execute();
                $result = $stmt->get_result();
                $order = $result->fetch_assoc();
                $stmt->close();
                
                if ($order && $order['token']) {
                    header('Location: success.php?token=' . urlencode($order['token']));
                } else {
                    $_SESSION['message'] = "Payment successful! Your order has been confirmed.";
                    $_SESSION['message_type'] = "success";
                    header('Location: ../orders.php');
                }
                exit();
            } else {
                // Fallback: redirect to orders page
                $_SESSION['message'] = "Payment successful! Please check your orders.";
                $_SESSION['message_type'] = "success";
                header('Location: ../orders.php');
                exit();
            }
        }
        
    } else {
        // Payment failed or pending
        $error_message = $transaction['gateway_response'] ?? ucfirst($transaction['status']);
        
        // Get order data to redirect to failure page with token
        $orderData = null;
        if (isset($_SESSION['paystack_pending_transactions'][$reference])) {
            $orderData = $_SESSION['paystack_pending_transactions'][$reference]['order_data'];
            unset($_SESSION['paystack_pending_transactions'][$reference]);
        }
        
        if ($orderData && isset($orderData['checkout_token'])) {
            // Redirect to failure page with order token
            header('Location: failure.php?token=' . urlencode($orderData['checkout_token']) . '&error=' . urlencode($error_message));
        } else {
            // Fallback: redirect to fail page with error message and reference
            header('Location: fail.php?reference=' . urlencode($reference) . '&error=' . urlencode($error_message));
        }
        exit();
    }
    
} catch (Exception $e) {
    // Log error
    error_log("Paystack callback error: " . $e->getMessage());
    
    // Set error message and redirect to orders page
    $_SESSION['message'] = "Payment error: " . $e->getMessage();
    $_SESSION['message_type'] = "danger";
    
    // Redirect to orders page
    header('Location: ../orders.php');
    exit();
}
?> 