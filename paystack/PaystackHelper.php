<?php
/**
 * Paystack Helper Class
 * 
 * This class handles all Paystack API interactions including:
 * - Transaction initialization
 * - Transaction verification
 * - Logging
 * - Database operations
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../admin/config/dbcon.php';

class PaystackHelper {
    private $secretKey;
    private $publicKey;
    private $conn;
    
    public function __construct($conn) {
        $this->secretKey = PAYSTACK_SECRET_KEY;
        $this->publicKey = PAYSTACK_PUBLIC_KEY;
        $this->conn = $conn;
        
        // Create transactions table if it doesn't exist
        $this->createTransactionsTable();
    }
    
    /**
     * Initialize a Paystack transaction
     * Note: We don't store ANY transaction in DB until payment is successful
     */
    public function initializeTransaction($orderData) {
        try {
            // Prepare transaction data
            $transactionData = [
                'amount' => $this->convertToKobo($orderData['total_amount']),
                'email' => $orderData['email'],
                'reference' => $orderData['reference'],
                'callback_url' => PAYSTACK_CALLBACK_URL,
                'currency' => PAYSTACK_CURRENCY,
                'metadata' => [
                    'order_id' => $orderData['order_id'],
                    'user_id' => $orderData['user_id'],
                    'checkout_token' => $orderData['checkout_token'],
                    'custom_fields' => [
                        [
                            'display_name' => 'Order Number',
                            'variable_name' => 'order_number',
                            'value' => $orderData['shipment_number']
                        ],
                        [
                            'display_name' => 'Customer Name',
                            'variable_name' => 'customer_name',
                            'value' => $orderData['customer_name']
                        ]
                    ]
                ]
            ];
            
            // Make API request
            $response = $this->makeApiRequest(PAYSTACK_INITIALIZE_URL, $transactionData);
            
            if ($response['status']) {
                // Log successful initialization (but don't store in DB yet)
                $this->logTransaction('INITIALIZE', $orderData['reference'], $transactionData, $response);
                
                // Store transaction data in session for later use (no DB record yet)
                $this->storeTransactionInSession($orderData['reference'], $orderData, $response['data']);
                
                return [
                    'status' => true,
                    'data' => $response['data'],
                    'authorization_url' => $response['data']['authorization_url']
                ];
            } else {
                $this->logTransaction('INITIALIZE_ERROR', $orderData['reference'], $transactionData, $response);
                return [
                    'status' => false,
                    'message' => $response['message'] ?? 'Failed to initialize transaction'
                ];
            }
            
        } catch (Exception $e) {
            $this->logError('INITIALIZE_EXCEPTION', $e->getMessage(), $orderData);
            return [
                'status' => false,
                'message' => 'An error occurred while initializing the transaction'
            ];
        }
    }
    
    /**
     * Verify a Paystack transaction
     */
    public function verifyTransaction($reference) {
        try {
            $url = PAYSTACK_VERIFY_URL . $reference;
            $response = $this->makeApiRequest($url, [], 'GET');
            
            if ($response['status']) {
                $transaction = $response['data'];
                
                // Log verification
                $this->logTransaction('VERIFY', $reference, [], $response);
                
                // Don't automatically store/update - let the calling code handle it
                // This prevents conflicts with inline payment verification
                
                return [
                    'status' => true,
                    'data' => $transaction,
                    'is_successful' => $transaction['status'] === 'success'
                ];
            } else {
                $this->logTransaction('VERIFY_ERROR', $reference, [], $response);
                return [
                    'status' => false,
                    'message' => $response['message'] ?? 'Failed to verify transaction'
                ];
            }
            
        } catch (Exception $e) {
            $this->logError('VERIFY_EXCEPTION', $e->getMessage(), ['reference' => $reference]);
            return [
                'status' => false,
                'message' => 'An error occurred while verifying the transaction'
            ];
        }
    }
    
    /**
     * Clean up abandoned transactions (older than 24 hours)
     */
    public function cleanupAbandonedTransactions() {
        $sql = "DELETE FROM " . PAYSTACK_TRANSACTIONS_TABLE . " 
                WHERE status = 'pending' 
                AND created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        
        $this->conn->query($sql);
        
        $affectedRows = $this->conn->affected_rows;
        if ($affectedRows > 0) {
            $this->logError('CLEANUP', "Cleaned up $affectedRows abandoned transactions", []);
        }
        
        return $affectedRows;
    }
    
    /**
     * Make API request to Paystack
     */
    private function makeApiRequest($url, $data = [], $method = 'POST') {
        $headers = [
            'Authorization: Bearer ' . $this->secretKey,
            'Cache-Control: no-cache',
            'Content-Type: application/json'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            $this->logError('CURL_ERROR', $error, ['url' => $url, 'method' => $method]);
            throw new Exception('cURL Error: ' . $error);
        }
        
        $responseData = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logError('JSON_PARSE_ERROR', 'Invalid JSON response', ['response' => $response, 'url' => $url]);
            throw new Exception('Invalid JSON response: ' . $response);
        }
        
        // Log API errors for debugging
        if ($httpCode >= 400) {
            $this->logError('API_ERROR', "HTTP $httpCode: " . ($responseData['message'] ?? 'Unknown error'), [
                'url' => $url,
                'method' => $method,
                'http_code' => $httpCode,
                'response' => $responseData,
                'request_data' => $data
            ]);
        }
        
        return $responseData;
    }
    
    /**
     * Convert amount to kobo (smallest currency unit)
     */
    private function convertToKobo($amount) {
        return (int) ($amount * 100);
    }
    
    /**
     * Create transactions table if it doesn't exist
     */
    private function createTransactionsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS " . PAYSTACK_TRANSACTIONS_TABLE . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            reference VARCHAR(255) UNIQUE NOT NULL,
            order_id INT NOT NULL,
            user_id INT NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            currency VARCHAR(3) DEFAULT 'KES',
            status VARCHAR(50) NOT NULL DEFAULT 'success',
            payment_method VARCHAR(50) DEFAULT 'unknown',
            gateway_response TEXT,
            paid_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_reference (reference),
            INDEX idx_order_id (order_id),
            INDEX idx_user_id (user_id),
            INDEX idx_status (status),
            INDEX idx_payment_method (payment_method),
            INDEX idx_created_at (created_at)
        )";
        
        $this->conn->query($sql);
    }
    
    /**
     * Store transaction data in session (no database record)
     */
    private function storeTransactionInSession($reference, $orderData, $responseData) {
        if (!isset($_SESSION['paystack_pending_transactions'])) {
            $_SESSION['paystack_pending_transactions'] = [];
        }
        
        $_SESSION['paystack_pending_transactions'][$reference] = [
            'order_data' => $orderData,
            'response_data' => $responseData,
            'created_at' => time()
        ];
        
        // Clean up old session data (older than 1 hour)
        foreach ($_SESSION['paystack_pending_transactions'] as $ref => $data) {
            if (time() - $data['created_at'] > 3600) {
                unset($_SESSION['paystack_pending_transactions'][$ref]);
            }
        }
    }
    
    /**
     * Extract payment method from Paystack response
     */
    private function extractPaymentMethod($responseData) {
        // Debug: Log the response structure for troubleshooting
        error_log("Paystack Response Data: " . print_r($responseData, true));
        
        // Method 1: Check for channel = mobile_money (most reliable for M-Pesa STK)
        if (isset($responseData['data']['channel'])) {
            $channel = strtolower($responseData['data']['channel']);
            if ($channel === 'mobile_money') {
                return 'mpesa';
            }
        }
        
        // Method 2: Check for authorization channel = mobile_money
        if (isset($responseData['data']['authorization']['channel'])) {
            $channel = strtolower($responseData['data']['authorization']['channel']);
            if ($channel === 'mobile_money') {
                return 'mpesa';
            }
        }
        
        // Method 3: Check for bank = M-PESA
        if (isset($responseData['data']['authorization']['bank'])) {
            $bank = strtolower($responseData['data']['authorization']['bank']);
            if ($bank === 'm-pesa' || $bank === 'mpesa') {
                return 'mpesa';
            }
        }
        
        // Method 4: Check for brand = M-pesa
        if (isset($responseData['data']['authorization']['brand'])) {
            $brand = strtolower($responseData['data']['authorization']['brand']);
            if ($brand === 'm-pesa' || $brand === 'mpesa') {
                return 'mpesa';
            }
        }
        
        // Method 5: Check for mobile_money_number (specific to mobile money)
        if (isset($responseData['data']['authorization']['mobile_money_number'])) {
            return 'mpesa';
        }
        
        // Method 6: Check for mobile_money_provider
        if (isset($responseData['data']['authorization']['mobile_money_provider'])) {
            $provider = strtolower($responseData['data']['authorization']['mobile_money_provider']);
            if ($provider === 'mpesa') {
                return 'mpesa';
            }
        }
        
        // Method 7: Check for authorization_code pattern (M-Pesa codes start with QK, QL, etc.)
        if (isset($responseData['data']['authorization']['authorization_code'])) {
            $authCode = $responseData['data']['authorization']['authorization_code'];
            if (preg_match('/^Q[KL]/', $authCode)) {
                return 'mpesa';
            }
        }
        
        // Method 8: Check for country_code (Kenya) and no card info
        if (isset($responseData['data']['authorization']['country_code'])) {
            $countryCode = strtolower($responseData['data']['authorization']['country_code']);
            if ($countryCode === 'ke') {
                // If it's Kenya and no card info, likely M-Pesa
                if (!isset($responseData['data']['authorization']['card_type']) && 
                    !isset($responseData['data']['authorization']['last4'])) {
                    return 'mpesa';
                }
            }
        }
        
        // Method 9: Check for account_name (M-Pesa shows phone number)
        if (isset($responseData['data']['authorization']['account_name'])) {
            $accountName = $responseData['data']['authorization']['account_name'];
            if (preg_match('/^\d{10,12}$/', $accountName)) {
                return 'mpesa';
            }
        }
        
        // Method 10: Check for gateway_response text
        if (isset($responseData['data']['authorization']['gateway_response'])) {
            $gatewayResponse = strtolower($responseData['data']['authorization']['gateway_response']);
            if (strpos($gatewayResponse, 'mpesa') !== false || 
                strpos($gatewayResponse, 'mobile money') !== false) {
                return 'mpesa';
            }
        }
        
        // Check for domain in the response (this is the most reliable indicator)
        if (isset($responseData['data']['domain'])) {
            $domain = strtolower($responseData['data']['domain']);
            switch ($domain) {
                case 'card':
                    return 'card';
                case 'mobile_money':
                    return 'mpesa';
                case 'bank':
                    return 'bank';
                case 'ussd':
                    return 'ussd';
                default:
                    return $domain;
            }
        }
        
        // Check for payment_type in the response
        if (isset($responseData['data']['payment_type'])) {
            $paymentType = strtolower($responseData['data']['payment_type']);
            switch ($paymentType) {
                case 'card':
                    return 'card';
                case 'mobile_money':
                    return 'mpesa';
                case 'bank':
                    return 'bank';
                default:
                    return $paymentType;
            }
        }
        
        // Check for gateway_response in the response (nested response)
        if (isset($responseData['data']['gateway_response'])) {
            $gatewayResponse = strtolower($responseData['data']['gateway_response']);
            if (strpos($gatewayResponse, 'mpesa') !== false) {
                return 'mpesa';
            } elseif (strpos($gatewayResponse, 'card') !== false) {
                return 'card';
            } elseif (strpos($gatewayResponse, 'bank') !== false) {
                return 'bank';
            }
        }
        
        return 'unknown';
    }
    
    /**
     * Store successful transaction in database (only when payment succeeds)
     */
    private function storeSuccessfulTransaction($reference, $responseData) {
        // Get order data from session or reconstruct from metadata
        $orderData = null;
        
        // Check for inline payment data first (from order-confirmation.php)
        if (isset($_SESSION['inline_payment_data'])) {
            $orderData = $_SESSION['inline_payment_data'];
        } elseif (isset($_SESSION['paystack_pending_transactions'][$reference])) {
            $orderData = $_SESSION['paystack_pending_transactions'][$reference]['order_data'];
            // Clean up session data
            unset($_SESSION['paystack_pending_transactions'][$reference]);
        } else {
            // Fallback: extract from Paystack metadata
            $metadata = $responseData['metadata'] ?? [];
            $orderData = [
                'order_id' => $metadata['order_id'] ?? 0,
                'user_id' => $metadata['user_id'] ?? 0,
                'total_amount' => $responseData['amount'] / 100
            ];
        }
        
        $amount = $orderData['total_amount'] ?? ($responseData['amount'] / 100);
        $paymentMethod = $this->extractPaymentMethod($responseData);
        
        $sql = "INSERT INTO " . PAYSTACK_TRANSACTIONS_TABLE . " 
                (reference, order_id, user_id, amount, currency, status, payment_method, gateway_response, paid_at) 
                VALUES (?, ?, ?, ?, 'KES', 'success', ?, ?, NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $gatewayResponse = json_encode($responseData);
        $stmt->bind_param("siidss", $reference, $orderData['order_id'], $orderData['user_id'], $amount, $paymentMethod, $gatewayResponse);
        $stmt->execute();
        $stmt->close();
    }
    
    /**
     * Update order status when payment is successful
     */
    private function updateOrderStatus($reference, $status) {
        // Get order_id from session or database
        $orderId = null;
        
        // Check for inline payment data first (from order-confirmation.php)
        if (isset($_SESSION['inline_payment_data']) && isset($_SESSION['inline_payment_data']['order_id'])) {
            $orderId = $_SESSION['inline_payment_data']['order_id'];
        } elseif (isset($_SESSION['paystack_pending_transactions'][$reference])) {
            $orderId = $_SESSION['paystack_pending_transactions'][$reference]['order_data']['order_id'];
        } else {
            // Get from database if not in session
            $sql = "SELECT order_id FROM " . PAYSTACK_TRANSACTIONS_TABLE . " WHERE reference = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $reference);
            $stmt->execute();
            $result = $stmt->get_result();
            $transaction = $result->fetch_assoc();
            $stmt->close();
            
            if ($transaction) {
                $orderId = $transaction['order_id'];
            }
        }
        
        if ($orderId) {
            $sql = "UPDATE checkout SET status = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $status, $orderId);
            $stmt->execute();
            $stmt->close();
        }
    }
    
    /**
     * Log transaction
     */
    private function logTransaction($action, $reference, $requestData, $responseData) {
        if (!PAYSTACK_LOG_ENABLED) return;
        
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'action' => $action,
            'reference' => $reference,
            'request' => $requestData,
            'response' => $responseData
        ];
        
        file_put_contents(PAYSTACK_LOG_FILE, json_encode($logEntry) . "\n", FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Log error
     */
    private function logError($action, $error, $context = []) {
        if (!PAYSTACK_LOG_ENABLED) return;
        
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'action' => $action,
            'error' => $error,
            'context' => $context
        ];
        
        file_put_contents(PAYSTACK_LOG_FILE, json_encode($logEntry) . "\n", FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Get transaction by reference
     */
    public function getTransaction($reference) {
        $sql = "SELECT * FROM " . PAYSTACK_TRANSACTIONS_TABLE . " WHERE reference = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $reference);
        $stmt->execute();
        $result = $stmt->get_result();
        $transaction = $result->fetch_assoc();
        $stmt->close();
        
        return $transaction;
    }
    
    /**
     * Get public key for frontend
     */
    public function getPublicKey() {
        return $this->publicKey;
    }
}
?> 